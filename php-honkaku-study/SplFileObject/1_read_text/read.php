<?php require_once('/work/php-honkaku-study/config.php'); ?>

<?php
/**
 *
 * txt形式（CSVでない）のデータを読み込み、画面に出力する
 *
 */

// sample.txtを読み込む
// コンストラクタにわたす引数
//  第1引数 ： 読み取りたいデータのパスを指定
//  第2引数  :  読み書きのモードを表す文字(r r+ w w+ a a+) ※初期値は r で先頭からの読み込み
$file = new SplFileObject('sample.txt');

// 読み出す方法を設定する
$file->setFlags(
    SplFileObject::READ_AHEAD |   // 先読み 巻き戻しで読み出す
    SplFileObject::SKIP_EMPTY |   // 空行をスキップする
    SplFileObject::DROP_NEW_LINE  // 行末の改行を除去する
    // | SplFileObject::READ_CSV       // CSV形式のファイルを読み込む
);

$line_number = 0;

// sample.txtを１行ずつループ処理する
// sample.txtの内容を読み込み、画面に出力させる
foreach ($file as $line) {
    $line_number++;
    echo $line_number . '行目 ；' . $line . '<br>';
}

// 処理結果
// 1行目 ；いろはにほへと　ちりぬるを
// 2行目 ；わかよたれそ　つねならむ
// 3行目 ；うゐのおくやま　けふこえて
// 4行目 ；あさきゆめみし　ゑひもせす


// ファイルの削除をしたい場合は、以下のようにインスタンスをnullで上書きしてロックを解除する
    // $file = null
?>

