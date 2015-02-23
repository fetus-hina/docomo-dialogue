<?php
use jp3cki\docomoDialogue\Dialogue;
use jp3cki\docomoDialogue\RequestParameter;
use jp3cki\docomoDialogue\Response;

class DialogueTest extends \PHPUnit_Framework_TestCase {
    private function getApiKey() {
        $path = __DIR__ . '/config.ini';
        if(!file_exists($path)) {
            return false;
        }
        $ini = @parse_ini_file($path, true, INI_SCANNER_RAW);
        if(!$ini || !isset($ini['docomo']['dialogue_api_key'])) {
            return false;
        }
        return $ini['docomo']['dialogue_api_key'];
    }

    public function testClassName() {
        $this->assertEquals('jp3cki\docomoDialogue\Dialogue', Dialogue::className());
    }

    public function testConstruct() {
        $o = new Dialogue('DUMMY-API-KEY');
        $this->assertEquals('DUMMY-API-KEY', $o->apikey);
    }

    public function testParameter() {
        $o = new Dialogue('DUMMY-API-KEY');
        $this->assertInstanceOf(RequestParameter::className(), $o->parameter);
        $this->assertInstanceOf(RequestParameter::className(), $o->getParameter());
        $this->assertNull($o->hoge);
    }

    public function testRequest() {
        $key = $this->getApiKey();
        if(!$key) {
            $this->markTestSkipped('config.iniにAPIKEYが設定されていません');
            return;
        }
        $o = new Dialogue($key);
        $o->parameter->setUserInput('こんにちは');
        $o->parameter->user->setNickname('テスト');
        $this->assertInstanceOf(Response::className(), $o->request());
    }
}
