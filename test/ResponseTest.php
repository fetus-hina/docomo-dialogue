<?php
use jp3cki\docomoDialogue\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase {
    public function testConstruct() {
        $o = new Response(
            json_decode(
                '{"utt":"\u3053\u3093\u306b\u3061\u306f\u5149\u3055\u3093","yomi":"\u3053\u3093\u306b\u3061\u306f\u30d2\u30ab\u30ea\u3055\u3093","mode":"dialog","da":"0","context":"aaabbb111222"}'
            )
        );
        $this->assertEquals('こんにちは光さん', $o->getText());
        $this->assertEquals('こんにちはヒカリさん', $o->getYomi());
        $this->assertEquals('dialog', $o->getMode());
        $this->assertEquals(0, $o->getNumber());
        $this->assertEquals('aaabbb111222', $o->getContext());

        $this->assertEquals('こんにちは光さん', $o->utt);
        $this->assertEquals('こんにちはヒカリさん', $o->yomi);
        $this->assertEquals('dialog', $o->mode);
        $this->assertEquals(0, $o->da);
        $this->assertEquals('aaabbb111222', $o->context);
    }

    // issue #2
    public function testToString() {
        $o = new Response(
            json_decode(
                '{"utt":"\u3053\u3093\u306b\u3061\u306f\u5149\u3055\u3093","yomi":"\u3053\u3093\u306b\u3061\u306f\u30d2\u30ab\u30ea\u3055\u3093","mode":"dialog","da":"0","context":"aaabbb111222"}'
            )
        );
        $this->assertTrue(is_string($o->__toString()));
        $this->assertTrue($o->__toString() !== '');
        $this->assertTrue($o->__toString() !== '{}');
    }
}
