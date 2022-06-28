<?php

require __DIR__.'./services/maria_db.php';

$pdo = new PDO($dsn, $user, $pass, $options);

$sql = "
    SELECT id, title, height, type 
    FROM trees
    WHERE type = 1 OR type = 2 OR type = 3
    ORDER BY height DESC";
$sql2 = "
    SELECT type, sum(height) AS height_sum, count(id) AS trees_count, GROUP_CONCAT(title, ' & ') AS titles
    FROM trees
    GROUP BY type
    ";

    $stmt = $pdo->query($sql);
    $stmt2 = $pdo->query($sql2);

$trees = $stmt->fetchAll();
$trees2 = $stmt2->fetchAll();

echo '<ul>';
    foreach ($trees as $tree){
        echo ('<li>'.$tree['id'].' '.$tree['title'].' are '.$tree['height'].' meters and ^_^ '.['Lapuotis', 'Spygliuotis', 'Palme'][$tree['type']-1].'</li>');
    }
echo '</ul>';

    echo '<hr>';

echo '<ul>';
    foreach ($trees2 as $tree){
        echo ('<li>'.$tree['height_sum'].' meters '.['Lapuotis', 'Spygliuotis', 'Palme'][$tree['type']-1].' '.$tree['trees_count'].$tree['titles'].'</li>');
    }
echo '</ul>';


    /**
     $stmt = $pdo->query('SELECT name FROM users');
        while ($row = $stmt->fetch())
            {
            echo $row['name'] . "\n";
            }
     */