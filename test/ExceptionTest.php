<?php
use jp3cki\docomoDialogue\DomainError;
use jp3cki\docomoDialogue\Exception;
use jp3cki\docomoDialogue\InvalidArgumentException;

class ExceptionTest extends \PHPUnit_Framework_TestCase {
    public function testHierarchy() {
        $var = new Exception();
        $this->assertTrue($var instanceof \Exception);

        $var = new DomainError();
        $this->assertTrue($var instanceof \Exception);
        $this->assertTrue($var instanceof Exception);

        $var = new InvalidArgumentException();
        $this->assertTrue($var instanceof \Exception);
        $this->assertTrue($var instanceof Exception);
    }
}
