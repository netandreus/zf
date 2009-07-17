<?php

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'Zend/Feed/Reader.php';

class Zend_Feed_Reader_Integration_WordpressAtom10Test extends PHPUnit_Framework_TestCase
{

    protected $_feedSamplePath = null;

    public function setup()
    {
        $this->_feedSamplePath = dirname(__FILE__) . '/_files/wordpress-atom10.xml';
    }

    public function testGetsTitle()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $this->assertEquals('Norm 2782', $feed->getTitle());
    }

    public function testGetsAuthors()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $this->assertEquals(array('norm2782'), $feed->getAuthors());
    }

    public function testGetsSingleAuthor()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $this->assertEquals('norm2782', $feed->getAuthor());
    }

    public function testGetsCopyright()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $this->assertEquals(null, $feed->getCopyright());
    }

    public function testGetsDescription()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $this->assertEquals('Why are you here?', $feed->getDescription());
    }

    public function testGetsLanguage()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $this->assertEquals('en', $feed->getLanguage());
    }

    public function testGetsLink()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $this->assertEquals('http://www.norm2782.com', $feed->getLink());
    }

    public function testGetsEncoding()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $this->assertEquals('UTF-8', $feed->getEncoding());
    }

    public function testGetsEntryCount()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $this->assertEquals(10, $feed->count());
    }

    /**
     * Entry level testing
     */

    public function testGetsEntryId()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $entry = $feed->current();
        $this->assertEquals('http://www.norm2782.com/?p=114', $entry->getId());
    }

    public function testGetsEntryTitle()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $entry = $feed->current();
        /**
         * Note: The three dots below is actually a single Unicode character
         * called the "three dot leader". Don't replace in error!
         */
        $this->assertEquals('Wth… reading books?', $entry->getTitle());
    }

    public function testGetsEntryAuthors()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $entry = $feed->current();
        $this->assertEquals(array('norm2782'), $entry->getAuthors());
    }

    public function testGetsEntrySingleAuthor()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $entry = $feed->current();
        $this->assertEquals('norm2782', $entry->getAuthor());
    }

    public function testGetsEntryDescription()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $entry = $feed->current();
        /**
         * Note: "’" is not the same as "'" - don't replace in error
         */
        $this->assertEquals('Being in New Zealand does strange things to a person. Everybody who knows me, knows I don’t much like that crazy invention called a Book. However, being here I’ve already finished 4 books, all of which I can highly recommend.'."\n\n".'Agile Software Development with Scrum, by Ken Schwaber and Mike Beedle'."\n".'Domain-Driven Design: Tackling Complexity in the [...]', $entry->getDescription());
    }

    public function testGetsEntryContent()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $entry = $feed->current();
        $this->assertEquals('<p>Being in New Zealand does strange things to a person. Everybody who knows me, knows I don’t much like that crazy invention called a Book. However, being here I’ve already finished 4 books, all of which I can highly recommend.</p>'."\n\n".'<ul>'."\n".'<li><a href="http://www.amazon.com/Agile-Software-Development-Scrum/dp/0130676349/">Agile Software Development with Scrum, by Ken Schwaber and Mike Beedle</a></li>'."\n".'<li><a href="http://www.amazon.com/Domain-Driven-Design-Tackling-Complexity-Software/dp/0321125215/">Domain-Driven Design: Tackling Complexity in the Heart of Software, by Eric Evans</a></li>'."\n".'<li><a href="http://www.amazon.com/Enterprise-Application-Architecture-Addison-Wesley-Signature/dp/0321127420/">Patterns of Enterprise Application Architecture, by Martin Fowler</a></li>'."\n".'<li><a href="http://www.amazon.com/Refactoring-Improving-Existing-Addison-Wesley-Technology/dp/0201485672/">Refactoring: Improving the Design of Existing Code by Martin Fowler</a></li>'."\n\n".'</ul>'."\n".'<p>Next up: <a href="http://www.amazon.com/Design-Patterns-Object-Oriented-Addison-Wesley-Professional/dp/0201633612/">Design Patterns: Elements of Reusable Object-Oriented Software, by the Gang of Four</a>. Yes, talk about classics and shame on me for not having ordered it sooner! Also reading <a href="http://www.amazon.com/Implementation-Patterns-Addison-Wesley-Signature-Kent/dp/0321413091/">Implementation Patterns, by Kent Beck</a> at the moment.</p>'."\n", $entry->getContent());
    }

    public function testGetsEntryLinks()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $entry = $feed->current();
        $this->assertEquals(array('http://www.norm2782.com/2009/03/wth-reading-books/'), $entry->getLinks());
    }

    public function testGetsEntryLink()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $entry = $feed->current();
        $this->assertEquals('http://www.norm2782.com/2009/03/wth-reading-books/', $entry->getLink());
    }

    public function testGetsEntryPermaLink()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $entry = $feed->current();
        $this->assertEquals('http://www.norm2782.com/2009/03/wth-reading-books/',
            $entry->getPermaLink());
    }

    public function testGetsEntryEncoding()
    {
        $feed = Zend_Feed_Reader::importString(
            file_get_contents($this->_feedSamplePath)
        );
        $entry = $feed->current();
        $this->assertEquals('UTF-8', $entry->getEncoding());
    }

}