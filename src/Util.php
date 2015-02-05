<?php
/**
 * ユーティリティ関数用クラス
 *
 * @author AIZAWA Hina <hina@bouhime.com>
 * @copyright 2015 by AIZAWA Hina <hina@bouhime.com>
 * @license https://github.com/fetus-hina/docomo-dialogue/blob/master/LICENSE MIT
 * @since 0.1.0
 */

namespace jp3cki\docomoDialogue;

/**
 * ユーティリティ関数用クラス
 */
class Util {
    /**
     * Shift-JIS (CP932) で収まる範囲の文字列に変換する
     *
     * @param   string  $text       対象の文字列
     * @param   mixed   $substrchar 変換できなかった時の処理(see: mb_substitute_character() )
     * @return  string              変換後の文字列
     * @link    http://php.net/manual/ja/function.mb-substitute-character.php mb_substitute_character
     */
    public static function toSjisSafe($text, $substrchar = 0x3013) {
        $old_substrchar = mb_substitute_character();
        mb_substitute_character($substrchar);
        $ret = mb_convert_encoding(mb_convert_encoding($text, 'CP932', 'UTF-8'), 'UTF-8', 'CP932');
        mb_substitute_character($old_substrchar);
        return $ret;
    }
}
