<?php
use jp3cki\docomoDialogue\UserInformation;

class UserInformationTest extends \PHPUnit_Framework_TestCase {
    public function testNickname() {
        $o = new UserInformation();
        $p = $o->setNickname('相沢陽菜');
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals('相沢陽菜', $o->getNickname());
        $this->assertEquals('相沢陽菜', $o->nickname);
        $o->nickname = 'あいうえお';
        $this->assertEquals('あいうえお', $o->getNickname());
        $o->setNickname(str_repeat('あ', 10));
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testNicknameLengthException() {
        $o = new UserInformation();
        $o->setNickname(str_repeat('あ', 11));
    }

    public function testNicknameY() {
        $o = new UserInformation();
        $p = $o->setNicknameY('アイザワヒナ');
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals('アイザワヒナ', $o->getNicknameY());
        $this->assertEquals('アイザワヒナ', $o->nickname_y);
        $o->nickname_y = 'アイウエオ';
        $this->assertEquals('アイウエオ', $o->getNicknameY());
        $o->setNicknameY(str_repeat('ア', 20));
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testNicknameYLengthException() {
        $o = new UserInformation();
        $o->setNickname(str_repeat('ア', 21));
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testNicknameYKatakanaException() {
        $o = new UserInformation();
        $o->setNicknameY('亜');
    }

    public function testSex() {
        $o = new UserInformation();
        $p = $o->setSex(UserInformation::SEX_MALE);
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals(UserInformation::SEX_MALE, $o->getSex());
        $this->assertEquals(UserInformation::SEX_MALE, $o->sex);
        $this->assertEquals(UserInformation::SEX_FEMALE, $o->setSex(UserInformation::SEX_FEMALE)->getSex());
        $this->assertEquals(UserInformation::SEX_OTHERS, $o->setSex(UserInformation::SEX_OTHERS)->getSex());
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testSexException() {
        $o = new UserInformation();
        $o->setSex('あ');
    }

    public function testBloodType() {
        $o = new UserInformation();
        $p = $o->setBloodType(UserInformation::BLOOD_TYPE_A);
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals(UserInformation::BLOOD_TYPE_A, $o->getBloodType());
        $this->assertEquals(UserInformation::BLOOD_TYPE_A, $o->bloodtype);
        $this->assertEquals(UserInformation::BLOOD_TYPE_B, $o->setBloodType(UserInformation::BLOOD_TYPE_B)->getBloodType());
        $this->assertEquals(UserInformation::BLOOD_TYPE_O, $o->setBloodType(UserInformation::BLOOD_TYPE_O)->getBloodType());
        $this->assertEquals(UserInformation::BLOOD_TYPE_AB, $o->setBloodType(UserInformation::BLOOD_TYPE_AB)->getBloodType());
        $this->assertEquals(UserInformation::BLOOD_TYPE_UNKNOWN, $o->setBloodType(UserInformation::BLOOD_TYPE_UNKNOWN)->getBloodType());
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testBloodTypeException() {
        $o = new UserInformation();
        $o->setBloodType('あ');
    }

    public function testBirthdateY() {
        $o = new UserInformation();
        $p = $o->setBirthdateY(2000);
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals(2000, $o->getBirthdateY());
        $this->assertEquals(2000, $o->birthdate_y);
        $this->assertEquals(1, $o->setBirthdateY(1)->getBirthdateY());
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testBirthdateYLowerException() {
        $o = new UserInformation();
        $o->setBirthdateY(0);
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testBirthdateYUpperException() {
        $o = new UserInformation();
        $o->setBirthdateY(2100);
    }

    public function testBirthdateM() {
        $o = new UserInformation();
        $p = $o->setBirthdateM(1);
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals(1, $o->getBirthdateM());
        $this->assertEquals(1, $o->birthdate_m);
        $this->assertEquals( 2, $o->setBirthdateM( 2)->getBirthdateM());
        $this->assertEquals( 3, $o->setBirthdateM( 3)->getBirthdateM());
        $this->assertEquals( 4, $o->setBirthdateM( 4)->getBirthdateM());
        $this->assertEquals( 5, $o->setBirthdateM( 5)->getBirthdateM());
        $this->assertEquals( 6, $o->setBirthdateM( 6)->getBirthdateM());
        $this->assertEquals( 7, $o->setBirthdateM( 7)->getBirthdateM());
        $this->assertEquals( 8, $o->setBirthdateM( 8)->getBirthdateM());
        $this->assertEquals( 9, $o->setBirthdateM( 9)->getBirthdateM());
        $this->assertEquals(10, $o->setBirthdateM(10)->getBirthdateM());
        $this->assertEquals(11, $o->setBirthdateM(11)->getBirthdateM());
        $this->assertEquals(12, $o->setBirthdateM(12)->getBirthdateM());
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testBirthdateMLowerException() {
        $o = new UserInformation();
        $o->setBirthdateM(0);
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testBirthdateMUpperException() {
        $o = new UserInformation();
        $o->setBirthdateM(13);
    }

    public function testBirthdateD() {
        $o = new UserInformation();
        $p = $o->setBirthdateD(1);
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals(1, $o->getBirthdateD());
        $this->assertEquals(1, $o->birthdate_d);
        $this->assertEquals(31, $o->setBirthdateD(31)->getBirthdateD());
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testBirthdateDLowerException() {
        $o = new UserInformation();
        $o->setBirthdateD(0);
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testBirthdateDUpperException() {
        $o = new UserInformation();
        $o->setBirthdateD(32);
    }

    public function testAge() {
        $o = new UserInformation();
        $p = $o->setAge(42);
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals(42, $o->getAge());
        $this->assertEquals(42, $o->age);
        $this->assertEquals(1, $o->setAge(1)->getAge());
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testAgeLowerException() {
        $o = new UserInformation();
        $o->setBirthdateD(-1);
    }

    public function testConstellations() {
        $o = new UserInformation();
        $p = $o->setConstellations(UserInformation::CONSTELLATION_ARIES);
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals(UserInformation::CONSTELLATION_ARIES, $o->getConstellations());
        $this->assertEquals(UserInformation::CONSTELLATION_ARIES, $o->constellations);
        $this->assertEquals(UserInformation::CONSTELLATION_TAURUS     , $o->setConstellations(UserInformation::CONSTELLATION_TAURUS     )->getConstellations());
        $this->assertEquals(UserInformation::CONSTELLATION_GEMINI     , $o->setConstellations(UserInformation::CONSTELLATION_GEMINI     )->getConstellations());
        $this->assertEquals(UserInformation::CONSTELLATION_CANCER     , $o->setConstellations(UserInformation::CONSTELLATION_CANCER     )->getConstellations());
        $this->assertEquals(UserInformation::CONSTELLATION_LEO        , $o->setConstellations(UserInformation::CONSTELLATION_LEO        )->getConstellations());
        $this->assertEquals(UserInformation::CONSTELLATION_VIRGO      , $o->setConstellations(UserInformation::CONSTELLATION_VIRGO      )->getConstellations());
        $this->assertEquals(UserInformation::CONSTELLATION_LIBRA      , $o->setConstellations(UserInformation::CONSTELLATION_LIBRA      )->getConstellations());
        $this->assertEquals(UserInformation::CONSTELLATION_SCORPIUS   , $o->setConstellations(UserInformation::CONSTELLATION_SCORPIUS   )->getConstellations());
        $this->assertEquals(UserInformation::CONSTELLATION_SAGITTARIUS, $o->setConstellations(UserInformation::CONSTELLATION_SAGITTARIUS)->getConstellations());
        $this->assertEquals(UserInformation::CONSTELLATION_CAPRICONUS , $o->setConstellations(UserInformation::CONSTELLATION_CAPRICONUS )->getConstellations());
        $this->assertEquals(UserInformation::CONSTELLATION_AQUARIUS   , $o->setConstellations(UserInformation::CONSTELLATION_AQUARIUS   )->getConstellations());
        $this->assertEquals(UserInformation::CONSTELLATION_PISCES     , $o->setConstellations(UserInformation::CONSTELLATION_PISCES     )->getConstellations());
        $this->assertEquals(null, $o->setConstellations(null)->getConstellations());
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testConstellationsException() {
        $o = new UserInformation();
        $o->setConstellations('蛇遣い座');
    }

    public function testPlace() {
        $o = new UserInformation();
        $p = $o->setPlace('東京');
        $this->assertTrue($o === $p); // returns $this
        $this->assertEquals('東京', $o->getPlace());
        $this->assertEquals('東京', $o->place);
        $this->assertEquals('宇都宮', $o->setPlace('宇都宮')->getPlace());
        $this->assertEquals(null, $o->setPlace(null)->getPlace());
    }

    /**
     * @expectedException jp3cki\docomoDialogue\DomainError
     */
    public function testPlaceException() {
        $o = new UserInformation();
        $o->setPlace('巴里');
    }

    public function testMakeParameter() {
        $o = new UserInformation();
        $this->assertTrue(is_array($o->makeParameter()));
    }
}
