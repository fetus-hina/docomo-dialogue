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
 * 数値のバリデータ
 */
class Number {
    /**
     * 数値型を検査する 
     *
     * @param   int     $value              対象にする数値
     * @param   int     $min                許容する最小値
     * @param   int     $max                許容する最大値
     * @param   bool    $throw_if_error     異常時に例外を投げるなら true、警告だけして何もしないなら false
     * @param   string  $error_message      異常時に発生する例外または警告のメッセージ
     *
     * @throws  \jp3cki\docomoDialogue\DomainError
     */
    public static function validate($value, $min, $max, $throw_if_error, $error_message) {
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

    /**
     * クラス名(FQCN)を取得
     *
     * return string
     */
    public static function className() {
        return get_called_class();
    }
}
