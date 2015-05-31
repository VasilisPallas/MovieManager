<?php
require('seconds_converter.php');

if (isset($_GET['movieID'])) {
    $id = $_GET['movieID'];
    require('params.php');
    $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
    $pdoObject->exec('set names utf8');
    $sql = "Select * from movie where movieId = $id;";
    $statement = $pdoObject->query($sql);
    if ($statement != FALSE) {
        while ($record = $statement->fetch()) {
            $title = $record['movieName'];
            $type = $record['movieType'];
            $length = $record['movieLenght'];
            $date = $record['movieYearRelease'];
            
            if ($record['movieImage'] === NULL) {
                $image = 'images/noImageAvailable.png';
            } else {
                $image = 'moviesImages/' . $record['movieImage'];
            }
            
            $description = $record['movieDesciption'];
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title ?></title>
        <link href="css/full_info_css.css" rel="stylesheet" type="text/css"/>
        <link href="css/customAlertBox_css.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="javascript/customAlertBox.js" ></script>
        <link rel="icon" 
              type="image/png" 
              href="images/favicon-96x96.png">
    </head>
    <body>
        <div id="container">

            <div id="header"></div>
            <div id="home"><a href="index.php"><img id="homeImage" src="images/homeImage.png" title="Αρχική" alt="Αρχική" width="250px" height="200px"/></a></div>

            <div id="full_info">
                <div id="image_div">
                    <img src="<?php echo $image ?>" alt="<?php echo $title ?>" title="<?php echo $title ?>"/>
                </div>

                <div id="right_area">
                    <div id="info_div">
                        <h2><?php echo $title ?></h2>
                        <h3><?php echo $type ?></h3>
                        <h3><?php echo secondsConverter($length) ?> λεπτά</h3>
                        <p><?php echo $description ?></p>
                    </div>

                    <div id="buttons_div">
                        <a href="<?php echo 'add_movie.php?movieID=' . $_GET['movieID'] ?>"><button class="edit_button" type="button">Τροποποίηση</button></a>
                        <a href="<?php echo 'delete_movie.php?movieID=' . $_GET['movieID'] ?>"><button class="delete_button" type="button">Διαγραφή</button></a>
                    </div>
                </div>
            </div>

<?php require('footer.php'); ?>

