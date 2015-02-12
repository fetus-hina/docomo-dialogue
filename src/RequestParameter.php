<?php
/**
 * 送信パラメータ管理クラス
 * @author AIZAWA Hina <hina@bouhime.com>
 * @copyright 2015 by AIZAWA Hina <hina@bouhime.com>
 * @license https://github.com/fetus-hina/docomo-dialogue/blob/master/LICENSE MIT
 * @since 0.1.0
 */

namespace jp3cki\docomoDialogue;

/**
 * 送信パラメータ管理クラス
 *
 * @property string $utt            ユーザ入力テキスト
 * @property string $context        コンテキストID
 * @property string $mode           会話モード
 * @property int    $t              チャットキャラクター
 * @property UserInformation $user  ユーザ情報
 */
class RequestParameter {
    /** デフォルトのキャラクター */
    const CHARACTER_DEFAULT = null;
    /** 関西弁のキャラクター */
    const CHARACTER_KANSAI  = 20;
    /** 赤ちゃんキャラクター */
    const CHARACTER_BABY    = 30;

    /** 対話モード */
    const MODE_DIALOG       = 'dialog';
    /** しりとりモード */
    const MODE_SRTR         = 'srtr';

    /** @internal @var array */
    private $parameters;

    /** @internal @var UserInformation */
    private $user_info = null;

    /**
     * コンストラクタ
     */
    public function __construct() {
        $this->reset();
    }

    /**
     * マジックメソッド __toString
     *
     * デバッグ等で表示する際に中身がわかるように JSON で返すだけで、
     * 表現そのものに意味はないし依存してはならない
     *
     * @return string
     */
    public function __toString() {
        return json_encode($this->makeParameter(), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE);
    }

    /**
     * マジックメソッド __get
     *
     * @param   string  $key    プロパティ取得用のキー
     * @return  string          キーに対応する値
     */
    public function __get($key) {
        switch($key) {
        case 'utt':                 return $this->getUserInput();
        case 'context':             return $this->getContext();
        case 'mode':                return $this->getMode();
        case 't':                   return $this->getCharacter();
        case 'user':                return $this->getUserInformation();
        }
    }

    /**
     * マジックメソッド __set
     *
     * @param   string  $key    プロパティ設定用のキー
     * @param   mixed   $value  設定する値
     *
     * @throws  InvalidArgumentException    対応するキーが存在しない時
     * @throws  DomainError                 設定する値が異常な時
     */
    public function __set($key, $value) {
        switch($key) {
        case 'utt':                 return $this->setUserInput($value);
        case 'context':             return $this->setContext($value);
        case 'mode':                return $this->setMode($value);
        case 't':                   return $this->setCharacter($value);
        case 'user':                return $this->setUserInformation($value);
        default:                    throw new InvalidArgumentException("Unknown key {$key}");
        }
    }

    /**
     * パラメータを完全にリセットする
     *
     * return self
     */
    public function reset() {
        $this->parameters = [
            'utt'       => null,
            'context'   => null,
            'mode'      => self::MODE_DIALOG,
            't'         => self::CHARACTER_DEFAULT,
        ];
        $this->user_info = null;
        return $this;
    }

    /**
     * ユーザ入力テキストを取得
     *
     * @return string
     */
    public function getUserInput() {
        return $this->parameters['utt'];
    }

    /**
     * コンテキストIDを取得
     *
     * @return string
     */
    public function getContext() {
        return $this->parameters['context'];
    }

    /**
     * 対話モードを取得
     *
     * @return string
     */
    public function getMode() {
        return $this->parameters['mode'];
    }

    /**
     * キャラクタIDを取得
     *
     * @return int
     */
    public function getCharacter() {
        return $this->parameters['t'];
    }

    /**
     * ユーザ関連情報管理クラスを取得
     *
     * @return UserInformation
     */
    public function getUserInformation() {
        if(!$this->user_info) {
            $this->user_info = new UserInformation();
        }
        return $this->user_info;
    }

    /**
     * ユーザ入力テキストを設定
     *
     * @param   string  $value          テキスト
     * @return  self
     * @throws  DomainError
     */
    public function setUserInput($value) {
        validators\String::validate($value, 255, 'User input too long');
        $value = mb_substr($value, 0, 255, 'UTF-8');
        $this->parameters['utt'] = $value;
        return $this;
    }

    /**
     * コンテキストIDを設定
     *
     * @param   string  $value          コンテキストID
     * @return  self
     */
    public function setContext($value) {
        validators\String::validate($value, 255, 'Context id too long');
        $value = mb_substr($value, 0, 255, 'UTF-8');
        $this->parameters['context'] = $value;
        return $this;
    }

    /**
     * 対話モードを設定
     *
     * @param   string  $value          対話モード  MODE_DIALOG | MODE_SRTR
     * @return  self
     */
    public function setMode($value) {
        if($value !== null &&
           $value !== self::MODE_DIALOG &&
           $value !== self::MODE_SRTR)
        {
            throw new DomainError('Invalid mode');
        }
        $this->parameters['mode'] = $value;
        return $this;
    }

    /**
     * キャラクタIDを設定
     *
     * @param   int     $value          キャラクタID    CHARACTER_DEFAULT | CHARACTER_KANSAI | CHARACTER_BABY
     * @return  self
     */
    public function setCharacter($value) {
        if($value !== self::CHARACTER_DEFAULT &&
           $value !== self::CHARACTER_KANSAI &&
           $value !== self::CHARACTER_BABY)
        {
            throw new DomainError('Invalid character');
        }
        $this->parameters['t'] = $value;
        return $this;
    }

    /**
     * ユーザ情報を設定
     *
     * @param   UserInformation $value      ユーザ情報
     * @return  self
     */
    public function setUserInformation(UserInformation $value) {
        $this->user_info = $value;
        return $this;
    }

    /**
     * 送信用のパラメータ配列を作成して取得する
     *
     * @return  array
     */
    public function makeParameter() {
        $ret = [];
        foreach($this->parameters as $k => $v) {
            if($v !== null) {
                $ret[$k] = is_string($v) ? Util::toSjisSafe($v) : $v;
            }
        }
        return array_merge($ret, $this->getUserInformation()->makeParameter());
    }

    /**
     * クラス名(FQCN)を取得
     *
     * return string
     */
    public static function className() {
        return get_called_class();
    }
}
