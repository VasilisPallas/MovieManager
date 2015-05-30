function validate_add_movie_form() {

    var result = true;
    var errorMessage = '';
    var newLine = "<br/>";
    var movie_title = document.getElementById("movie_title").value;
    var movie_length = document.getElementById("movie_length").value;
    var movie_year_release = document.getElementById("movie_year_release").value;
    var file = document.getElementById("file-upload").value;

    var number_regex = new RegExp("[0-9]+");

    if (movie_title === "")
    {
        errorMessage += "Δεν έχετε δώσει τίτλο στην ταινία." + newLine;
        result = false;
    }

    if (movie_length === "")
    {
        errorMessage += "Δεν έχετε δώσει διάρκεια στην ταινία." + newLine;
        result = false;
    }

    if (!number_regex.test(movie_length) && movie_length !== "") {
        result = false;
        errorMessage += "Το πεδίο της διάρκειας θα πρέπει να έχει μόνο αριθμούς." + newLine;
    }

    if (movie_length > 300) {
        result = false;
        errorMessage += "Η ταινία δεν μπορεί να κρατάει πάνω από 5 ώρες!" + newLine;
    }

    if (movie_year_release === "") {
        result = false;
        errorMessage += "Δεν έχετε βάλει ημερομηνία έκδοσης της ταινίας" + newLine;
    }

    if (errorMessage !== '')
        Alert.render("Η εισαγωγή ταινίας περιέχει κάποια προβλήματα", errorMessage);

    return result;
}

function check_limit(element1, limit, element2) {
    var myText = document.getElementById(element1).value;


    var myTextLength = myText.length;


    var counterElement = document.getElementById(element2);

    if (myTextLength >= limit) {
        document.getElementById(element1).value = myText.substr(0, limit);

        //alert("Δεν επιτρέπεται παραπάνω κείμενο!");

        counterElement.innerHTML = "Δεν μπορείτε να γράψετε πάνω από " + limit + " χαρακτήρες!";
    }
    else {
        if (limit - myTextLength !== 0)
            counterElement.innerHTML = "Απομένουν " + (limit - myTextLength) + " χαρακτήρες";
    }

    if (myText === "")
    {
        counterElement.innerHTML = "Προαιρετικά, ως 500 χαρακτήρες.";
    }
}