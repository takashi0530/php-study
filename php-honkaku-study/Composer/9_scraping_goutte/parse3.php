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

// スクレイピングしたデータをクロージャー外でデーターベースに保存する場合、クロージャー内でreturn命令をつかい、クロージャー外に処理を渡す
$data = $crawler->filter('.posts')->each(function ($post) {
    return [
        'posted' => $post->attr('data-posted'),
        'title' => $post->filter('h1')->text(),
        'contents' => $post->filter('p')->text()
    ];
});

pr($data);

// 出力結果
// Array
// (
//     [0] => Array
//         (
//             [posted] => 2018-11-15
//             [title] => 12/1(土)開催！フィールドアスレチック公園であそぼう
//             [contents] => 12/1(土)に、横浜市のフィールドアスレチックに行きます。 フリーフォールすべり台や、ありじごくなど、楽しいアスレチック遊具がたくさんあります。
//         )

//     [1] => Array
//         (
//             [posted] => 2018-10-11
//             [title] => 11/1～11/30開催！DIYを手伝ってお店をつくろう
//             [contents] => 期間中の土日に、クリーニング屋を改装してみんなでお店をつくります。 ペンキ塗りもできるよ。
//         )

//     [2] => Array
//         (
//             [posted] => 2018-09-01
//             [title] => 10/6開催！どんぐりを集めよう
//             [contents] => 10/6に、どんぐりをみんなで拾います。 集めたどんぐりを、どんぐり銀行に預けよう。
//         )

// )









