<?php
use jp3cki\docomoDialogue\Dialogue;
use jp3cki\docomoDialogue\RequestParameter;

class DialogueTest extends \PHPUnit_Framework_TestCase {
    public function testConstruct() {
        $o = new Dialogue('DUMMY-API-KEY');
        $this->assertEquals('DUMMY-API-KEY', $o->apikey);
    }

    public function testParameter() {
        $o = new Dialogue('DUMMY-API-KEY');
        $this->assertTrue($o->parameter instanceof RequestParameter);
        $this->assertTrue($o->getParameter() instanceof RequestParameter);
    }
}
