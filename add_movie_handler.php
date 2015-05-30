<?php

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST)) {

    if (isset($_POST['movie_title']) && isset($_POST['movie_type']) && isset($_POST['movie_length']) && isset($_POST['movie_year_release'])) {
        $movieDescription = NULL;
        if (isset($_POST['movie_description'])) {
            $movieDescription = $_POST['movie_description'];
        }
        $movieTitle = $_POST['movie_title'];
        $movieType = $_POST['movie_type'];
        $movieLength = $_POST['movie_length'];
        $movieYaerRelease = $_POST['movie_year_release'];
        $new_filename;
        if (is_uploaded_file($_FILES['file-upload']['tmp_name'])) {
            $filename = $_FILES['file-upload']['name'];
            $ext = strtolower(substr($filename, -3));
            $new_filename = uniqid("movieProfileImage-", true) . '.' . $ext;
            $copied = copy($_FILES['file-upload']['tmp_name'], 'moviesImages/' . $new_filename);
            if (isset($_GET['movieID'])) {
                try {
                    $msg;
                    $error_msg;
                    require('params.php');
                    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                    $pdoObject->exec('set names utf8');

                    $id = $_GET['movieID'];

                    $sql = "Select movieImage from Movie where movieId = $id;";

                    $statement = $pdoObject->query($sql);

                    if ($statement != FALSE) {
                        while ($record = $statement->fetch()) {
                            $imageName = $record['movieImage'];
                        }
                    }
                } catch (PDOException $e) {
                    header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
                    exit();
                } finally {
                    $statement->closeCursor();
                    $pdoObject = null;
                }

                $filePath = 'moviesImages/';
                $fileDelResult = unlink($filePath . $imageName);
            }
        }

        try {
            $msg;
            $error_msg;
            require('params.php');
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject->exec('set names utf8');
            if (isset($_GET['movieID'])) {
                $id = $_GET['movieID'];
                if (is_uploaded_file($_FILES['file-upload']['tmp_name'])) {
                    $sql = "UPDATE Movie SET movieName = :movieTitle, movieType = :movieType, movieLenght = :movieLength, movieYearRelease = :movieYearRelease, movieDesciption = :movieDesciption, movieImage = :filename "
                            . "WHERE movieId = $id;";
                } else {
                    $sql = "UPDATE Movie SET movieName = :movieTitle, movieType = :movieType, movieLenght = :movieLength, movieYearRelease = :movieYearRelease, movieDesciption = :movieDesciption "
                            . "WHERE movieId = $id;";
                }
                $msg = 0;
                $error_msg = -1;
            } else {
                $sql = 'INSERT INTO Movie (movieName,movieType,movieLenght,movieYearRelease,movieDesciption,movieImage)
            VALUES (:movieTitle,:movieType,:movieLength,:movieYearRelease,:movieDesciption,:filename);';
                $msg = 1;
                $error_msg = -2;
            }

            $statement = $pdoObject->prepare($sql);
            if (is_uploaded_file($_FILES['file-upload']['tmp_name']) && isset($_GET['movieID'])) {
                $myResult = $statement->execute([':movieTitle' => $movieTitle,
                    ':movieType' => $movieType,
                    ':movieLength' => $movieLength,
                    ':movieYearRelease' => $movieYaerRelease,
                    ':movieDesciption' => $movieDescription,
                    ':filename' => $new_filename]);
            } else if ((!is_uploaded_file($_FILES['file-upload']['tmp_name']) && isset($_GET['movieID']))) {
                $myResult = $statement->execute([':movieTitle' => $movieTitle,
                    ':movieType' => $movieType,
                    ':movieLength' => $movieLength,
                    ':movieYearRelease' => $movieYaerRelease,
                    ':movieDesciption' => $movieDescription]);
            } else {
                $myResult = $statement->execute([':movieTitle' => $movieTitle,
                    ':movieType' => $movieType,
                    ':movieLength' => $movieLength,
                    ':movieYearRelease' => $movieYaerRelease,
                    ':movieDesciption' => $movieDescription,
                    ':filename' => $new_filename]);
            }
        } catch (PDOException $e) {
            header('Location: index.php?msg=Αδύνατη η σύνδεση με τον server');
            exit();
        } finally {
            $statement->closeCursor();
            $pdoObject = null;
        }

        if ($myResult) {
            header('Location: add_movie.php?msg=' . $msg);
            exit();
        } else {
            header('Location: add_movie.php?msg=' . $error_msg);
            exit();
        }
    }
} else {
    header('Location: add_movie.php?msg=3');
    exit();
}
?>

