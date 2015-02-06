<?php
use jp3cki\docomoDialogue\RequestParameter;
use jp3cki\docomoDialogue\UserInformation;

class RequestParameterTest extends \PHPUnit_Framework_TestCase {
    public function testUserInput() {
        $o = new RequestParameter();
        $p = $o->setUserInput('あいうえお');
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals('あいうえお', $o->getUserInput());
        $this->assertEquals('あいうえお', $o->utt);
        $o->utt = 'かきくけこ';
        $this->assertEquals('かきくけこ', $o->getUserInput());
        $o->setUserInput(str_repeat('あ', 255));
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testUserInputLengthException() {
        $o = new RequestParameter();
        $o->setUserInput(str_repeat('あ', 256));
    }

    public function testContext() {
        $o = new RequestParameter();
        $p = $o->setContext('abcdefg');
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals('abcdefg', $o->getContext());
        $this->assertEquals('abcdefg', $o->context);
        $o->context = 'xyz';
        $this->assertEquals('xyz', $o->getContext());
        $o->setContext(str_repeat('a', 255));
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testContextLengthException() {
        $o = new RequestParameter();
        $o->setContext(str_repeat('a', 256));
    }

    public function testMode() {
        $o = new RequestParameter();
        $p = $o->setMode(RequestParameter::MODE_DIALOG);
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals(RequestParameter::MODE_DIALOG, $o->getMode());
        $this->assertEquals(RequestParameter::MODE_DIALOG, $o->mode);
        $this->assertEquals(RequestParameter::MODE_SRTR, $o->setMode(RequestParameter::MODE_SRTR)->getMode());
        $this->assertEquals(null, $o->setMode(null)->getMode());
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testModeException() {
        $o = new RequestParameter();
        $o->setMode('hoge');
    }

    public function testCharacter() {
        $o = new RequestParameter();
        $p = $o->setCharacter(RequestParameter::CHARACTER_KANSAI);
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals(RequestParameter::CHARACTER_KANSAI, $o->getCharacter());
        $this->assertEquals(RequestParameter::CHARACTER_KANSAI, $o->t);
        $this->assertEquals(RequestParameter::CHARACTER_BABY, $o->setCharacter(RequestParameter::CHARACTER_BABY)->getCharacter());
        $this->assertEquals(RequestParameter::CHARACTER_DEFAULT, $o->setCharacter(RequestParameter::CHARACTER_DEFAULT)->getCharacter());
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testCharacterException() {
        $o = new RequestParameter();
        $o->setCharacter('hoge');
    }

    public function testUserInformation() {
        $o = new RequestParameter();
        // デフォルトでちゃんと返ってくる
        $this->assertInstanceOf(UserInformation::className(), $o->getuserInformation());
    }

    public function testMakeParameter() {
        $o = new RequestParameter();
        $this->assertTrue(is_array($o->makeParameter()));
    }
}
