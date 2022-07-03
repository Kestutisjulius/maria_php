<?php
require __DIR__.'./services/maria_db.php';

$pdo = new PDO($dsn, $user, $pass, $options);

$sql = 'SELECT p.title AS post, t.title AS tag, p.id AS post_id, t.id AS tag_id
        FROM posts AS p 
        LEFT JOIN posts_tags AS pt
        ON pt.post_id = p.id
        LEFT JOIN tags as t
        ON pt.tag_id = t.id
        ORDER BY t.title ASC 
        ' ;

$stmt = $pdo->query($sql);

$posts_tags = $stmt->fetchAll();


echo '<pre>';

    $out= [];
foreach ($posts_tags as $pt){
        if(!isset($out[$pt['post_id']])){
            $out[$pt['post_id']] = ['title' => $pt['post'], 'tags' => []];
        }
        $out[$pt['post_id']]['tags'][$pt['tag_id']] = $pt['tag'];

}
print_r($out);

//echo '<ul>';
//foreach ($posts_tags as $pt){
//    echo ('<li>'.$pt['post'].' <strong style="color: crimson; background-color: bisque">have</strong> '.$pt['tag'].'</li>');
//}
//echo '</ul>';