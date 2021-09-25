<?php declare(strict_types=1); ?>

<?php
/**
 * Goutteを使ったWebスクレイピング2
 *
 *  複数のノードを繰り返し処理する
 *
 */
require_once '../../config.php';

//  parse1.phpがあるディレクトリと同じディレクトリに存在するvendorディレクトリの中のautoload.phpファイルを参照
require_once('vendor/autoload.php');

use Goutte\Client;


// インスタンス化
$goutteClient = new Client();

// リクエスト方式と対象URLを指定する
$crawler = $goutteClient->request(
    'GET',
    'http://192.168.0.3:7070/php-honkaku-study/Composer/9_scraping_goutte/blog-entries.html' // 対象ウェブページのURL
);

$looped = 0;

// Crawler::each(function($node) {
// // $nodeに対する繰り返し処理
// }) ;
// eachメソッドを使って複数のノードに対して繰り返し処理をすることができる。eachメソッドの引数にはクロージャーを指定する
$crawler
    ->filter('.posts')
    ->each(function ($post) use (&$looped) {   // クロージャー内で変数$loopedにアクセスできるようにuseキーワードを使う。クロージャー内で$loopedの値を変更できるようにするため、参照渡ししている
        $looped++;
        echo '<h4>投稿' . $looped . '</h4>';
        echo '<ul>';
        echo '<li>投稿日' . $post->attr('data-posted') . '</li>';
        echo '<li>タイトル' . $post->filter('h1')->text() . '</li>';
        echo '<li>内容'  . $post->filter('p')->text() . '</li>';
        echo '</ul>';
    });



















