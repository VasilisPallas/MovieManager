<?php
$movie_types = array("Κωμωδία", "Αισθηματική", "Περιπέτεια", "Επιστημονική Φαντασία", "Θρίλερ");
$years = range(1950, date("Y"));

function secondsConverter($seconds) {
    $hours = floor($seconds / 60);
    $minutes = ($seconds % 60);

    return "$hours:$minutes";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Αποτελέσματα Αναζήτησης</title>
        <link href="css/results.css" rel="stylesheet" type="text/css"/>
        <script>
            var Alert = new CustomAlert();
        </script>
        <link rel="icon" 
              type="image/png" 
              href="images/favicon-96x96.png">
    </head>
    <body>
        <div id="container">
            <div id="header">
                
                <div id="full_search">

                    <p class="search">Αναζήτηση</p><br/>

                    <input placeholder="Όνομα ταινίας" class="inputs" type="text" id="movie_title" name="movie_title"/><br/>

                    <p>Από:</p> <select name="movie_type" id="movie_type" class="selection_inputs">
                        <?php
                        foreach ($years as $year):
                            echo '<option value="' . $year . '">' . $year . '</option>';
                        endforeach;
                        ?>
                    </select>

                    <p>Εώς:</p> <select name="movie_type" id="movie_type" class="selection_inputs">
                        <?php
                        foreach ($years as $year):
                            echo '<option value="' . $year . '">' . $year . '</option>';
                        endforeach;
                        ?>
                    </select><br/>

                    <p>Είδος:</p> 
                    <select name="movie_type" id="movie_type" class="selection_inputs" style="width: 250px;">
                        <?php
                        foreach ($movie_types as $movie_type):
                            echo '<option value="' . $movie_type . '">' . $movie_type . '</option>';
                        endforeach;
                        ?>
                    </select><br/>

                    <input class="done_button" type="submit" class="bluebutton" value="Αναζήτηση">
                </div>

            </div>
            <div id="home"><a href="index.php"><img id="homeImage" src="images/homeImage.png" title="Αρχική" alt="Αρχική" width="250px" height="200px"/></a></div>

            <div class="results">
                <?php
                $p = 0;
                if ($_SERVER['REQUEST_METHOD'] == "GET") {
                    try {

                        if (!isset($_GET['search_text'])) {
                            $movie = "";
                        } else {
                            $movie = $_GET['search_text'];
                        }
                        require('params.php');
                        $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
                        $pdoObject->exec('set names utf8');
                        $sql = "Select * from movie where movieName like '%$movie%';";
                        $statement = $pdoObject->query($sql);
                        $results = $statement->rowCount();
                        $statement->closeCursor();
                        ?>
                        <?php
                        if ($results < 1) {
                            echo '<h2 class="not_found">No results found!</h2>';
                        } else {
                            if (!isset($_GET['p'])) {
                                $p = 1;
                            } else {
                                $p = $_GET['p'];
                            }
                            $page = ($p - 1) * 10;
                            $sql = "Select * from movie where movieName like '%$movie%' limit $page,10;";
                            $statement = $pdoObject->query($sql);

                            if ($statement != FALSE) {
                                while ($record = $statement->fetch()) {

                                    if ($record['movieImage'] === NULL) {
                                        $image = 'images/noImageAvailable.png';
                                    } else {
                                        $image = 'moviesImages/' . $record['movieImage'];
                                    }

                                    echo '<div class="whole_movie_result">'
                                    . '<a class="info_hyperlink" href="full_movie_info.php?movieID=' . $record['movieId'] . '">'
                                    . '<div class="image_movie_div">'
                                    . '<img class="image_movie_result" src="' . $image . '"/>'
                                    . '</div>'
                                    . '<div class="internal_movie_result">'
                                    . '<p class="movie_data" style="font-size: 1.4em"><strong>' . $record['movieName'] . '</strong></p>'
                                    . '<p class="movie_data"> Τύπος: ' . $record['movieType'] . '</p>'
                                    . '<p class="movie_data"> Διάρκεια: ' . secondsConverter($record['movieLenght']) . ' λεπτά</p>'
                                    . '<p class="movie_data"> Ημερ/νια κυκλοφορίας: ' . date('d/m/Y', strtotime($record['movieYearRelease'])) . '</p>'
                                    . '</div>'
                                    . '</a>'
                                    . '<div class="option_div">'
                                    . '<a href="add_movie.php?movieID=' . $record['movieId'] . '" alt="edit" title="edit"><p class="edit_movie">&#xe104;</p></a>'
                                    . '<a href="delete_movie.php?movieID=' . $record['movieId'] . '" alt="delete" title="delete"><p class="delete_movie">&#xe107;</p></a>'
                                    . '<div class="vr"></div>'
                                    . '</div>'
                                    . '</div>';
                                }
                            }
                            ?>
                        </div>

                        <?php
                        $end = 0;
                        if ($results >= 11) {
                            $apot = $results / 10;
                            $x = ceil($apot);
                            echo '<div id="pagination">'
                            . '<ul>';
                            for ($i = 1; $i <= $x; $i++) {
                                $end = $x;
                                if ($i == $p) {
                                    echo ' <li><a class="current_link" href="results.php?movieID=' . $movie . '&p=' . $i . '">' . $i . '</a></li>';
                                } else {
                                    echo ' <li><a href="results.php?movieID=' . $movie . '&p=' . $i . '">' . $i . '</a></li>';
                                }
                            }
                            echo '</ul>'
                            . '</div>';
                        }
                    }
                } catch (PDOException $e) {
                    
                } finally {
                    $statement->closeCursor();
                    $pdoObject = null;
                }
            }
            require('footer.php');
            ?>

