<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Καλώς ορίσατε στο MyMovies</title>
        <link href="css/index_css.css" rel="stylesheet" type="text/css"/>
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
                    <?php
                    require('customAlert.php');
                    if (isset($_GET['msg'])) {
                        if ($_GET['msg'] == 1) {
                            ?>
                    <script>
                        var Alert = new CustomAlert();
                        Alert.render("Κατασταση διαγραφής", "Η ταινία διαγράφηκε επιτυχώς!");
                    </script>
                    <?php
                } else if ($_GET['msg'] == -2) {
                    ?>
                    <script>
                        var Alert = new CustomAlert();
                        Alert.render("Κατασταση εισαγωγής", "Αδύνατη η σύνδεση με τον server");
                    </script>
                    <?php
                } else if ($_GET['msg'] == 3) {
                    ?>
                    <script>
                        var Alert = new CustomAlert();
                        Alert.render("Κατασταση εισαγωγής", "Αδύνατη η σύνδεση με τον server.<br/>Δοκιμάστε ξανά σε λίγο.");
                    </script>
                    <?php
                } else if ($_GET['msg'] == 0) {
                    ?>
                    <script>
                        var Alert = new CustomAlert();
                        Alert.render("Κατασταση Τροποποίησης", "Η τροποποίηση της ταινίας έγινε με επιτυχία!");
                    </script>
                    <?php
                } else if ($_GET['msg'] == -1) {
                    ?>
                    <script>
                        var Alert = new CustomAlert();
                        Alert.render("Κατασταση Τροποποίησης", "Αδύνατη η σύνδεση με τον server!");
                    </script>
                    <?php
                }
            }
            ?>