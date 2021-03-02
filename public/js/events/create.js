$(document).ready(function () {

    // GESTION DU FORMAT DE L'ARTICLE (NOMBRE DE MÉDIAS ÉDITABLES, VIDÉOS ET IMAGES)
    document.getElementById("change_screen_format").onchange = function () {
        if (this.selectedIndex !== 0) {
            window.location.href = this.value;
            confirm("ÊTES-VOUS SÛR DE VOULOIR CHANGER LE FORMAT DE L'ARTICLE ? VOS MODIFICATIONS EN COURS NE SERONT PAS SAUVEGARDÉES");
        }
    };

    // $("#save_post").css('opacity', '0.2');
    $("#save_post").hide();

    $("#update_screen").hide();

    // Bouton pour recommencer le process de vérification des URLS
    $("#update_screen").click(function () {

        // On remontre le bouton de vérification des URLS
        $("#check_screen").show();

        // On cache le bouton pour recommencer le process
        $("#update_screen").hide();

        // On retire la propriété readonly sur les inputs
        $(".screen_class").prop("readonly", false);
        $(".screen_class").css("opacity", "1");

        // On cache le bouton de sauvegarde de l'article
        // $("#save_post").css('opacity', '0.2');
        $("#save_post").hide();


        // + Restauration de l'URL youtube
        var restoreForms = $(".screen_class");

        for (var y = 0; y < restoreForms.length; y++) {

            videosUrl = $(restoreForms[y]).val();

            // alert(videosUrl.length);

            if (videosUrl.length === 11) {

                $(restoreForms[y]).val("https://www.youtube.com/watch?v=" + $(restoreForms[y]).val());

            }

        }


    });

    //**** BOUTON POUR LA RESTAURATION DE L'URL YOUTUBE, ENSUITE POUR VÉRIFIER SOIT LA VALIDITÉ DES URLS DES IMAGES SOIT LA VALIDITÉ DES URLS DES VIDÉOS, ET ENFIN POUR REMPLACER LES URLS ENTRÉES PAR L'UTILISATEUR EN IDS DE 11 CARACTÈRES (LE FORMAT DES IDS YOUTUBE) ****//
    $("#check_screen").click(function () {

        //**** ÉTAPE PRÉLIMINAIRE : RESTAURATION DE L'URL YOUTUBE DES VIDÉOS EN CONCATÉNANT L'URL (https://www.youtube.com/watch?v=) À L'ID DÉJÀ ENREGISTRÉ EN BDD ****//

        var updateForms = $(".screen_class");

        for (var y = 0; y < updateForms.length; y++) {

            videosIds = $(updateForms[y]).val();

            // alert(videosIds.length);

            if (videosIds.length === 11) {

                $(updateForms[y]).val("https://www.youtube.com/watch?v=" + $(updateForms[y]).val());

            }

        }

        //**** PARTIE 1 : VÉRIFICATION DE LA VALIDITÉ DES URLS ****//

        var inputs = $(".screen_class");

        var error = 0;

        // ITÉRATIONS DE VÉRIFICATIONS ET GÉNÉRATIONS D'ERREURS EN FONCTION DES CAS RENCONTRÉS
        for (var i = 0; i < inputs.length; i++) {

            // alert($(inputs[i]).val());
            // alert($(inputs[i]).val().length);

            inputsResults = $(inputs[i]).val();

            // Formats identifiés des URL youtube
            // https://www.youtube.com/watch?v=NKHYEOAbFyM
            // https://www.youtube.com/watch?v=NKHYEOAbFyM&feature=youtu.be
            // https://www.youtube.com/watch?v=NKHYEOAbFyM&feature=emb_logo
            // https://youtu.be/NKHYEOAbFyM
            // https://www.youtube.com/embed/NKHYEOAbFyM

            /*
            if ($(inputs[i]).val().length == 43) {
                alert("Une Url contient bien 43 caractères")
            }

            if ($(inputs[i]).val().length == 60) {
                alert("Une Url contient bien 60 caractères")
            }

            if ($(inputs[i]).val().length == 28) {
                alert("Une Url contient bien 28 caractères")
            }

            if ($(inputs[i]).val().length == 41) {
                alert("Une Url contient bien 41 caractères")
            }
            */

            // On vérifie que l'input contient bien l'url youtube et qu'elle soit pourvue de 43 caractères
            if (inputsResults.indexOf("https://www.youtube.com/watch?v=") > -1 && $(inputs[i]).val().length === 43) {
                //if (inputsResults.indexOf("https://www.youtube.com/watch?v=") > -1 ) {

                // alert( "YOUTUBE URL VALIDE");
                error++;

                // On vérifie que l'input contient bien l'url youtube et qu'elle soit pourvue de 60 caractères (au cas où le param get " &feature=youtu.be " ou " &feature=emb_logo " est présent)
            } else if (inputsResults.indexOf("https://www.youtube.com/watch?v=") > -1 && $(inputs[i]).val().length === 60) {

                // alert( "YOUTUBE URL VALIDE");
                error++;

            } else if (inputsResults.indexOf("https://youtu.be/") > -1 && $(inputs[i]).val().length === 28) {

                // alert( "YOUTUBE URL VALIDE");
                error++;

            } else if (inputsResults.indexOf("https://www.youtube.com/embed/") > -1 && $(inputs[i]).val().length === 41) {

                // alert( "YOUTUBE URL VALIDE");
                error++;

            } else if (inputsResults === "") {

                // alert( "CHAMP VIDE AUTORISÉ");
                error++;

            } else {

                // alert( "YOUTUBE URL NOT VALID");

                // Une double erreur comptabilisée ici empêchera de passer à l'étape de sauvegarde de l'article
                error++;
                error++;

            }

            // ON VÉRIFIE LES EXTENSIONS POUR LES IMAGES
            var isUriImage = function (uri) {

                // On s'assure de supprimer tous les paramètres GET indésirables (comme par exemple dans cette URL : http://meow.com/kitten.png?somehorribleparameter=1)
                uri = uri.split("?")[0];



                // Ensuite vérification de l"extension de l"image
                var parts = uri.split(".");

                var extension = parts[parts.length - 1];

                var imageTypes = ["jpg", "jpeg", "tiff", "png", "gif", "bmp"];

                if (imageTypes.indexOf(extension) !== -1) {

                    // Parmi les inputs qui contiennent des liens avec des extensions images, on vérifie aussi la présence de http ou https :
                    if (uri.indexOf("http") === 0 || uri.indexOf("https") === 0) {
                        // alert("HTTP OU HTTPS PRÉSENT");
                        // alert(uri);
                        return true;
                    } else {
                        // alert("HTTP OU HTTPS MANQUANT");
                        // alert(uri);
                        return false;
                    }

                }

            }

            // ON GÉNÈRE DES ERREURS EN FONCTION DES CAS RENCONTRÉS
            var result = isUriImage(inputsResults);

            if (result) {

                // alert( "Image URL VALID");
                error++;

            } else {

                // alert( "Image URL NOT VALID");

                // Une double erreur comptabilisée ici empêchera de passer à l'étape de sauvegarde de l'article
                error++;
                error++;

            };

        }

        // BILAN -> S'il n'y a que 3 erreurs pour un seul formulaire, c'est qu'il contient soit une URL d'image valide, soit une URL de vidéo valide

        // alert(error);

        // On divise le nombre d'erreurs comptabilisées par 3 ...
        var total = error / 3;

        // ... pour vérifier ensuite que le résultat de la division est équivalent au nombre d'input dédiés à l'édition des images ou des vidéos ...
        if (total == inputs.length) {
            // .. Et dans ce cas on autorise la publication de l'article !
            alert("MÉDIAS CONFORMES. OK POUR PUBLICATION");

            // On cache le bouton de vérification des URLS
            $("#check_screen").hide();

            // On montre le bouton pour recommencer le process
            $("#update_screen").show();

            // On passe les inputs en readonly
            $(".screen_class").prop("readonly", true);
            $(".screen_class").css("opacity", "0.2");

            // On montre le bouton d'ajout d'un article
            // $("#save_post").css('opacity', '1');
            $("#save_post").show();

        } else {

            alert("ERREURS : URLS INVALIDES DANS LES MÉDIAS. VÉRIFIEZ LA VALIDITÉ DES EXTENSIONS DES IMAGES ET/OU LA VALIDITÉ DES URLS DES VIDÉOS");

        }

        //**** PARTIE 2 : RÉCUPÉRATION DE L'ID DES VIDÉOS YOUTUBE ET REMPLACEMENT DE CHAMPS PAR L'ID ****/

        var forms = $(".screen_class");

        for (var z = 0; z < forms.length; z++) {

            formsResults = $(forms[z]).val();

            if (formsResults.indexOf("https://www.youtube.com/watch?v=") > -1 || formsResults.indexOf("https://youtu.be/") > -1 || formsResults.indexOf("https://www.youtube.com/embed/") > -1) {

                // alert( "YOUTUBE URL VALID");

                // CHANGEMENT DES TEXTES DES INPUTS QUI CONTIENNENT UNE URL YOUTUBE POUR NE RÉCUPÉRER QUE L'ID DE LA VIDÉO

                // Formats identifiés puis retirés pour isoler l'identifiant de la vidéo :
                // https://youtu.be/
                // https://www.youtube.com/embed/
                // https://www.youtube.com/watch?v=

                var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;

                var match = formsResults.match(regExp);

                if (match && match[2].length === 11) {
                    // alert(match[2]);

                    // On ne garde que l'ID de la vidéo isolé du reste et on l'injecte en remplacement de l'URL rentrée au départ par l'internaute
                    $(forms[z]).val(match[2]);

                }

            } else {
                // alert( "YOUTUBE URL NOT VALID");
            }

        }



    });

});
