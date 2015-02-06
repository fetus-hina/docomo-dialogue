<?php
define('API_KEY', '');

require_once(__DIR__ . '/../vendor/autoload.php');
use jp3cki\docomoDialogue\Dialogue;

if(API_KEY == '') {
    fwrite(STDERR, "sample.php を開いて API_KEY に docomo から取得した API キーを設定してください。\n");
    exit(1);
}

$dialog = new Dialogue(API_KEY);

// 会話を継続するためのコンテキストIDとモード
$context = null;
$mode = null;

echo "対話を開始します(空行の入力で終了します):\n";
while(true) {
    // ユーザからの入力を受け付け
    echo "\n> ";
    $input = trim(fgets(STDIN));
    if($input === '') {
        break;
    }

    // 送信パラメータの準備
    $dialog->parameter->reset();
    $dialog->parameter->utt = $input;
    $dialog->parameter->context = $context;
    $dialog->parameter->mode = $mode;

    // 対話
    $ret = $dialog->request();
    if($ret === false) {
        fwrite(STDERR, "通信に失敗しました\n");
        exit(1);
    }
    echo "\n< " . $ret->utt . "\n";

    // 会話を継続するためにコンテキストIDとモードを保存
    $context = $ret->context;
    $mode = $ret->mode;
}
