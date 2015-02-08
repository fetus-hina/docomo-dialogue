<?php
/**
 * @author AIZAWA Hina <hina@bouhime.com>
 * @copyright 2015 by AIZAWA Hina <hina@bouhime.com>
 * @license https://github.com/fetus-hina/docomo-dialogue/blob/master/LICENSE MIT
 * @since 1.0.1
 */

namespace jp3cki\docomoDialogue\validators;
use jp3cki\docomoDialogue\DomainError;

/**
 * 文字列のバリデータ   
 */
class String {
    /**
     * 文字列を検査する
     *
     * @param   string  $value              対象にする文字列
     * @param   int     $maxlen             許容される文字列の最大長
     * @param   bool    $throw_if_too_long  異常時に例外を投げるなら true、警告だけして何もしないなら false
     * @param   string  $error_message      異常時に発生する例外または警告のメッセージ
     *
     * @throws  \jp3cki\docomoDialogue\DomainError
     */
    public static function validate($value, $maxlen, $throw_if_too_long, $error_message) {
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
     * クラス名(FQCN)を取得
     *
     * return string
     */
    public static function className() {
        return get_called_class();
    }
}
