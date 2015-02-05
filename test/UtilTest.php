<?php
use jp3cki\docomoDialogue\Util;

class UtilTest extends \PHPUnit_Framework_TestCase {
    public function testAsIs() {
        $text = 'ABCabc012あいうアイウ亜伊宇ＡＢＣａｂｃ０１２αβабв①Ⅱⅲ';
        $this->assertEquals($text, Util::toSjisSafe($text));
    }

    public function testConvert() {
        $text = 'あいうえお€かきくけこ';
        $geta = 'あいうえお〓かきくけこ';
        $this->assertEquals($geta, Util::toSjisSafe($text, 0x3013));

        $space = 'あいうえお かきくけこ';
        $this->assertEquals($space, Util::toSjisSafe($text, 0x20));
    }
}
