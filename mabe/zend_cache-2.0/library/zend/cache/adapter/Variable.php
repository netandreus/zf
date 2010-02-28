<?php

namespace zend\cache\adapter;

class Variable extends AdapterAbstract
{

    protected $_capabilities = array();
    protected $_data = array();

    public function getCapabilities()
    {
        return $this->_capabilities;
    }

    public function set($value, $key = null, array $options = array())
    {
        $key = $this->_key($key);
        $ns  = isset($options['namespace']) ? $options['namespace'] : '';
        $ttl = isset($options['ttl']) ? $this->_ttl($options['ttl']) : $this->_ttl;
        $this->_data[$ns][$key] = array($value, time(), $ttl);
        return true;
    }

    public function add($value, $key = null, array $options = array())
    {
        $key = $this->_key($key);
        $ns  = isset($options['namespace']) ? $options['namespace'] : '';
        $ttl = isset($options['ttl']) ? $this->_ttl($options['ttl']) : $this->_ttl;
        if (isset($this->_data[$ns][$key])) {
            throw new \Exception("Key '$key' already exists within namespace '$ns'");
        }
        $this->_data[$ns][$key] = array($value, time(), $ttl);
        return true;
    }

    public function replace($value, $key = null, array $options = array())
    {
        $key = $this->_key($key);
        $ns  = isset($options['namespace']) ? $options['namespace'] : '';
        $ttl = isset($options['ttl']) ? $this->_ttl($options['ttl']) : $this->_ttl;
        if (!isset($this->_data[$ns][$key])) {
            throw new \Exception("Key '$key' doen't exists within namespace '$ns'");
        }
        $this->_data['ns'][$key] = array($value, time(), $ttl);
        return true;
    }


    public function get($key = null, array $options = array())
    {
        $key = $this->_key($key);
        $ns  = isset($options['namespace']) ? $options['namespace'] : '';
        if (isset($this->_data[$ns][$key])) {
            // @todo: check if expired
            return $this->_data[$ns][$key][0];
        }
        return false;
    }

    public function exists($key = null, array $options = array())
    {
        $key = $this->_key($key);
        $ns  = isset($options['namespace']) ? $options['namespace'] : '';
        if (isset($this->_data[$ns][$key])) {
            // @todo: check if expired
            return true;
        }
        return false;
    }

    public function info($key = null, array $options = array())
    {
        $key = $this->_key($key);
        $ns  = isset($options['namespace']) ? $options['namespace'] : '';
        if (isset($this->_data[$ns][$key])) {
            return array(
                'mtime' => $this->_data[$ns][$key][1],
                'ttl'   => $this->_data[$ns][$key][2]
            );
        }
        return false;
    }


    public function remove($key = null, array $options = array())
    {
        $key = $this->_key($key);
        $ns  = isset($options['namespace']) ? $options['namespace'] : '';
        if (isset($this->_data[$ns][$key])) {
            if (count($this->_data[$ns]) > 1) {
                unset($this->_data[$ns][$key]);
            } else {
                // remove namespace if key is the only content
                unset($this->_data[$ns]);
            }
        }

        return true;
    }


    public function increment($value, $key = null, array $options = array())
    {
        $key   = $this->_key($key);
        $ns    = isset($options['namespace']) ? $options['namespace'] : '';
        $ttl   = isset($options['ttl']) ? $this->_ttl($options['ttl']) : $this->_ttl;
        $value = (int)$value;
        if (isset($this->_data[$ns][$key])) {
            $this->_data[$ns][$key][0]+= $value;
            $this->_data[$ns][$key][1] = time();
            $this->_data[$ns][$key][2] = $ttl;
        } else {
            $this->_data[$ns][$key] = array($value, time(), $ttl);
        }
    }

    public function decrement($value, $key = null, array $options = array())
    {
        $key   = $this->_key($key);
        $ns    = isset($options['namespace']) ? $options['namespace'] : '';
        $ttl   = isset($options['ttl']) ? $this->_ttl($options['ttl']) : $this->_ttl;
        $value = (int)$value;
        if (isset($this->_data[$ns][$key])) {
            $this->_data[$ns][$key][0]-= $value;
            $this->_data[$ns][$key][1] = time();
            $this->_data[$ns][$key][2] = $ttl;
        } else {
            $this->_data[$ns][$key] = array($value, time(), $ttl);
        }
    }


    public function clear($mode, array $options = array())
    {
        $ns = isset($options['namespace']) ? $options['namespace'] : '';
        foreach ($this->find($mode, $options) as $key) {
            unset($this->_data[$ns][$key]);
        }
    }

    public function find($mode, array $options=array())
    {
        $ns = isset($options['namespace']) ? $options['namespace'] : '';
        if (!isset($this->_data[$ns])) {
            return array();
        }

        $keys = array();
        foreach ($this->_data[$ns] as $key => $info) {

            // if MATCHING_ALL mode do not check expired
            if ( ($mode & \zend\Cache::MATCHING_ALL) != \zend\Cache::MATCHING_ALL
              && ($mode & \zend\Cache::MATCHING_ALL) != 0 ) {

                // if Zend_Cache::MATCHING_EXPIRED mode selected do not remove active data
                if (($mode & \zend\Cache::MATCHING_EXPIRED) == \zend\Cache::MATCHING_EXPIRED) {
                    if ( time() <= ($info[1]+$info[2]) ) {
                        continue;
                    }

                // if Zend_Cache::MATCHING_ACTIVE mode selected do not remove expired data
                } else {
                    if ( time() > ($info[1]+$info[2]) ) {
                        continue;
                    }
                }
            }

            ////////////////////////////////////////
            // on this time all expire tests match
            ////////////////////////////////////////

            // if one of the tag matching mode is selected
            if (($mode & 070) > 0) {

                // if MATCHING_TAGS mode -> check if all given tags available in current cache
                if (($mode & \zend\Cache::MATCHING_TAGS) == \zend\Cache::MATCHING_TAGS ) {
                    if (count(array_diff($opts['tags'], $info[3])) > 0) {
                        continue;
                    }

                // if MATCHING_NO_TAGS mode -> check if no given tag available in current cache
                } elseif( ($mode & \zend\Cache::MATCHING_NO_TAGS) == \zend\Cache::MATCHING_NO_TAGS ) {
                    if (count(array_diff($opts['tags'], $info[3])) != count($opts['tags'])) {
                        continue;
                    }

                // if MATCHING_ANY_TAGS mode -> check if any given tag available in current cache
                } elseif ( ($mode & \zend\Cache::MATCHING_ANY_TAGS) == \zend\Cache::MATCHING_ANY_TAGS ) {
                    if (count(array_diff($opts['tags'], $info[3])) == count($opts['tags'])) {
                        continue;
                    }

                }
            }

            ////////////////////////////////////////
            // on this time all tag tests match
            ////////////////////////////////////////

            $keys[] = $id;
        }

        return  $keys;
    }


    public function status(array $options=array())
    {
        return $this->_getStatusOfPhpMem($options);
    }

}

