<?php
/**
 * docomo雑談対話APIメインクラス
 * @author AIZAWA Hina <hina@bouhime.com>
 * @copyright 2015 by AIZAWA Hina <hina@bouhime.com>
 * @license https://github.com/fetus-hina/docomo-dialogue/blob/master/LICENSE MIT
 * @since 0.1.0
 */

namespace jp3cki\docomoDialogue;

use \Curl\Curl;

/**
 * docomo雑談対話APIメインクラス
 *
 * @property-read   string              $apikey     docomo API Key
 * @property-read   RequestParameter    $parameter  送信パラメータ管理クラス
 */
class Dialogue
{
    /** docomo側エンドポイントURL */
    const END_POINT_URL = 'https://api.apigw.smt.docomo.ne.jp/dialogue/v1/dialogue';

    /** @internal @var string */
    private $apikey;

    /** @internal @var RequestParameter */
    private $request;

    /**
     * コンストラクタ
     *
     * @param string $apikey docomo API Key
     */
    public function __construct($apikey)
    {
        $this->apikey = $apikey;
    }

    /**
     * マジックメソッド __get
     *
     * @param string $key プロパティ名
     * @return mixed
     */
    public function __get($key)
    {
        switch($key) {
            case 'apikey':
                return $this->apikey;
            case 'parameter':
                return $this->getParameter();
        }
    }

    /**
     * 送信パラメータ管理クラスを取得
     *
     * @return RequestParameter
     */
    public function getParameter()
    {
        if (!$this->request) {
            $this->request = new RequestParameter();
        }
        return $this->request;
    }

    /**
     * docomoへリクエストを送信し、対話内容を得る
     *
     * @return Response|false
     */
    public function request()
    {
        $reqUrl = sprintf('%s?APIKEY=%s', self::END_POINT_URL, rawurlencode($this->apikey));
        $reqBody = json_encode($this->getParameter()->makeParameter());

        $curl = new Curl();
        $curl->setHeader('Content-Type', 'application/json; charset=UTF-8');
        $ret = $curl->post($reqUrl, $reqBody);
        if ($curl->error) {
            trigger_error('docomo dialogue: Error ' . $curl->errorCode . ': ' . $curl->errorMessage, E_USER_WARNING);
            return false;
        }
        return new Response($ret);
    }

    /**
     * クラス名(FQCN)を取得
     *
     * return string
     */
    public static function className()
    {
        return get_called_class();
    }
}
