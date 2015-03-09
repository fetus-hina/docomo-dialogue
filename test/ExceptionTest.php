<?php
namespace jp3cki\docomoDialogue\test;

use jp3cki\docomoDialogue\DomainError;
use jp3cki\docomoDialogue\Exception;
use jp3cki\docomoDialogue\InvalidArgumentException;

class ExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHierarchy()
    {
        $var = new Exception();
        $this->assertInstanceOf('\Exception', $var);

        $var = new DomainError();
        $this->assertInstanceOf(Exception::className(), $var);

        $var = new InvalidArgumentException();
        $this->assertInstanceOf(Exception::className(), $var);
    }
}
