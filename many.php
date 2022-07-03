<?php
require __DIR__.'./services/maria_db.php';

$pdo = new PDO($dsn, $user, $pass, $options);


//READ

$sql = "
    SELECT tt.id, height, tt.title, ty.title AS type_title
    FROM type_trees AS tt
    RIGHT JOIN types AS ty
    ON tt.type = ty.id
    ORDER BY type_title ASC ";
$sqlLeft = "
    SELECT tt.id, height, tt.title, ty.title AS type_title
    FROM type_trees AS tt
    LEFT JOIN types AS ty
    ON tt.type = ty.id
    ORDER BY type_title ASC ";
$sqlInner = "
    SELECT tt.id, tt.height, tt.title, ty.title AS type_title
    FROM type_trees AS tt
    INNER JOIN types AS ty
    ON tt.type = ty.id";

$stmt = $pdo->query($sqlInner);

$trees = $stmt->fetchAll();


echo '<ul>';
foreach ($trees as $tree){
    echo ('<li>'.$tree['id'].' '.$tree['title'].' are '.$tree['height'].' meters and ^_^ '.($tree['type_title'] ? $tree['type_title'] : '---').'</li>');
}
echo '</ul>';