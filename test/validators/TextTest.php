<?php
namespace jp3cki\docomoDialogue\test\validators;

use jp3cki\docomoDialogue\validators\Text as TextValidator;
use jp3cki\docomoDialogue\DomainError;

class TextTest extends \PHPUnit_Framework_TestCase
{
    public function testClassName()
    {
        $this->assertEquals('jp3cki\docomoDialogue\validators\Text', TextValidator::className());
    }

    /**
     * @dataProvider lengthDataProvider
     */
    public function testValidate($successful, $value, $maxLength)
    {
        if (!$successful) {
            $this->setExpectedException(DomainError::className());
        }
        $ret = TextValidator::validate($value, $maxLength, 'ERROR');
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
