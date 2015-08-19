<?php
/**
 * docomoから返答されたデータ
 * @author AIZAWA Hina <hina@bouhime.com>
 * @copyright 2015 by AIZAWA Hina <hina@bouhime.com>
 * @license https://github.com/fetus-hina/docomo-dialogue/blob/master/LICENSE MIT
 * @since 0.1.0
 */

namespace jp3cki\docomoDialogue;

use stdClass;

/**
 * docomoから返答されたデータ
 *
 * @property-read string $utt            ユーザへ返答するテキスト
 * @property-read string $yomi           音声合成にシステム返答を読ませるための出力
 * @property-read string $context        コンテキストID
 * @property-read string $mode           会話モード
 * @property-read int    $da             ユーザとシステムの対話に対してサーバが付与した番号
 */
class Response
{
    /** @internal */
    private $parameters = [
        'utt'       => null,
        'yomi'      => null,
        'context'   => null,
        'mode'      => null,
        'da'        => null,
    ];

    /**
     * コンストラクタ
     *
     * @param \stdClass $response サーバからの応答をJSONデコードしたもの
     */
    public function __construct(stdClass $response)
    {
        foreach (['utt', 'yomi', 'mode', 'context'] as $key) {
            if (isset($response->$key)) {
                $this->parameters[$key] = (string)$response->$key;
            }
        }
        foreach (['da'] as $key) {
            if (isset($response->$key)) {
                $this->parameters[$key] = (int)(string)$response->$key;
            }
        }
    }

    /**
     * マジックメソッド __toString
     *
     * デバッグ等で表示する際に中身がわかるように JSON で返すだけで、
     * 表現そのものに意味はないし依存してはならない
     *
     * @return string
     */
    public function __toString()
    {
        $data = [];
        foreach ($this->parameters as $k => $v) {
            if ($v !== null) {
                $data[$k] = $v;
            }
        }
        return json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    /**
     * マジックメソッド __get
     *
     * @param   string  $key    プロパティ取得用のキー
     * @return  string          キーに対応する値
     */
    public function __get($key)
    {
        switch ($key) {
            case 'utt':
                return $this->getText();
            case 'yomi':
                return $this->getYomi();
            case 'context':
                return $this->getContext();
            case 'mode':
                return $this->getMode();
            case 'da':
                return $this->getNumber();
        }
    }

    /**
     * システムからの返答テキストを取得する
     *
     * @return string
     */
    public function getText()
    {
        return $this->parameters['utt'];
    }

    /**
     * 音声合成にシステム返答を読ませるための出力を取得する
     *
     * @return string
     */
    public function getYomi()
    {
        return $this->parameters['yomi'];
    }

    /**
     * コンテキストIDを取得する
     *
     * @return string
     */
    public function getContext()
    {
        return $this->parameters['context'];
    }

    /**
     * 対話のモードを取得する
     *
     * @return string
     */
    public function getMode()
    {
        return $this->parameters['mode'];
    }

    /**
     * ユーザとシステムの対話に対してサーバが付与した番号を取得する
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->parameters['da'];
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
