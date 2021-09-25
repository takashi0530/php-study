<?php declare(strict_types=1); ?>

<?php
/**
 * Goutteを使ったWebスクレイピング
 *
 *
 * インストール
 * composer require fabpot/goutte "^3.2.3"
 *
 * スクレイピングできるかどうかは以下で確認
 * curl -I http://192.168.0.3:7070/php-honkaku-study/Composer/9_scraping_goutte/blog-entries.html
 *
 */
require_once '../../config.php';

//  parse1.phpがあるディレクトリと同じディレクトリに存在するvendorディレクトリの中のautoload.phpファイルを参照
require_once('vendor/autoload.php');

use Goutte\Client;

// インスタンス化する
$goutteClient = new Client();

// localhostでは失敗する
// $crawler = $goutteClient->request('GET', 'http://localhost:7070/php-honkaku-study/sample/chapter10/goutte/blog-entries.html');

// $google = $goutteClient->request(
//     'GET', // HTTPメソッド
//     'https://google.com' // 対象ウェブページのURL
// );



// HTTPリクエストを送信してHTMLをロードする
// requestメソッドを使い、変数にhtmlのノード情報が格納される     Symfony\Component\DomCrawler\Crawler クラスのインスタンスが返る
$crawler = $goutteClient->request(
    'GET', // HTTPメソッド
    // 'http://192.168.0.3:7070/php-honkaku-study/sample/chapter10/goutte/blog-entries.html' // 対象ウェブページのURL
       'http://192.168.0.3:7070/php-honkaku-study/Composer/9_scraping_goutte/blog-entries.html' // 対象ウェブページのURL
);




/*
* 1番目のイベントタイトルである「12/1(土)開催！フィールドアスレチック公園であそぼう」を出力する例
*/

// 方法１：filter()で<h1>ノードのみを抽出し、first()でその１番目を取得  first()とeq(0)は同じ意味
echo $crawler->filter('.posts > h1')->first()->text() . '<br>';

// 方法2：filter()で.postsノードのみを抽出し、eq(0)で、その1番目を取得。
//        さらに、filter()で<h1>ノードのみを抽出。
//        なお、eq(0)はfirst()を使っても構いません。
echo $crawler->filter('.posts')->eq(0)->filter('h1')->text() . '<br>';

// 方法3：filter()で、#entriesノードを抽出し、children()で子ノードを抽出。
//        さらに、first()で1番目のみを抽出し、filter()で<h1>ノードのみを抽出
echo $crawler->filter('#entries')->children()->first()->filter('h1')->text() . '<br>';



/*
* 2番目のイベントタイトルである「11/1～11/30開催！DIYを手伝ってお店をつくろう」を出力する例
*/

// 方法1：filter()で<h1>ノードのみを抽出し、eq(1)で、その2番目を取得。
echo $crawler->filter('.posts > h1')->eq(1)->text() . '<br>';


// 方法2：filter()で.postsノードのみを抽出し、eq(1)で、その2番目を取得。
//        さらに、filter()で<h1>ノードのみを抽出。
echo $crawler->filter('.posts')->eq(1)->filter('h1')->text() . '<br>';


// 方法3：filter()で、#entriesノードを抽出し、children()で子ノードを抽出。
//        さらに、eq(1)で2番目のみを抽出し、filter()で<h1>ノードのみを抽出。
echo $crawler->filter('#entries')->children()->eq(1)->filter('h1')->text() . '<br>';


// 方法4：filter()で1番目のイベントを取得した後、nextAll()->eq(0)で2番目に移動し、<h1>ノードを抽出。
echo $crawler->filter('.posts')->eq(0)->nextAll()->eq(0)->filter('h1')->text() . '<br>';



// メモ
/**
 *
 * ■ 絞り込みメソッド一覧
 * eq(n)                    n番目のノードのみを取得（０始まり）
 * first()                  最初のノードのみを取得
 * last()                   最後のノードのみを取得
 * parens()                 親ノードを取得
 * children()               全ての子ノードを取得
 * siblings()               全ての兄弟ノードを取得
 * previousAll()            現在ノードの前にある全ての兄弟ノードを取得
 * nextAll()                現在ノードのあとにある全ての兄弟ノードを取得
 * selectLink($value)       $valueと一致するリンク文字列を持つ全てのリンクを取得
 * selectButton($value)     $valueと一致するラベルを持つ全てのボタンを取得
 *
 *
 * ■ ノード値取得メソッド （ほしいノードに辿り着いたあと、以下のメソッドを使用してノード値を取得する）
 * attr($attribute)         $attribute属性名を持つ最初の属性値を取得
 * text()                   そのノードが持つ最初のテキストノードを取得
 * extract($attribute)      配列$attributeの属性値を取得
 *
 */

//  指定した属性名に対応する属性値をまとめて返すメソッド  extract
// sectionタグのclassとdata-postedの値を配列で全て取得
pr($crawler->filter('section')->extract([
    'class',
    'data-posted'
]));
// ＜出力結果＞
// Array
// (
//     [0] => Array
//         (
//             [0] => posts
//             [1] => 2018-11-15
//         )

//     [1] => Array
//         (
//             [0] => posts
//             [1] => 2018-10-11
//         )

//     [2] => Array
//         (
//             [0] => posts
//             [1] => 2018-09-01
//         )

// )


// _textとすることでテキスト部分が配列で返ってくる
// textメソッドは最初の単一テキストのみ返すが、extractメソッドは配列で返す点がことなる
pr($crawler->filter('.posts > h1')->extract(['_text']));
// Array
// (
//     [0] => 12/1(土)開催！フィールドアスレチック公園であそぼう
//     [1] => 11/1～11/30開催！DIYを手伝ってお店をつくろう
//     [2] => 10/6開催！どんぐりを集めよう
// )









// <!DOCTYPE html>
// <html>
// <head>
//     <meta charset="utf-8">
//     <title>こどもイベント情報 - honkaku</title>
// </head>
// <body>
//     <h1>こどもイベント情報</h1>
//     <h2>楽しいこどもイベントを紹介するブログです。</h2>
//     <p>こどもが楽しめるイベントを発信するブログ記事の一覧です。</p>
//     <hr>
//     <article id="entries">
//         <section class="posts" data-posted="2018-11-15">
//             <h1>12/1(土)開催！フィールドアスレチック公園であそぼう</h1>
//             <p>
//                 12/1(土)に、横浜市のフィールドアスレチックに行きます。<br>
//                 フリーフォールすべり台や、ありじごくなど、楽しいアスレチック遊具がたくさんあります。
//             </p>
//         </section>
//         <section class="posts" data-posted="2018-10-11">
//             <h1>11/1～11/30開催！DIYを手伝ってお店をつくろう</h1>
//             <p>
//                 期間中の土日に、クリーニング屋を改装してみんなでお店をつくります。<br>
//                 ペンキ塗りもできるよ。
//             </p>
//         </section>
//         <section class="posts" data-posted="2018-09-01">
//             <h1>10/6開催！どんぐりを集めよう</h1>
//             <p>
//                 10/6に、どんぐりをみんなで拾います。<br>
//                 集めたどんぐりを、どんぐり銀行に預けよう。
//             </p>
//         </section>
//     </article>
// </body>
// </html>























