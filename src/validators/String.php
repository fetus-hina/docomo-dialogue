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
     * @param   int     $maxLen             許容される文字列の最大長
     * @param   string  $errorMessage       異常時に発生する例外のメッセージ
     *
     * @throws  \jp3cki\docomoDialogue\DomainError
     */
    public static function validate($value, $maxLen, $errorMessage) {
        if(mb_strlen($value, 'UTF-8') <= $maxLen) {
            return true;
        }
        throw new DomainError($errorMessage);
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
