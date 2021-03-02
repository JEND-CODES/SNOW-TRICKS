$(document).ready(function () {

    // $("#save_post").css('opacity', '0.2');
    $("#save_post").hide();

    $("#update_screen").hide();

    //**** ÉTAPE PRÉLIMINAIRE : RESTAURATION DE L'URL YOUTUBE DES VIDÉOS EN CONCATÉNANT L'URL (https://www.youtube.com/watch?v=) À L'ID DÉJÀ ENREGISTRÉ EN BDD ****//

    var update_forms = $(".screen_class");

    for (var y = 0; y < update_forms.length; y++) {

        videos_ids = $(update_forms[y]).val();

        // alert(videos_ids.length);

        if (videos_ids.length == 11) {

            $(update_forms[y]).val('https://www.youtube.com/watch?v=' + $(update_forms[y]).val());

        }

    }

    // Bouton pour recommencer le process de vérification des URLS
    $("#update_screen").click(function () {

        // On remontre le bouton de vérification des URLS
        $("#check_screen").show();

        // On cache le bouton pour recommencer le process
        $("#update_screen").hide();

        // On retire la propriété readonly sur les inputs
        $('.screen_class').prop('readonly', false);
        $(".screen_class").css('opacity', '1');

        // On cache le bouton de sauvegarde de l'article
        // $("#save_post").css('opacity', '0.2');
        $("#save_post").hide();


        // + Restauration de l'URL youtube
        var restore_forms = $(".screen_class");

        for (var y = 0; y < restore_forms.length; y++) {

            videos_url = $(restore_forms[y]).val();

            // alert(videos_url.length);

            if (videos_url.length == 11) {

                $(restore_forms[y]).val('https://www.youtube.com/watch?v=' + $(restore_forms[y]).val());

            }

        }


    });

    //**** BOUTON POUR LA RESTAURATION DE L'URL YOUTUBE, ENSUITE POUR VÉRIFIER SOIT LA VALIDITÉ DES URLS DES IMAGES SOIT LA VALIDITÉ DES URLS DES VIDÉOS, ET ENFIN POUR REMPLACER LES URLS ENTRÉES PAR L'UTILISATEUR EN IDS DE 11 CARACTÈRES (LE FORMAT DES IDS YOUTUBE) ****//
    $("#check_screen").click(function () {

        //**** ÉTAPE PRÉLIMINAIRE : RESTAURATION DE L'URL YOUTUBE DES VIDÉOS EN CONCATÉNANT L'URL (https://www.youtube.com/watch?v=) À L'ID DÉJÀ ENREGISTRÉ EN BDD ****//

        var update_forms = $(".screen_class");

        for (var y = 0; y < update_forms.length; y++) {

            videos_ids = $(update_forms[y]).val();

            // alert(videos_ids.length);

            if (videos_ids.length == 11) {

                $(update_forms[y]).val('https://www.youtube.com/watch?v=' + $(update_forms[y]).val());

            }

        }

        //**** PARTIE 1 : VÉRIFICATION DE LA VALIDITÉ DES URLS ****//

        var inputs = $(".screen_class");

        var error = 0;

        // ITÉRATIONS DE VÉRIFICATIONS ET GÉNÉRATIONS D'ERREURS EN FONCTION DES CAS RENCONTRÉS
        for (var i = 0; i < inputs.length; i++) {

            // alert($(inputs[i]).val());
            // alert($(inputs[i]).val().length);

            inputs_results = $(inputs[i]).val();

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
            if (inputs_results.indexOf('https://www.youtube.com/watch?v=') > -1 && $(inputs[i]).val().length == 43) {
                //if (inputs_results.indexOf('https://www.youtube.com/watch?v=') > -1 ) {

                // alert( "YOUTUBE URL VALIDE");
                error++;

                // On vérifie que l'input contient bien l'url youtube et qu'elle soit pourvue de 60 caractères (au cas où le param get " &feature=youtu.be " ou " &feature=emb_logo " est présent)
            } else if (inputs_results.indexOf('https://www.youtube.com/watch?v=') > -1 && $(inputs[i]).val().length == 60) {

                // alert( "YOUTUBE URL VALIDE");
                error++;

            } else if (inputs_results.indexOf('https://youtu.be/') > -1 && $(inputs[i]).val().length == 28) {

                // alert( "YOUTUBE URL VALIDE");
                error++;

            } else if (inputs_results.indexOf('https://www.youtube.com/embed/') > -1 && $(inputs[i]).val().length == 41) {

                // alert( "YOUTUBE URL VALIDE");
                error++;

            } else if (inputs_results == '') {

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
                uri = uri.split('?')[0];

                // Ensuite vérification de l'extension de l'image
                var parts = uri.split('.');

                var extension = parts[parts.length - 1];

                var imageTypes = ['jpg', 'jpeg', 'tiff', 'png', 'gif', 'bmp'];

                if (imageTypes.indexOf(extension) !== -1) {

                    // Parmi les inputs qui contiennent des liens avec des extensions images, on vérifie aussi la présence de http ou https :
                    if (uri.indexOf("http") == 0 || uri.indexOf("https") == 0) {
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
            var result = isUriImage(inputs_results);

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
            alert('MÉDIAS CONFORMES. OK POUR PUBLICATION');

            // On cache le bouton de vérification des URLS
            $("#check_screen").hide();

            // On montre le bouton pour recommencer le process
            $("#update_screen").show();

            // On passe les inputs en readonly
            $('.screen_class').prop('readonly', true);
            $(".screen_class").css('opacity', '0.2');

            // On montre le bouton d'ajout d'un article
            // $("#save_post").css('opacity', '1');
            $("#save_post").show();


        } else {

            alert('ERREURS : URLS INVALIDES DANS LES MÉDIAS. VÉRIFIEZ LA VALIDITÉ DES EXTENSIONS DES IMAGES ET/OU LA VALIDITÉ DES URLS DES VIDÉOS');

        }

        //**** PARTIE 2 : RÉCUPÉRATION DE L'ID DES VIDÉOS YOUTUBE ET REMPLACEMENT DE CHAMPS PAR L'ID ****/

        var forms = $(".screen_class");

        for (var z = 0; z < forms.length; z++) {

            forms_results = $(forms[z]).val();

            if (forms_results.indexOf('https://www.youtube.com/watch?v=') > -1 || forms_results.indexOf('https://youtu.be/') > -1 || forms_results.indexOf('https://www.youtube.com/embed/') > -1) {

                // alert( "YOUTUBE URL VALID");

                // CHANGEMENT DES TEXTES DES INPUTS QUI CONTIENNENT UNE URL YOUTUBE POUR NE RÉCUPÉRER QUE L'ID DE LA VIDÉO

                // Formats identifiés puis retirés pour isoler l'identifiant de la vidéo :
                // https://youtu.be/
                // https://www.youtube.com/embed/
                // https://www.youtube.com/watch?v=

                var regExp = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;

                var match = forms_results.match(regExp);

                if (match && match[2].length == 11) {
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