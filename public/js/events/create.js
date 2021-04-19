$(document).ready(function () {

    $("#save_post").hide();
    $("#update_screen").hide();

    $("#update_screen").click(function () {
        $("#check_screen").show();
        $("#update_screen").hide();
        $(".screen_class").prop("readonly", false);
        $(".screen_class").css("opacity", "1");
        $("#save_post").hide();

        var restoreForms = $(".screen_class");

        for (var y = 0; y < restoreForms.length; y++) {

            var videosUrl = $(restoreForms[parseInt(y, 10)]).val();

            if (videosUrl.length === 11) {

                $(restoreForms[parseInt(y, 10)]).val("https://www.youtube.com/watch?v=" + $(restoreForms[parseInt(y, 10)]).val());

            }

        }

    });

    $("#check_screen").click(function () {

        var updateForms = $(".screen_class");

        for (var y = 0; y < updateForms.length; y++) {

            var videosIds = $(updateForms[parseInt(y)]).val();

            if (videosIds.length === 11) {

                $(updateForms[parseInt(y, 10)]).val("https://www.youtube.com/watch?v=" + $(updateForms[parseInt(y, 10)]).val());

            }

        }

        var inputs = $(".screen_class");

        var error = 0;

        for (var i = 0; i < inputs.length; i++) {

            var inputsResults = $(inputs[parseInt(i)]).val();

            if (inputsResults.indexOf("https://www.youtube.com/watch?v=") > -1 && $(inputs[parseInt(i, 10)]).val().length === 43) {
               
                error++;

            } else if (inputsResults.indexOf("https://www.youtube.com/watch?v=") > -1 && $(inputs[parseInt(i, 10)]).val().length === 60) {

                error++;

            } else if (inputsResults.indexOf("https://youtu.be/") > -1 && $(inputs[parseInt(i, 10)]).val().length === 28) {

                error++;

            } else if (inputsResults.indexOf("https://www.youtube.com/embed/") > -1 && $(inputs[parseInt(i, 10)]).val().length === 41) {

                error++;

            } else if (inputsResults === "") {

                error++;

            } else {

                error++;
                error++;

            }

            var isUriImage = function (uri) {

                uri = uri.split("?")[0];

                var parts = uri.split(".");

                var extension = parts[parts.length - 1];

                var imageTypes = ["jpg", "jpeg", "tiff", "png", "gif", "bmp"];

                if (imageTypes.indexOf(extension) !== -1) {

                    if (uri.indexOf("http") === 0 || uri.indexOf("https") === 0) {
                        return true;
                    } else {
                        return false;
                    }

                }

            };

            var result = isUriImage(inputsResults);

            if (result) {

                error++;

            } else {

                error++;
                error++;

            }

        }

        var total = error / 3;

        if (total === inputs.length) {
            alert("MÉDIAS CONFORMES. OK POUR PUBLICATION");

            $("#check_screen").hide();
            $("#update_screen").show();
            $(".screen_class").prop("readonly", true);
            $(".screen_class").css("opacity", "0.2");
            $("#save_post").show();

        } else {

            alert("ERREURS : URLS INVALIDES DANS LES MÉDIAS. VÉRIFIEZ LA VALIDITÉ DES EXTENSIONS DES IMAGES ET/OU LA VALIDITÉ DES URLS DES VIDÉOS");

        }

        var forms = $(".screen_class");

        for (var z = 0; z < forms.length; z++) {

            var formsResults = $(forms[parseInt(z, 10)]).val();

            if (formsResults.indexOf("https://www.youtube.com/watch?v=") > -1 || formsResults.indexOf("https://youtu.be/") > -1 || formsResults.indexOf("https://www.youtube.com/embed/") > -1) {

                var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;

                var match = formsResults.match(regExp);

                if (match && match[2].length === 11) {
            
                    $(forms[parseInt(z, 10)]).val(match[2]);

                }

            } 

        }

    });

});
