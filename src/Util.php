<?php
namespace jp3cki\docomoDialogue;

class Util {
    /**
     * Shift-JIS (CP932) で収まる範囲の文字列に変換する
     *
     * @param   string  $string     対象の文字列
     * @param   mixed   $substrchar 変換できなかった時の処理(see: mb_substitute_character)
     * @return  string              変換後の文字列
     * @link    mb_substitute_character
     */
    public static function toSjisSafe($string, $substrchar = 0x3013) {
        $old_substrchar = mb_substitute_character();
        mb_substitute_character($substrchar);
        $ret = mb_convert_encoding(mb_convert_encoding($string, 'CP932', 'UTF-8'), 'UTF-8', 'CP932');
        mb_substitute_character($old_substrchar);
        return $ret;
    }
}
