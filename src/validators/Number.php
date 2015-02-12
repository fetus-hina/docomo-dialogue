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
     * @param   string  $errorMessage       異常時に発生する例外のメッセージ
     * @return  bool
     *
     * @throws  \jp3cki\docomoDialogue\DomainError
     */
    public static function validate($value, $min, $max, $errorMessage) {
        if(is_string($value) && !preg_match('/^\d+$/', $value)) {
            throw new DomainError($errorMessage);
        }
        $value = (int)$value;
        if($min !== null && $value < $min) {
            throw new DomainError($errorMessage);
        }
        if($max !== null && $value > $max) {
            throw new DomainError($errorMessage);
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
