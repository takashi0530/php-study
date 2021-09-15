<?php require_once('/work/php-honkaku-study/config.php'); ?>

<?php
// http://localhost:8564/php-honkaku-study/SplFileObject/2_read_csv/read-csv2.php

/**
 *
 * 文字コードを正しく変換し、CSVファイルを読み込む
 *
 */

//  PHPプログラムが扱うロケールを【ja_JP.UTF-8】に設定する
setlocale(LC_ALL, 'ja_JP.UTF-8');

// ＜sample.csv＞ファイルの文字コードを、まるごと UTF-8 に変換し、＜sample-utf.csv＞として保存する
sjis_to_utf('sample.csv', 'temp/sample-utf.csv');

// sample-utf.csvを読み込む
// $csv = new SplFIleObject('temp/sample-utf.csv');
$csv = new SplFIleObject('temp/sample-utf.csv');

// CSVの読み込みオプションをつける
$csv->setFlags(SplFileObject::READ_CSV);

// sample-utf.csvを1行ずつループ処理する
// $lineはCSVをフィールド単位に区切った配列となる
foreach ($csv as $line) {
    pr($line);
}

$csv = null;


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
    // pr($from_file)   // sample.csv
    // pr($to_file)     // temp/sample-utf.csv

    pr(file_get_contents($from_file),1,1);  //元データの中身（SJIS-win） ※文字化けしてる
    pr(mb_convert_encoding(file_get_contents($from_file), $to_encoding, $from_encoding),1,1);  //UTF-8に変換後の中身 ※文字化けしていない

    file_put_contents(
        $to_file,   // データを書き込むファイルへのパス(temp/sample-utf.csv) ※存在しない場合は作成する
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

