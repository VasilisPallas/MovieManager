<?php
require('customAlert.php');
if (isset($_GET['msg'])) {
    if ($_GET['msg'] == 1) {
        ?>
        <script>
            var Alert = new CustomAlert();
            Alert.render("Κατασταση εισαγωγής", "Η ταινία προστέθηκε επιτυχώς!");
        </script>
        <?php
    } else if ($_GET['msg'] == -2) {
        ?>
        <script>
            var Alert = new CustomAlert();
            Alert.render("Κατασταση εισαγωγής", "Η εισαγωγή απέτυχε.");
        </script>
        <?php
    } else if ($_GET['msg'] == 3) {
        ?>
        <script>
            var Alert = new CustomAlert();
            Alert.render("Κατασταση εισαγωγής", "Αδύνατη η σύνδεση με τον server.<br/>Δοκιμάστε ξανά σε λίγο.");
        </script>
        <?php
    } else if ($_GET['msg'] == -1) {
        ?>
        <script>
            var Alert = new CustomAlert();
            Alert.render("Κατασταση τροποποίησης", "Η τροποποίηση απέτυχε.");
        </script>
        <?php
    } else if ($_GET['msg'] == 0) {
        ?>
        <script>
            var Alert = new CustomAlert();
            Alert.render("Κατασταση τροποποίησης", "Η ταινία τροποποιήθηκε επιτυχώς!");
        </script>
        <?php
    }
}

$title = NULL;
$type = NULL;
$length = NULL;
$date = NULL;
$image = NULL;
$description = NULL;

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
            $image = $record['movieImage'];
            $description = $record['movieDesciption'];
        }
    }
}
?>

<div id="add_movie_form">
    <?php
    $movie_types = array("Κωμωδία", "Αισθηματική", "Περιπέτεια", "Επιστημονική Φαντασία", "Θρίλερ");
    ?>
    <form enctype="multipart/form-data" method="POST" action="
    <?php
    if (isset($_GET['movieID'])) {
        echo 'add_movie_handler.php?movieID=' . $id;
    } else {
        echo 'add_movie_handler.php';
    }
    ?>" onsubmit="return validate_add_movie_form();">
        <p>Όνομα Ταινίας</p><br/>
        <input class="inputs" type="text" id="movie_title" name="movie_title" value="<?php echo $title; ?>"/><br/>

        <p>Είδος Ταινίας</p><br/>
        <select name="movie_type" id="movie_type" class="inputs" style="width: 250px;">
            <?php
            foreach ($movie_types as $movie_type):
                if ($movie_type == $type) {
                    echo '<option selected="selected" value="' . $movie_type . '">' . $movie_type . '</option>';
                } else {
                    echo '<option value="' . $movie_type . '">' . $movie_type . '</option>';
                }
            endforeach;
            ?>
        </select>

        <p>Διάρκεια Ταινίας</p><br/>
        <input class="inputs" value="<?php echo $length; ?>" style="width: 40px;" type="text" id="movie_length" name="movie_length"/><br/>

        <p>Ημερομηνία Έκδοσης</p><br/>

        <input class="inputs" value="<?php echo $date; ?>" type="date" id="movie_year_release" name="movie_year_release"/><br/>

        <p>Εισαγωγή φωτογραφίας</p><br/>

        <label for="file-upload" class="custom-file-upload">
            Επιλογή φωτογραφίας
        </label>
        <input id="file-upload" value="<?php echo $image ?>" name="file-upload" type="file" accept="image/*"/>

        <p>Περιγραφή Ταινίας</p><br/>
        <textarea class="textareaInputs" value="<?php echo $description; ?>" type="text" id="movie_description" name="movie_description" onkeyup="check_limit('movie_description', 500, 'chars_left_counter');"></textarea><br/>
        <p id="chars_left_counter">Προαιρετικά, ως 500 χαρακτήρες.</p><br/>

        <input class="done_button" type="submit" class="bluebutton" value=<?php
            if (isset($_GET['movieID'])) {
                echo "Τροποποίηση";
            } else {
                echo "Εισαγωγή";
            }
            ?>><br/>
    </form>
</div>
