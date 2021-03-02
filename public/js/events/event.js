$(document).ready(function () {

    // Copie de valeurs d"un input à un autre dans le process de vérifications des pseudos disponibles (voir viewCheckusername.php)
    //const copy_value = $("#pseudo_checked").val(); // get the value from the first input
    //$("#input_checked").val(copy_value); // set the value to another input

    // DELAI D"AFFICHAGE DE L"INCLUDE SPINNER.HTML.TWIG (QUI PERMET D"AVOIR UN FOND BLANC DE TRANSITION ET UN EFFET DE LOADING ENTRE LES PAGES)
    $("#spinner").delay(1000).css("display", "none");

    // POUR MODIFIER L"AFFICHAGE DES MEDIAS IMAGES ET VIDÉOS SUR UN ARTICLE EN VERSION SMARTPHONE
    $(".control-medias-container").css("display", "none");

    $(".control-medias").hide();

    $(".control-medias-2").hide();

    // Voir les Breakpoints de Vuetify : https://vuetifyjs.com/en/features/breakpoints/
    if (window.matchMedia("(max-width: 959px)").matches) {

        $(".control-medias-container").css("display", "initial");

        $(".medias-grid").hide();

        $(".control-medias").show();


        $(".control-medias").click(function () {
    
            $(".medias-grid").show();

            $(".control-medias").hide();

            $(".control-medias-2").show();

        });

        $(".control-medias-2").click(function () {
    
            $(".medias-grid").hide();

            $(".control-medias-2").hide();

            $(".control-medias").show();
        
        });


    }
    
    
    
    
});
