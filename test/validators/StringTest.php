<?php
namespace jp3cki\docomoDialogue\test\validators;

use jp3cki\docomoDialogue\validators\String as StringValidator;
use jp3cki\docomoDialogue\DomainError;

class StringTest extends \PHPUnit_Framework_TestCase
{
    public function testClassName()
    {
        $this->assertEquals('jp3cki\docomoDialogue\validators\String', StringValidator::className());
    }

    /**
     * @dataProvider lengthDataProvider
     */
    public function testValidate($successful, $value, $maxLength)
    {
        if (!$successful) {
            $this->setExpectedException(DomainError::className());
        }
        $ret = StringValidator::validate($value, $maxLength, 'ERROR');
        $this->assertTrue($ret);
    }

    public function lengthDataProvider()
    {
        return [
            [true, str_repeat('あ', 100), 101],
            [true, str_repeat('あ', 100), 100],
            [false, str_repeat('あ', 100), 99],
        ];
    }
}
