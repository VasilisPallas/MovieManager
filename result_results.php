
<div class="results">
    <?php
    $p = 0;
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        try {
            require('params.php');
            $pdoObject = new PDO("mysql:host=$dbhost; dbname=$dbname;", $dbuser, $dbpass);
            $pdoObject->exec('set names utf8');

            if (isset($_GET['search_text'])) {
                $movie = $_GET['search_text'];
            } else {
                $movie = "";
            }

            if (isset($_GET['start_year'], $_GET['end_year'])) {
                $startYear = $_GET['start_year'];
                $endYear = $_GET['end_year'];
            }

            if (isset($_GET['movie_type'])) {
                $movieType = $_GET['movie_type'];
            }


            if (isset($_GET['sql_statement'])) {
                $statement = (string) $_GET['sql_statement'];
            }

            if (!isset($_GET['start_year']) && !isset($_GET['end_year']) && !isset($_GET['movie_type'])) {
                $sql = "Select * from movie where movieName like '%$movie%';";
            } else if (isset($_GET['start_year']) && isset($_GET['end_year']) && !isset($_GET['movie_type'])) {
                $sql = "Select * from movie where (movieName like '%$movie%') AND (year(movieYearRelease) between  $startYear and $endYear);";
            } else if (isset($_GET['movie_type']) && !isset($_GET['start_year']) && !isset($_GET['end_year'])) {
                $sql = "select * from movie where (movieName like '%$movie%') and (movieType = '$movieType');";
            } else if (isset($_GET['start_year']) && isset($_GET['end_year']) && isset($_GET['sql_statement']) && isset($_GET['movie_type'])) {
                $sql = "select * from movie where (year(movieYearRelease) between  $startYear and $endYear) $statement (movieType = '$movieType');";
            }

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


                if (!isset($_GET['start_year']) && !isset($_GET['end_year']) && !isset($_GET['movie_type'])) {
                    $sql = "Select * from movie where movieName like '%$movie%' limit $page,10;";
                } else if (isset($_GET['start_year']) && isset($_GET['end_year']) && !isset($_GET['movie_type'])) {
                    $sql = "Select * from movie where (movieName like '%$movie%') AND (year(movieYearRelease) between  $startYear and $endYear) limit $page,10;";
                } else if (isset($_GET['movie_type']) && !isset($_GET['start_year']) && !isset($_GET['end_year'])) {
                    $sql = "select * from movie where movieName like '%$movie%' and movieType = '$movieType' limit $page,10;";
                } else if (isset($_GET['start_year']) && isset($_GET['end_year']) && isset($_GET['sql_statement']) && isset($_GET['movie_type']) && $statement == "and") {
                    $sql = "select * from movie where (year(movieYearRelease) between  $startYear and $endYear) and (movieType = '$movieType') limit $page,10;";
                } else if (isset($_GET['start_year']) && isset($_GET['end_year']) && isset($_GET['sql_statement']) && isset($_GET['movie_type']) && $statement == "or") {
                    $sql = "select * from movie where (year(movieYearRelease) between  $startYear and $endYear) or (movieType = '$movieType') limit $page,10;";
                }

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