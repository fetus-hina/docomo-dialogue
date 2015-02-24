<?php
/**
 * 送信パラメータのうち、利用者に関するパラメータを管理するクラス
 * @author AIZAWA Hina <hina@bouhime.com>
 * @copyright 2015 by AIZAWA Hina <hina@bouhime.com>
 * @license https://github.com/fetus-hina/docomo-dialogue/blob/master/LICENSE MIT
 * @since 0.1.0
 */

namespace jp3cki\docomoDialogue;

/**
 * 送信パラメータのうち、利用者に関するパラメータを管理するクラス
 *
 * @property string $nickname       ニックネーム
 * @property string $nickname_y     ニックネームの読み
 * @property string $sex            性別
 * @property string $bloodtype      血液型
 * @property int    $birthdate_y    生年月日（年）
 * @property int    $birthdate_m    生年月日（月）
 * @property int    $birthdate_d    生年月日（日）
 * @property int    $age            年齢
 * @property string $constellations 星座
 * @property string $place          ユーザの場所
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class UserInformation {
    /** 男性 */
    const SEX_MALE      = '男';
    /** 女性 */
    const SEX_FEMALE    = '女';
    /** 不明/その他の性 */
    const SEX_OTHERS    = null;

    /** 血液型: A */
    const BLOOD_TYPE_A  = 'A';
    /** 血液型: B */
    const BLOOD_TYPE_B  = 'B';
    /** 血液型: O */
    const BLOOD_TYPE_O  = 'O';
    /** 血液型: AB */
    const BLOOD_TYPE_AB = 'AB';
    /** 血液型: 不明 */
    const BLOOD_TYPE_UNKNOWN = null;

    /** 星座: 牡羊座 */
    const CONSTELLATION_ARIES       = '牡羊座';
    /** 星座: 牡牛座 */
    const CONSTELLATION_TAURUS      = '牡牛座';
    /** 星座: 双子座 */
    const CONSTELLATION_GEMINI      = '双子座';
    /** 星座: 蟹座 */
    const CONSTELLATION_CANCER      = '蟹座';
    /** 星座: 獅子座 */
    const CONSTELLATION_LEO         = '獅子座';
    /** 星座: 乙女座 */
    const CONSTELLATION_VIRGO       = '乙女座';
    /** 星座: 天秤座 */
    const CONSTELLATION_LIBRA       = '天秤座';
    /** 星座: 蠍座 */
    const CONSTELLATION_SCORPIUS    = '蠍座';
    /** 星座: 射手座 */
    const CONSTELLATION_SAGITTARIUS = '射手座';
    /** 星座: 山羊座 */
    const CONSTELLATION_CAPRICONUS  = '山羊座';
    /** 星座: 水瓶座 */
    const CONSTELLATION_AQUARIUS    = '水瓶座';
    /** 星座: 魚座 */
    const CONSTELLATION_PISCES      = '魚座';

    /** @internal 送信パラメータ */
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

    /**
     * @internal 場所情報として有効な地点の一覧
     * @see setPlace()
     * @see getPlace()
     */
    private static $validPlaces = [
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
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function __get($key) {
        switch($key) {
        case 'nickname':        return $this->getNickname();
        case 'nickname_y':      return $this->getNicknameY();
        case 'sex':             return $this->getSex();
        case 'bloodtype':       return $this->getBloodType();
        case 'birthdate_y':     return $this->getBirthdateY();
        case 'birthdate_m':     return $this->getBirthdateM();
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
     * @throws  InvalidArgumentException    対応するキーが存在しない時
     * @throws  DomainError                 設定する値が異常な時
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function __set($key, $value) {
        switch($key) {
        case 'nickname':        return $this->setNickname($value);
        case 'nickname_y':      return $this->setNicknameY($value);
        case 'sex':             return $this->setSex($value);
        case 'bloodtype':       return $this->setBloodType($value);
        case 'birthdate_y':     return $this->setBirthdateY($value);
        case 'birthdate_m':     return $this->setBirthdateM($value);
        case 'birthdate_d':     return $this->setBirthdateD($value);
        case 'age':             return $this->setAge($value);
        case 'constellations':  return $this->setConstellations($value);
        case 'place':           return $this->setPlace($value);
        default:                throw new InvalidArgumentException("Unknown key {$key}");
        }
    }

    /**
     * ユーザのニックネームを取得
     *
     * @return string
     */
    public function getNickname() {
        return $this->parameters['nickname'];
    }

    /**
     * ユーザのニックネーム（読み）を取得
     *
     * @return string
     */
    public function getNicknameY() {
        return $this->parameters['nickname_y'];
    }

    /**
     * ユーザの性別を取得
     *
     * @return string
     */
    public function getSex() {
        return $this->parameters['sex'];
    }

    /**
     * ユーザの血液型を取得
     *
     * @return string
     */
    public function getBloodType() {
        return $this->parameters['bloodtype'];
    }

    /**
     * ユーザの生年月日（年）を取得
     *
     * @return string
     */
    public function getBirthdateY() {
        return $this->parameters['birthdateY'];
    }

    /**
     * ユーザの生年月日（月）を取得
     *
     * @return string
     */
    public function getBirthdateM() {
        return $this->parameters['birthdateM'];
    }

    /**
     * ユーザの生年月日（日）を取得
     *
     * @return string
     */
    public function getBirthdateD() {
        return $this->parameters['birthdateD'];
    }

    /**
     * ユーザの年齢を取得
     *
     * @return string
     */
    public function getAge() {
        return $this->parameters['age'];
    }

    /**
     * ユーザの星座を取得
     *
     * @return string
     */
    public function getConstellations() {
        return $this->parameters['constellations'];
    }

    /**
     * ユーザの場所を取得
     *
     * @return string
     */
    public function getPlace() {
        return $this->parameters['place'];
    }

    /**
     * ユーザのニックネームを設定する
     *
     * @param   string  $value              ニックネーム（最大10文字）
     * @return  self
     * @throws  DomainError
     */
    public function setNickname($value) {
        validators\String::validate($value, 10, 'nickname too long');
        $this->parameters['nickname'] = mb_substr($value, 0, 10, 'UTF-8');
        return $this;
    }

    /**
     * ユーザのニックネーム（読み）を設定する
     *
     * @param   string  $value          ニックネームの読み（最大20文字）
     * @return  self
     * @throws  DomainError
     */
    public function setNicknameY($value) {
        validators\String::validate($value, 20, 'nickname(yomi) too long');
        $value = mb_substr($value, 0, 20, 'UTF-8');
        if(!preg_match('/^[゠-ヿ]+$/u', $value)) {
            throw new DomainError('nickname(yomi) accept only katakana');
        }
        $this->parameters['nickname_y'] = $value;
        return $this;
    }

    /**
     * ユーザの性別を設定する
     *
     * @param   string  $value          ユーザの性別    SEX_MALE | SEX_FEMALE | SEX_OTHERS
     * @return  self
     * @throws  DomainError
     */
    public function setSex($value) {
        if($value !== self::SEX_MALE &&
           $value !== self::SEX_FEMALE &&
           $value !== self::SEX_OTHERS)
        {
            throw new DomainError("Invalid sex");
        }
        $this->parameters['sex'] = $value;
        return $this;
    }

    /**
     * ユーザの血液型を設定する
     *
     * @param   string  $value          ユーザの血液型    BLOOD_TYPE_*
     * @return  self
     * @throws  DomainError
     */
    public function setBloodType($value) {
        if($value !== self::BLOOD_TYPE_A &&
           $value !== self::BLOOD_TYPE_B &&
           $value !== self::BLOOD_TYPE_O &&
           $value !== self::BLOOD_TYPE_AB &&
           $value !== self::BLOOD_TYPE_UNKNOWN)
        {
            throw new DomainError("Invalid bloodtype");
        }
        $this->parameters['bloodtype'] = $value;
        return $this;
    }

    /**
     * ユーザの生年月日(年)を設定する
     *
     * @param   int     $value          ユーザの生年月日（年）
     * @return  self
     * @throws  DomainError
     */
    public function setBirthdateY($value) {
        if($value === null) {
            $this->parameters['birthdateY'] = null;
        } else {
            $datetime = new \DateTime('now');
            $max = (int)$datetime->format('Y');
            validators\Number::validate($value, 1, $max, 'Invalid birthdateY');
            $this->parameters['birthdateY'] = min($max, max(1, (int)$value));
        }
        Return $this;
    }

    /**
     * ユーザの生年月日(月)を設定する
     *
     * @param   int     $value          ユーザの生年月日（月）
     * @return  self
     * @throws  DomainError
     */
    public function setBirthdateM($value) {
        if($value === null) {
            $this->parameters['birthdateM'] = null;
        } else {
            validators\Number::validate($value, 1, 12, 'Invalid birthdateM');
            $this->parameters['birthdateM'] = min(12, max(1, (int)$value));
        }
        return $this;
    }

    /**
     * ユーザの生年月日(日)を設定する
     *
     * @param   int     $value          ユーザの生年月日（日）
     * @return  self
     * @throws  DomainError
     */
    public function setBirthdateD($value) {
        if($value === null) {
            $this->parameters['birthdateD'] = null;
        } else {
            validators\Number::validate($value, 1, 31, 'Invalid birthdateD');
            $this->parameters['birthdateD'] = min(31, max(1, (int)$value));
        }
        return $this;
    }

    /**
     * ユーザの年齢を設定する
     *
     * @param   int     $value          ユーザの年齢
     * @return  self
     * @throws  DomainError
     */
    public function setAge($value) {
        if($value === null) {
            $this->parameters['age'] = null;
        } else {
            validators\Number::validate($value, 0, null, 'Invalid age');
            $this->parameters['age'] = max(0, (int)$value);
        }
        return $this;
    }

    /**
     * ユーザの星座を設定する
     *
     * @param   string  $value          ユーザの星座    CONSTELLATION_*
     * @return  self
     * @throws  DomainError
     */
    public function setConstellations($value) {
        if($value !== null && !in_array($value, [
                self::CONSTELLATION_ARIES,
                self::CONSTELLATION_TAURUS,
                self::CONSTELLATION_GEMINI,
                self::CONSTELLATION_CANCER,
                self::CONSTELLATION_LEO,
                self::CONSTELLATION_VIRGO,
                self::CONSTELLATION_LIBRA,
                self::CONSTELLATION_SCORPIUS,
                self::CONSTELLATION_SAGITTARIUS,
                self::CONSTELLATION_CAPRICONUS,
                self::CONSTELLATION_AQUARIUS,
                self::CONSTELLATION_PISCES,
            ])
        ) {
            throw new DomainError('Invalid constellations');
        }
        $this->parameters['constellations'] = $value;
        return $this;
    }

    /**
     * ユーザの場所を設定する
     *
     * @param   string  $value          ユーザの場所    one of $validPlaces
     * @return  self
     * @throws  DomainError
     */
    public function setPlace($value) {
        if($value !== null &&
           !in_array($value, self::$validPlaces, true))
        {
            throw new DomainError('Invalid place');
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
                $ret[$k] = $v;
            }
        }
        return $ret;
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
