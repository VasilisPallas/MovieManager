<?php

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['movieID'])) {

    $imageName;

    try {
        require('params.php');
        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
        $pdoObject->exec('set names utf8');

        $id = $_GET['movieID'];

        $sql = "Select movieImage from movie where movieId = $id;";
        $statement = $pdoObject->query($sql);

        if ($statement != FALSE) {
            while ($record = $statement->fetch()) {
                $imageName = $record['movieImage'];
            }
        }

        $sql = 'delete from movie where movieId=:id;';
        $statement = $pdoObject->prepare($sql);
        $statement->execute(array(':id' => $_GET['movieID']));

        $filePath = 'moviesImages/';
        $fileDelResult = unlink($filePath . $imageName);

        header('Location: index.php?msg=1');
        exit();
    } catch (Exception $ex) {
        header('Location: index.php?msg=2');
        exit();
    } finally {
        $statement->closeCursor();
        $pdoObject = null;
    }
} else {
    header('Location: index.php?msg = 3');
    exit();
}
?>