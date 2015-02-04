<?php
namespace jp3cki\docomoDialogue;

class UserInformation {
    const SEX_MALE      = '男';
    const SEX_FEMALE    = '女';
    const SEX_OTHERS    = null;

    const BLOOD_TYPE_A  = 'A';
    const BLOOD_TYPE_B  = 'B';
    const BLOOD_TYPE_O  = 'O';
    const BLOOD_TYPE_AB = 'AB';
    const BLOOD_TYPE_UNKNOWN = null;

    const CONSTELLATION_ARIES       = '牡羊座';
    const CONSTELLATION_TAURUS      = '牡牛座';
    const CONSTELLATION_GEMINI      = '双子座';
    const CONSTELLATION_CANCER      = '蟹座';
    const CONSTELLATION_LEO         = '獅子座';
    const CONSTELLATION_VIRGO       = '乙女座';
    const CONSTELLATION_LIBRA       = '天秤座';
    const CONSTELLATION_SCORPIUS    = '蠍座';
    const CONSTELLATION_SAGITTARIUS = '射手座';
    const CONSTELLATION_CAPRICONUS  = '山羊座';
    const CONSTELLATION_AQUARIUS    = '水瓶座';
    const CONSTELLATION_PISCES      = '魚座';

    private $parameters = [
        'nickname'          => null,                        // ユーザのニックネーム
        'nickname_y'        => null,                        // ユーザのニックネームの読み（カナ）
        'sex'               => self::SEX_OTHERS,            // ユーザの性別
        'bloodtype'         => self::BLOOD_TYPE_UNKNOWN,    // ユーザの血液型
        'birthdateY'        => null,                        // ユーザの誕生日(Y)
        'birthdateM'        => null,                        // ユーザの誕生日(M)
        'birthdateD'        => null,                        // ユーザの誕生日(D)
        'age'               => null,                        // ユーザの年齢
        'constellations'    => null,                        // ユーザの星座
        'place'             => null,                        // ユーザの場所
    ];

