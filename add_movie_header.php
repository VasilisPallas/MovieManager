<?php
if (isset($_GET['movieID'])) {
    $title_text = 'Τροποποίηση ταινίας';
} else {
    $title_text = 'Εισαγωγή ταινίας';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title_text ?></title>
        <link href="css/add_movie_css.css" rel="stylesheet" type="text/css"/>
        <link href="css/customAlertBox_css.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="javascript/validations.js" ></script>
        <script type="text/javascript" src="javascript/customAlertBox.js" ></script>
        <script>
            var Alert = new CustomAlert();
        </script>
        <link rel="icon" 
              type="image/png" 
              href="images/favicon-96x96.png">
    </head>
    <body>
        <div id="container">
            <div id="header" ></div>
            <div id="home"><a href="index.php"><img id="homeImage" src="images/homeImage.png" title="Αρχική" alt="Αρχική" width="250px" height="200px"/></a></div>
