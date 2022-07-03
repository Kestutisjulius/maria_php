<?php

require __DIR__.'./services/maria_db.php';

$pdo = new PDO($dsn, $user, $pass, $options);

?>
<fieldset>
    <legend>CREATE</legend>
    <form method="post">
        Title: <input type="text" name="title">
        Height: <input type="text" name="height">
        Type: <select name="type">
            <option value="1">Lapas</option>
            <option value="2">Spyglius</option>
            <option value="3">Palme</option>
        </select>
        <input type="hidden" name="_method" value="post">
        <button type="submit">create</button>
    </form>
</fieldset>
<fieldset>
    <legend>DELETE</legend>
    <form method="post">
        ID: <input type="text" name="id">
        <input type="hidden" name="_method" value="delete">
        <button type="submit">DELETE</button>
    </form>
</fieldset>
<fieldset>
    <legend>UPDATE</legend>
    <form method="post">
        ID: <input type="text" name="id">
        Title: <input type="text" name="title">
        Height: <input type="text" name="height">
        Type: <select name="type">
                <option value="1">Lapas</option>
                <option value="2">Spyglius</option>
                <option value="3">Palme</option>
              </select>

        <input type="hidden" name="_method" value="put">
        <button type="submit">UPDATE</button>
    </form>
</fieldset>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
//CREATE
        if ($_POST['_method'] == 'post'){
            $sql = "INSERT INTO trees
                    (title, height, type)
                    VALUES 
                    ( ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                     $_POST['title'],
                     $_POST['height'],
                     $_POST['type']]);
            header('Location: http://localhost/maria_php/');
            die;
        }
//UPDATE
        if ($_POST['_method'] == 'put'){
            $sql = "UPDATE trees
                    SET title = ?, height = ?, type = ?
                    WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                     $_POST['title'],
                     $_POST['height'],
                     $_POST['type'],
                    $_POST['id']]);
            header('Location: http://localhost/maria_php/');
            die;
        }

//DELETE
        if ($_POST['_method'] ?? '[s]' == 'delete'){
            $sql = "DELETE FROM trees WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_POST['id']]);
            header('Location: http://localhost/maria_php/');
            die;
        }


//READ

$sql = "
    SELECT id, title, height, type 
    FROM trees
    WHERE type = 1 OR type = 2 OR type = 3
    ORDER BY height DESC";
$sql2 = "
    SELECT type, sum(height) AS height_sum, count(id) AS trees_count, GROUP_CONCAT(title, ' .-. ') AS titles
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
    foreach ($trees2 as $treex){
        echo ('<li>'.$treex['height_sum'].' meters '.['Lapuotis', 'Spygliuotis', 'Palme'][$treex['type']-1].' '.$treex['trees_count'].$treex['titles'].'</li>');
    }
echo '</ul>';


    /**
     $stmt = $pdo->query('SELECT name FROM users');
        while ($row = $stmt->fetch())
            {
            echo $row['name'] . "\n";
            }
     */