    private static $valid_places = [
        '稚内', '旭川', '留萌', '網走', '北見', '紋別', '根室', '釧路', '帯広', '室蘭', '浦河', '札幌', '岩見沢',
        '倶知安', '函館', '江差', '青森', '弘前', '深浦', 'むつ', '八戸', '秋田', '横手', '鷹巣', '盛岡', '二戸',
        '一関', '宮古', '大船渡', '山形', '米沢', '酒田', '新庄', '仙台', '古川', '石巻', '白石', '福島', '郡山',
        '白河', '小名浜', '相馬', '若松', '田島', '宇都宮', '大田原', '水戸', '土浦', '前橋', 'みなかみ', 'さいたま',
        '熊谷', '秩父', '東京', '大島', '八丈島', '父島', '千葉', '銚子', '館山', '横浜', '小田原', '甲府', '河口湖',
        '長野', '松本', '諏訪', '軽井沢', '飯田', '静岡', '網代', '石廊崎', '三島', '浜松', '御前崎', '新潟', '津川',
        '長岡', '湯沢', '高田', '相川', '富山', '伏木', '岐阜', '高山', '名古屋', '豊橋', '福井', '大野', '敦賀',
        '金沢', '輪島', '大津', '彦根', '津', '上野', '四日市', '尾鷲', '京都', '舞鶴', '奈良', '風屋', '和歌山',
        '潮岬', '大阪', '神戸', '姫路', '洲本', '豊岡', '鳥取', '米子', '岡山', '津山', '松江', '浜田', '西郷', '広島',
        '呉', '福山', '庄原', '下関', '山口', '柳井', '萩', '高松', '徳島', '池田', '日和佐', '松山', '新居浜',
        '宇和島', '高知', '室戸岬', '清水', '福岡', '八幡', '飯塚', '久留米', '佐賀', '伊万里', '長崎', '佐世保',
        '厳原', '福江', '大分', '中津', '日田', '佐伯', '熊本', '阿蘇乙姫', '牛深', '人吉', '宮崎', '油津', '延岡',
        '都城', '高千穂', '鹿児島', '阿久根', '枕崎', '鹿屋', '種子島', '名瀬', '沖永良部', '那覇', '名護', '久米島',
        '南大東島', '宮古島', '石垣島', '与那国島', '海外'
    ];

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
        case 'nickname':        return $this->getNickname();
        case 'nickname_y':      return $this->getNicknameY();
        case 'nicknameY':       return $this->getNicknameY();
        case 'sex':             return $this->getSex();
        case 'bloodtype':       return $this->getBloodType();
        case 'birthdateY':      return $this->getBirthdateY();
        case 'birthdate_y':     return $this->getBirthdateY();
        case 'birthdateM':      return $this->getBirthdateM();
        case 'birthdate_m':     return $this->getBirthdateM();
        case 'birthdateD':      return $this->getBirthdateD();
        case 'birthdate_d':     return $this->getBirthdateD();
        case 'age':             return $this->getAge();
        case 'constellations':  return $this->getConstellations();
        case 'place':           return $this->getPlace();
        }
    }

    /**
     * マジックメソッド __set
     *
     * @param   string  $key    プロパティ設定用のキー
     * @param   string  $value  設定する値
     *
     * @throws  jp3cki\docomoDialogue\InvalidArgumentException  対応するキーが存在しない時
     * @throws  jp3cki\docomoDialogue\DomainError               設定する値が異常な時
     */
    public function __set($key, $value) {
        switch($key) {
        case 'nickname':        return $this->setNickname($value);
        case 'nickname_y':      return $this->setNicknameY($value);
        case 'nicknameY':       return $this->setNicknameY($value);
        case 'sex':             return $this->setSex($value);
        case 'bloodtype':       return $this->setBloodType($value);
        case 'birthdateY':      return $this->setBirthdateY($value);
        case 'birthdate_y':     return $this->setBirthdateY($value);
        case 'birthdateM':      return $this->setBirthdateM($value);
        case 'birthdate_m':     return $this->setBirthdateM($value);
        case 'birthdateD':      return $this->setBirthdateD($value);
        case 'birthdate_d':     return $this->setBirthdateD($value);
        case 'age':             return $this->setAge($value);
        case 'constellations':  return $this->setConstellations($value);
        case 'place':           return $this->setPlace($value);
        default:                throw new InvalidArgumentException("Unknown key {$key}");
        }
    }

    public function getNickname() {
        return $this->parameters['nickname'];
    }

    public function getNicknameY() {
        return $this->parameters['nickname_y'];
    }

    public function getSex() {
        return $this->parameters['sex'];
    }

    public function getBloodType() {
        return $this->parameters['bloodtype'];
    }

    public function getBirthdateY() {
        return $this->parameters['birthdateY'];
    }

    public function getBirthdateM() {
        return $this->parameters['birthdateM'];
    }

    public function getBirthdateD() {
        return $this->parameters['birthdateD'];
    }

    public function getAge() {
        return $this->parameters['age'];
    }

    public function getConstellations() {
        return $this->parameters['constellations'];
    }

    public function getPlace() {
        return $this->parameters['place'];
    }

    /**
     * ユーザのニックネームを設定する
     *
     * @param   string  $value              ニックネーム（最大10文字）
     * @param   bool    $throw_if_too_long  設定される値が長すぎる時例外を投げるならtrue、何事もなかったかのように扱うならfalse
     * @return  object  self
     * @throws  DomainError
     */
    public function setNickname($value, $throw_if_too_long = true) {
        $this->validateStrLen($value, 10, $throw_if_too_long, 'nickname too long');
        $this->parameters['nickname'] = mb_substr($value, 0, 10, 'UTF-8');
        return $this;
    }

    /**
     * ユーザのニックネーム（読み）を設定する
     *
     * @param   string  $value              ニックネームの読み（最大20文字）
     * @param   bool    $throw_if_too_long  設定される値が長すぎる時例外を投げるならtrue、何事もなかったかのように扱うならfalse
     * @return  object  self
     * @throws  DomainError
     */
    public function setNicknameY($value, $throw_if_too_long = true) {
        $this->validateStrLen($value, 20, $throw_if_too_long, 'nickname(yomi) too long');
        $this->parameters['nickname_y'] = mb_substr($value, 0, 20, 'UTF-8');
        return $this;
    }

    /**
     * ユーザの性別を設定する
     *
     * @param   string  $value          ユーザの性別    SEX_MALE | SEX_FEMALE | SEX_OTHERS
     * @param   bool    $throw_if_error 設定された値が異常な時例外を投げるならtrue
     * @return  object  self
     * @throws  DomainError
     */
    public function setSex($value, $throw_if_error = true) {
        if($value !== self::SEX_MALE &&
           $value !== self::SEX_FEMALE &&
           $value !== self::SEX_OTHERS)
        {
            if($throw_if_error) {
                throw new DomainError("Invalid sex");
            }
            trigger_error("Invalid sex", E_USER_WARNING);
            $value = self::SEX_OTHERS;
        }
        $this->parameters['sex'] = $value;
        return $this;
    }

    /**
     * ユーザの血液型を設定する
     *
     * @param   string  $value          ユーザの血液型    BLOOD_TYPE_*
     * @param   bool    $throw_if_error 設定された値が異常な時例外を投げるならtrue
     * @return  object  self
     * @throws  DomainError
     */
    public function setBloodType($value, $throw_if_error = true) {
        if($value !== self::BLOOD_TYPE_A &&
           $value !== self::BLOOD_TYPE_B &&
           $value !== self::BLOOD_TYPE_O &&
           $value !== self::BLOOD_TYPE_AB &&
           $value !== self::BLOOD_TYPE_UNKNOWN)
        {
            if($throw_if_error) {
                throw new DomainError("Invalid bloodtype");
            }
            trigger_error("Invalid bloodtype", E_USER_WARNING);
            $value = self::BLOOD_TYPE_UNKNOWN;
        }
        $this->parameters['bloodtype'] = $value;
        return $this;
    }

    /**
     * ユーザの生年月日(年)を設定する
     *
     * @param   int     $value          ユーザの生年月日（年）
     * @param   bool    $throw_if_error 設定された値が異常な時例外を投げるならtrue
     * @return  object  self
     * @throws  DomainError
     */
    public function setBirthdateY($value, $throw_if_error = true) {
        if($value === null) {
            $this->parameters['birthdateY'] = null;
        } else {
            $datetime = new \DateTime('now');
            $max = (int)$datetime->format('Y');
            $this->validateInteger($value, 1, $max, $throw_if_error, 'Invalid birthdateY');
            $this->parameters['birthdateY'] = min($max, max(1, (int)$value));
        }
        Return $this;
    }

    /**
     * ユーザの生年月日(月)を設定する
     *
     * @param   int     $value          ユーザの生年月日（月）
     * @param   bool    $throw_if_error 設定された値が異常な時例外を投げるならtrue
     * @return  object  self
     * @throws  DomainError
     */
    public function setBirthdateM($value, $throw_if_error = true) {
        if($value === null) {
            $this->parameters['birthdateM'] = null;
        } else {
            $this->validateInteger($value, 1, 12, $throw_if_error, 'Invalid birthdateM');
            $this->parameters['birthdateM'] = min(12, max(1, (int)$value));
        }
        return $this;
    }

    /**
     * ユーザの生年月日(日)を設定する
     *
     * @param   int     $value          ユーザの生年月日（日）
     * @param   bool    $throw_if_error 設定された値が異常な時例外を投げるならtrue
     * @return  object  self
     * @throws  DomainError
     */
    public function setBirthdateD($value, $throw_if_error = true) {
        if($value === null) {
            $this->parameters['birthdateD'] = null;
        } else {
            $this->validateInteger($value, 1, 31, $throw_if_error, 'Invalid birthdateD');
            $this->parameters['birthdateD'] = min(31, max(1, (int)$value));
        }
        return $this;
    }

    /**
     * ユーザの年齢を設定する
     *
     * @param   int     $value          ユーザの年齢
     * @param   bool    $throw_if_error 設定された値が異常な時例外を投げるならtrue
     * @return  object  self
     * @throws  DomainError
     */
    public function setAge($value, $throw_if_error = true) {
        if($value === null) {
            $this->parameters['age'] = null;
        } else {
            $this->validateInteger($value, 0, null, $throw_if_error, 'Invalid age');
            $this->parameters['age'] = max(0, (int)$value);
        }
        return $this;
    }

    /**
     * ユーザの星座を設定する
     *
     * @param   string  $value          ユーザの星座    CONSTELLATION_*
     * @param   bool    $throw_if_error 設定された値が異常な時例外を投げるならtrue
     * @return  object  self
     * @throws  DomainError
     */
    public function setConstellations($value, $throw_if_error = true) {
        if($value !== null &&
           $value !== self::CONSTELLATION_ARIES &&
           $value !== self::CONSTELLATION_TAURUS &&
           $value !== self::CONSTELLATION_GEMINI &&
           $value !== self::CONSTELLATION_CANCER &&
           $value !== self::CONSTELLATION_LEO &&
           $value !== self::CONSTELLATION_VIRGO &&
           $value !== self::CONSTELLATION_LIBRA &&
           $value !== self::CONSTELLATION_SCORPIUS &&
           $value !== self::CONSTELLATION_SAGITTARIUS &&
           $value !== self::CONSTELLATION_CAPRICONUS &&
           $value !== self::CONSTELLATION_AQUARIUS &&
           $value !== self::CONSTELLATION_PISCES)
        {
            if($throw_if_error) {
                throw new DomainError('Invalid constellations');
            }
            trigger_error('Invalid constellations', E_USER_WARNING);
            $value = null;
        }
        $this->parameters['constellations'] = $value;
        return $this;
    }

    /**
     * ユーザの場所を設定する
     *
     * @param   string  $value          ユーザの場所    one of $valid_places
     * @param   bool    $throw_if_error 設定された値が異常な時例外を投げるならtrue
     * @return  object  self
     * @throws  DomainError
     */
    public function setPlace($value, $throw_if_error = true) {
        if($value !== null &&
           !in_array($value, self::$valid_places, true))
        {
            if($throw_if_error) {
                throw new DomainError('Invalid place');
            }
            trigger_error('Invalid place', E_USER_WARNING);
            $value = null;
        }
        $this->parameters['place'] = $value;
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
        return $ret;
    }

    /**
     * 文字列の長さを検査する
     *
     * @param   string  $value              対象にする文字列
     * @param   int     $maxlen             許容される文字列の最大長
     * @param   bool    $throw_if_too_long  異常時に例外を投げるなら true、警告だけして何もしないなら false
     * @param   string  $error_message      異常時に発生する例外または警告のメッセージ
     *
     * @throws  DomainError
     */
    private function validateStrLen($value, $maxlen, $throw_if_too_long, $error_message) {
        if(mb_strlen($value, 'UTF-8') <= $maxlen) {
            return true;
        }
        if($throw_if_too_long) {
            throw new DomainError($error_message);
        }
        trigger_error($error_message, E_USER_WARNING);
        return false;
    }

    /**
     * 整数型を検査する 
     *
     * @param   int     $value              対象にする数値
     * @param   int     $min                許容する最小値
     * @param   int     $max                許容する最大値
     * @param   bool    $throw_if_error     異常時に例外を投げるなら true、警告だけして何もしないなら false
     * @param   string  $error_message      異常時に発生する例外または警告のメッセージ
     *
     * @throws  DomainError
     */
    private function validateInteger($value, $min, $max, $throw_if_error, $error_message) {
        $error = false;
        if(!is_int($value)) {
            if(is_string($value) && !preg_match('/^\d+$/', $value)) {
                $error = true;
            } else {
                $value = (int)$value;
            }
        }
        if(!$error && $min !== null && $value < $min) {
            $error = true;
        }
        if(!$error && $max !== null && $value > $max) {
            $error = true;
        }
        if($error) {
            if($throw_if_error) {
                throw new DomainError($error_message);
            }
            trigger_error($error_message, E_USER_WARNING);
            return false;
        }
        return true;
     }
}
