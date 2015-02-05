<?php
namespace jp3cki\docomoDialogue;
use \Curl\Curl;

class Dialogue {
    const END_POINT_URL = 'https://api.apigw.smt.docomo.ne.jp/dialogue/v1/dialogue';

    private $apikey;
    private $request;

    public function __construct($apikey) {
        $this->apikey = $apikey;
    }

    public function __get($key) {
        switch($key) {
        case 'apikey':      return $this->apikey;
        case 'parameter':   return $this->getParameter();
        }
    }

    public function getParameter() {
        if(!$this->request) {
            $this->request = new RequestParameter();
        }
        return $this->request;
    }

    public function request() {
        $req_url = sprintf('%s?APIKEY=%s', self::END_POINT_URL, rawurlencode($this->apikey));
        $req_body = json_encode($this->getParameter()->makeParameter());

        $curl = new Curl();
        $curl->setHeader('Content-Type', 'application/json; charset=UTF-8');
        $ret = $curl->post($req_url, $req_body);
        if($curl->error) {
            trigger_error('docomo dialogue: Error ' . $curl->error_code . ': ' . $curl->error_message, E_USER_WARNING);
            return false;
        }
        return $ret;
    }
}
