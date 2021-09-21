<?php declare(strict_types=1); ?>

<?php require_once('/work/php-honkaku-study/config.php'); ?>

<?php
// http://localhost:8564/php-honkaku-study/SplFileObject/5_dir_iterator/dir.php

//
$dir = new DirectoryIterator('./files');

foreach ($dir as $key => $file) {
    pr($key  . '回目');



    if ($file->isDot()) {
        pr('isDotです');
        pr($file);
        pr($file->getPathname());
        echo '<br><br><br>';
        continue;
    }

    $type = '';

    if ($file->isFile()) {
        pr($file);
        pr($file->getPathname());
        $type = 'ファイルです';
    }

    if ($file->isDir()) {
        pr($file);
        pr($file->getPathname());
        $type = 'ディレクトリです';
    }

    if ($file->isLink()) {
        pr($file);
        $type .= '(シンボリックリンクです)';
    }

    // SplFileInfoクラスの各種メソッドも使用できる
    pr(date('Y-m-d H:i:s', $file->getATime()), '$file->getATime()');

    echo $type . '：' . $file->getFileName() . '<br><br><br>';
}




// 0回目
// DirectoryIterator Object
// (
//     [pathName:SplFileInfo:private] => ./files/flower.png
//     [fileName:SplFileInfo:private] => flower.png
//     [glob:DirectoryIterator:private] =>
//     [subPathName:RecursiveDirectoryIterator:private] =>
// )
// ./files/flower.png
// ファイルです：flower.png


// 1回目
// DirectoryIterator Object
// (
//     [pathName:SplFileInfo:private] => ./files/sample.csv
//     [fileName:SplFileInfo:private] => sample.csv
//     [glob:DirectoryIterator:private] =>
//     [subPathName:RecursiveDirectoryIterator:private] =>
// )
// ./files/sample.csv
// ファイルです：sample.csv


// 2回目
// DirectoryIterator Object
// (
//     [pathName:SplFileInfo:private] => ./files/sample.txt
//     [fileName:SplFileInfo:private] => sample.txt
//     [glob:DirectoryIterator:private] =>
//     [subPathName:RecursiveDirectoryIterator:private] =>
// )
// ./files/sample.txt
// ファイルです：sample.txt


// 3回目
// DirectoryIterator Object
// (
//     [pathName:SplFileInfo:private] => ./files/temp
//     [fileName:SplFileInfo:private] => temp
//     [glob:DirectoryIterator:private] =>
//     [subPathName:RecursiveDirectoryIterator:private] =>
// )
// ./files/temp
// ディレクトリです：temp


// 4回目
// isDotです
// DirectoryIterator Object
// (
//     [pathName:SplFileInfo:private] => ./files/.
//     [fileName:SplFileInfo:private] => .
//     [glob:DirectoryIterator:private] =>
//     [subPathName:RecursiveDirectoryIterator:private] =>
// )
// ./files/.



// 5回目
// isDotです
// DirectoryIterator Object
// (
//     [pathName:SplFileInfo:private] => ./files/..
//     [fileName:SplFileInfo:private] => ..
//     [glob:DirectoryIterator:private] =>
//     [subPathName:RecursiveDirectoryIterator:private] =>
// )
// ./files/..


