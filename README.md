docomo-dialogue
===============

[![License](https://poser.pugx.org/jp3cki/docomo-dialogue/license.svg)](https://packagist.org/packages/jp3cki/docomo-dialogue)
[![Build Status](https://travis-ci.org/fetus-hina/docomo-dialogue.svg?branch=master)](https://travis-ci.org/fetus-hina/docomo-dialogue)
[![Latest Stable Version](https://poser.pugx.org/jp3cki/docomo-dialogue/v/stable.svg)](https://packagist.org/packages/jp3cki/docomo-dialogue)
[![Dependency Status](https://www.versioneye.com/user/projects/54d3265a3ca0840b19000153/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54d3265a3ca0840b19000153#tab-settings/badge.svg)

[NTT docomo](https://www.nttdocomo.co.jp/) から提供されている、
[雑談対話API](https://www.nttdocomo.co.jp/service/developer/smart_phone/analysis/chat/)のラッパーです。

このライブラリは NTT docomo 公式ではありません。

このソースコードの作者は NTT docomo とは一切関係がありません。



インストール
------------

[Composer](https://getcomposer.org/)経由でのインストールと利用をおすすめします。

Composer を使える状態になったら、次のコマンドを実行します。

```
php composer.phar require jp3cki/docomo-dialogue
```

あるいは、手動で composer.json を編集します。
妥当な JSON となるように注意してください。
また、既に require が存在する場合には中身だけを書き加えてください。

```json
    "require": {
        "jp3cki/docomo-dialogue": "1.0.*"
    }
```

その後、`php composer.phar install` とすると使えるようになります。

※依存関係のインストールでかなり時間がかかる可能性があります。



使用する前に
------------

雑談対話APIを利用するには、docomoの開発者登録とアプリケーション登録が必要になります。

[docomo Developer support](https://dev.smt.docomo.ne.jp/) を覗いてみてください。



動作サンプル
------------

sample/sample.php で簡単なチャットができます。

環境によっては日本語をBackSpaceで消そうとするとひどい目に遭うかもしれませんがあくまでサンプルなのでご容赦ください。

動作の前に sample.php を開いて API キーを書き換えてください。



動作に関する問い合わせ等
------------------------

* このライブラリを使用することで発生する問題については[このプロジェクトの issue](https://github.com/fetus-hina/docomo-dialogue/issues) に報告してください。
* API 自体の動作に関する問題については、このプロジェクトの issue で相談するか、直接 NTT docomo のサポートへ問い合わせてください。
    * この API は NTT docomo 様から見ると「公式のライブラリではない」「再現できる最小のコード」ではありません。このコードを利用したサンプルは報告には適しません。



把握している問題
----------------

当方および NTT docomo 様で次の問題を把握しています。

* 特殊な文字を含んだデータをサーバに送信するとサーバが `400 Bad Request` を返す
    * 「特殊な文字」の詳細は問い合わせても出てきませんでした（「特殊な文字や記号、絵文字など一部の文字を指定した際」とだけ返答がありました）
    * この問題を回避するため、このライブラリでは [CP932](http://ja.wikipedia.org/wiki/Microsoft%E3%82%B3%E3%83%BC%E3%83%89%E3%83%9A%E3%83%BC%E3%82%B8932) で表すことのできない文字を「〓」に置換して送信しています。
        * 先述の通り、詳細が不明なため CP932 であることに根拠がなく、まだ駄目な文字が存在する可能性があります。
        * 「こんにちは」と「こんにちは〓」で明らかに応答が異なるため完全な解決には至りません。（これは代替文字を半角スペースにした場合ですら発生します）
    * この問題はサポートへ問い合わせ済みであり、2015年2月中を目処に対応したいという内容の返答をうけています。



API等
-----

* このライブラリのディレクトリ（おそらく vendor/jp3cki/docomo-dialogue）に移動して、`make doc` と実行すると doc ディレクトリに自動生成された API ドキュメントが出力されます。

* ソースコードを追う際は、`Dialogue` クラスを起点にします。

* ちゃんとしたドキュメントを書いてくれる方を募集しています。



スペシャルサンクス
------------------

* @chomado - [chomado/chomado_bot](https://github.com/chomado/chomado_bot)
* NTT docomo



ライセンス
----------

MIT License で提供します。

ざっくり言うと著作権表示だけあれば ok です。
使用したことに伴う何らかの責任は負いません。

```
The MIT License (MIT)

Copyright (c) 2015 AIZAWA Hina <hina@bouhime.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```
