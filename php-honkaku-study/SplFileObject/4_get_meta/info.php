<?php declare(strict_types=1); ?>

<?php require_once('/work/php-honkaku-study/config.php'); ?>

<?php
// http://localhost:8564/php-honkaku-study/SplFileObject/4_get_meta/info.php

$file = new SplFileObject('./img/flower.png');



echo '最終アクセス日時(getATime): ' . date('Y-m-d H:i:s', $file->getATime()) . '<br>' ; // 2021-09-16 14:52:45
echo '作成日時（getCtime）:' . date('Y-m-d H:i:s', $file->getCTime()) . '<br>';         //2021-09-16 14:52:43
echo 'ベース名（getBasename）:' . $file->getBasename() . '<br>';                                 //flower.png
echo '拡張子（getExtension）：' . $file->getExtension() . '<br>';      // png
echo 'ファイル名（getFilename）:' . $file->getFilename() . '<br>';     // flower.png
echo 'ファイルへのパス（getPath）：' . $file->getPath() . '<br>';        // ./img
echo '読み込み時のパス名（getPathName）；' . $file->getPathName() . '<br>'; //  ./img/flower.png
echo '絶対パス（getRealSize）:' . $file->getRealPath() . '<br>'; // /work/php-honkaku-study/SplFileObject/4_get_meta/img/flower.png
echo 'サイズ（getSize）；' . $file->getSize() . '<br>';          // 6788
echo '種別（getType）；' . $file->getType() . '<br>'; // file
echo '読み取り可能か？（isReadable）；' . $file->isReadable() . '<br>'; // 1
echo '書き込み可能か？（isWritable）：' . $file->isWritable() . '<br>'; // 1

$file = null;



