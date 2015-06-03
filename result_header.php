<?php
$movie_types = array("Κωμωδία", "Αισθηματική", "Περιπέτεια", "Επιστημονική Φαντασία", "Θρίλερ");
$years = range(1950, date("Y"));

function nameEllipsis($in)
{
    return strlen($in) > 27 ? mb_substr($in,0,27,'utf-8')."..." : $in;
}

require('seconds_converter.php');
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

                    <form method="get" action="results.php">
                        <input placeholder="Όνομα ταινίας" class="inputs" type="text" id="search_text" name="search_text"/><br/>
                        <p style="margin-left: 35px;">Από:</p> 
                        <select name="start_year" id="start_year" class="selection_inputs" disabled>
                            <?php
                            foreach ($years as $year):
                                echo '<option value="' . $year . '">' . $year . '</option>';
                            endforeach;
                            ?>
                        </select>

                        <p>Εώς:</p> 
                        <select name="end_year" id="end_year" class="selection_inputs" disabled>
                            <?php
                            foreach ($years as $year):
                                if ($year == date("Y")) {
                                    echo '<option selected="selected" value="' . $year . '">' . $year . '</option>';
                                } else {
                                    echo '<option value="' . $year . '">' . $year . '</option>';
                                }
                            endforeach;
                            ?>
                        </select>

                        <label><input type="checkbox" class="checkbox_inputs" name="year_range" id="year_range" onclick="moreOptions()"/><p>Διάρκεια</p></label><br/>

                        <select style="width: 70px;" disabled hidden id="sql_statement" name="sql_statement" class="selection_inputs">
                            <option value="and">ΚΑΙ</option>
                            <option value="or">Ή</option>
                        </select><br/>

                        <select name="movie_type" id="movie_type" class="selection_inputs" style="margin-left: 35px; width: 250px;" disabled>
                            <?php
                            foreach ($movie_types as $movie_type):
                                echo '<option value="' . $movie_type . '">' . $movie_type . '</option>';
                            endforeach;
                            ?>
                        </select>

                        <label><input style="margin-left: 22px;" type="checkbox" class="checkbox_inputs" name="type" id="type" onclick="moreOptions()"/><p>Είδος</p></label><br/>

                        <input class="done_button" type="submit" class="bluebutton" value="Αναζήτηση">
                    </form>

                    <script type="text/javascript">
                        function moreOptions() {
                            if (document.getElementById('year_range').checked) {
                                document.getElementById('start_year').disabled = false;
                                document.getElementById('end_year').disabled = false;
                            } else {
                                document.getElementById('start_year').disabled = true;
                                document.getElementById('end_year').disabled = true;
                            }

                            if (document.getElementById('type').checked) {
                                document.getElementById('movie_type').disabled = false;
                            } else {
                                document.getElementById('movie_type').disabled = true;
                            }

                            if (document.getElementById('year_range').checked && document.getElementById('type').checked)
                            {
                                sql_statement.hidden = false;
                                sql_statement.disabled = false;
                            } else {
                                sql_statement.hidden = true;
                                sql_statement.disabled = true;
                            }
                        }
                    </script>
                </div>

            </div>
            <div id="home"><a href="index.php"><img id="homeImage" src="images/homeImage.png" title="Αρχική" alt="Αρχική" width="250px" height="200px"/></a></div>
