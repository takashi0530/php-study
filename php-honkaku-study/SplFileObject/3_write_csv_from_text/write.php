<?php require_once('/work/php-honkaku-study/config.php'); ?>

<?php
// http://localhost:8564/php-honkaku-study/SplFileObject/3_write_csv_from_text/write.php

/**
 *
 * 生成したファイルへの書き込み処理
 *
 */
// filesディレクトリの中に generated.txt がなければ生成し、そのファイルを読み込む（カラのファイルが生成される）
// $file = new SplFileObject('files/generated.txt', 'w');

// // generated.txt に書き込むためのテキスト文章
// $text = <<< TEXT
// いろはにほへと　ちりぬるを
// わかよたれそ　つねならむ
// うゐのおくやま　けふこえて
// あさきゆめみし　ゑひもせす
// TEXT;

// // generated.txt に $text の内容を書き込む
// // fwrite()  第1引数：書き込む文字列  第2引数：書き込む最大バイト数  戻り値：書き出されたバイト数を返す。エラーの場合はnullを返す
// $bytes = $file->fwrite($text);
// echo 'generated.textに' . $bytes . ' バイト書き込みました。' .  PHP_EOL;




/**
 *
 * 生成したCSVファイルへの書き込み処理
 *
 */
// CSVファイルへの書き込み   files/tempディレクトリのなかにgenerated-utf.csvがなければ作成する （カラの UTF-8 のファイルが作成される）
$csv = new SplFileObject('files/temp/generated-utf.csv', 'w');

$items = [
    ['商品名', '価格'],
    ['掃除機', '15,000'],
    ['エアコン', '60,000'],
    ['アイロン高性能', '20,000'],
    ["1行目\n\"2行目\"\n3行目", '30,000'],
];

// カラのgenerated-utf.csvファイルに配列のデータを書き込む
foreach ($items as $item) {
    // 1行ずつ書き込む
    $csv->fputcsv($item);
}

// generated-utf.csv の文字コードをshift-jisに変換し、generated.csv として保存する  （SHIFT-JISのcsvファイルが生成される）
utf_to_sjis('files/temp/generated-utf.csv', 'files/generated.csv');
echo 'generated.csv に書き込みました' . PHP_EOL;







/**
 * ファイルの文字コードを変換し、別ファイルとして保存する関数
 *
 * @param string $from_file     変換元ファイルパス。存在するファイルを指定すること
 * @param string $to_file       変換先ファイルパス。既に存在する場合は上書き保存されることに注意
 * @param string $from_encoding 変換元文字コード
 * @param string $to_encoding   変換先コード
 */
function convertEncoding(string $from_file, string $to_file, string $from_encoding, string $to_encoding): void
{
    // pr($from_file, '$from_file');   // files/temp/generated-utf.csv
    // pr($to_file, '$to_files');     //  files/generated.csv

    pr(file_get_contents($from_file),1,1);  //元データの中身（SJIS-win） ※文字化けしてる
    pr(mb_convert_encoding(file_get_contents($from_file), $to_encoding, $from_encoding),1,1);  //UTF-8に変換後の中身 ※文字化けしていない

    // データの書き込み   files/generated.csv  に 書き込む
    file_put_contents(
        $to_file,   // データを書き込むファイルへのパス(files/generated.csv) ※存在しない場合は作成する
        mb_convert_encoding(file_get_contents($from_file), $to_encoding, $from_encoding)  // 書き込むデータ(SJIS-winからUTF-8に変換した元データ)
    );
}

/**
 * ファイルの文字コードを UTF-8 から SJIS-win に変換し、別ファイルとして保存する関数
 *
 * @param string $from_file  変換元のファイルパス。存在するファイルを指定すること
 * @param string $to_file    変換先のファイルパス。既に存在する場合は上書き保存することに注意
 */
function utf_to_sjis(string $from_file, string $to_file): void
{
    convertEncoding($from_file, $to_file, 'UTF-8', 'SJIS-win');
}

/**
 * ファイルの文字コードを SJIS-win から UTF-8 に変換し、別ファイルとして保存する関数
 *
 * @param string $from_file  変換元のファイルパス。存在するファイルを指定すること
 * @param string $to_file    変換先のファイルパス。既に存在する場合は上書き保存することに注意
 */
function sjis_to_utf(string $from_file, string $to_file): void
{
    pr($from_file);  // sample.csv
    pr($to_file);    // temp/sample-utf.csv

    // sample.csvをコピーして、tempフォルダの中に、sample-utf.csvファイルを作る さらに、SJIS-winからUTF-8に文字コードを変換する
    convertEncoding($from_file, $to_file, 'SJIS-win', 'UTF-8');
}

