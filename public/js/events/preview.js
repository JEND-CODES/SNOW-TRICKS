$(document).ready(function () {

    /**** INTERACTIVITÉ DU FORMULAIRE DE L'IMAGE EN UNE ****/
    $(".create_featured_input").prop("readonly", true);

    $(".feature_arrow_btn").hide();

    $(".feature_pen_btn").click(function () {

        $(".create_featured_input").prop("readonly", false);
        
        $(".create_feature_box").css("opacity", "1");

        $(".feature_pen_btn").hide();

        $(".feature_arrow_btn").show();

    });

    $(".feature_trash_btn").click(function () {

        $(".create_featured_input").prop("readonly", false);
        
        $(".create_feature_box").css("opacity", "1");

        $(".create_featured_input").val("");

        $(".default_img").html("<img src='/backgrounds/default_picture.jpg' width='100%' />");

        $(".feature_pen_btn").hide();

        $(".feature_arrow_btn").show();

    });

    $(".feature_arrow_btn").click(function () {

        $(".create_featured_input").prop("readonly", true);
        
        $(".create_feature_box").css("opacity", "0");

        $(".feature_pen_btn").show();

        $(".feature_arrow_btn").hide();

    });

    $(".photo-step-errors").hide();

    /**** EN CAS DE MESSAGES D'ERREUR ! ****/
    if ($(".create_feature_box:has(li)").length > 0) {

        $(".create_featured_input").prop("readonly", false);
        
        $(".create_feature_box").css("opacity", "1");

        $(".feature_pen_btn").hide();

        $(".feature_arrow_btn").show();

        $('.screen_class').css("width", "100%").css("height", "120px").css("padding", "10px 13px");

        $('.medias-multi-buttons').hide();

        $(".media_next_row_btn_1").hide();

        $(".photo-step-regular").hide();

        $(".photo-step-errors").show();

    }

    if ($(".create-col-title:has(li)").length > 0) {

        $('.screen_class').css("width", "100%").css("height", "120px").css("padding", "10px 13px");

        $('.medias-multi-buttons').hide();

        $(".media_next_row_btn_1").hide();

        $(".photo-step-regular").hide();

        $(".photo-step-errors").show();

    }

    // https://stackoverflow.com/questions/31398473/load-image-in-div-from-url-obtained-from-a-text-box

    // Working fiddle : https://jsfiddle.net/8sn5rmu6/1/

    /**** PREVIEW DE L'IMAGE EN UNE ****/
    /*$(".featured_img_btn").click(function(){

        var image_url = $(".featured_input").val();

        $(".default_img").html("<img src='"+image_url+"'>");

    });*/

    /**** PREVIEW INTERACTIVE LORSQUE L'INPUT EST DÉSÉLECTIONNÉ ****/
    $('.create_featured_input').on('change', function() {

        $('.create_featured_input').blur(function()          
        // whenever you click off an input element
        {         
                      
            if(!$(this).val()) {                      
                // if it is blank. 
                // alert('empty');

                $(".default_img").html("<img src='/backgrounds/default_picture.jpg' width='100%' />");

            } else if ($(this).val().indexOf("https://") > -1 || $(this).val().indexOf("http://") > -1) {

                var featureImage = $(".create_featured_input").val();

                $(".default_img").html("<img src='"+ featureImage +"' width='100%'>");

            } else {

                $(".default_img").html("<img src='/backgrounds/default_picture.jpg' width='100%' />");

            }

        });

    });

    /**** BOUTONS DE MODIFICATIONS DES MÉDIAS ****/

    // Attention dans le loop.index de twig il fallait mettre la mention loop.index0 (zéro pour commencer à zéro et pas à 1 !)

    // https://twig.symfony.com/doc/2.x/tags/for.html#iterating-over-keys-and-values

    // https://stackoverflow.com/questions/18819689/creating-a-for-loop-to-create-multiple-click-events-in-javascript-jquery

    $.each(Array(24), function(item) {

        var trashMedia = $(".trash_media_btn_" + item);

        $(trashMedia).click(function () {
            
            // Cacher la colonne média
            $(".create_media_" + item).hide();

            // Vider l'input du média
            $('#figure_screens_'+ item +'_thumbnail').val('');

            // Cacher le bouton corbeille
            $(".trash_media_btn_" + item).hide();

            // Montrer le bouton de réactivation du média
            $(".restore_media_btn_" + item).show();

            // Cacher le bouton qui masque l'input
            $(".hide_input_btn_" + item).hide();

            // Cacher le bouton de changement de l'input
            $(".change_input_btn_" + item).hide();

        });

    });

    $.each(Array(24), function(item2) {

        var restoreMedia = $(".restore_media_btn_" + item2);

        $(restoreMedia).click(function () {

            // Montrer la colonne média
            $(".create_media_" + item2).show();

            // Cacher le bouton de réactivation du média
            $(".restore_media_btn_" + item2).hide();

            // Montrer le bouton corbeille
            $(".trash_media_btn_" + item2).show();

            // Cacher le bouton qui masque l'input
            $(".hide_input_btn_" + item2).show();

            // Montrer le bouton de changement de l'input
            $(".change_input_btn_" + item2).hide();

            $('#figure_screens_'+ item2 +'_thumbnail').css("width", "100%").css("height", "120px").css("padding", "10px 13px");

        });

    });

    $.each(Array(24), function(item3) {

        var changeInput = $(".change_input_btn_" + item3);

        $(changeInput).click(function () {
            
            if ($('#figure_screens_'+ item3 +'_thumbnail').width() != "100%" ) {

                $('#figure_screens_'+ item3 +'_thumbnail').css("width", "100%").css("height", "120px").css("padding", "10px 13px");

                // Cacher le bouton de changement de l'input
                $(".change_input_btn_" + item3).hide();

                // Montrer le bouton qui masque l'input
                $(".hide_input_btn_" + item3).show();

            } 
                
        });

    });

    $.each(Array(24), function(item4) {

        var hideInput = $(".hide_input_btn_" + item4);

        $(hideInput).click(function () {
            
            $('#figure_screens_'+ item4 +'_thumbnail').css("width", "0px").css("height", "0px").css("padding", "0px");

            // Cacher le bouton qui masque l'input
            $(".hide_input_btn_" + item4).hide();

            // Montrer le bouton de changement de l'input
            $(".change_input_btn_" + item4).show();

        });

    });

    /**** SUPPRESSIONS DE FORMULAIRES VIDES LORS DE LA SAUVEGARDE DE L'ARTICLE ****/

    $("#save_post").click(function () {
               
            $.each(Array(24), function(item5) {

                if(!$('#figure_screens_'+ item5 +'_thumbnail').val()) {

                    $('#figure_screens_'+ item5 +'_thumbnail').remove();
                    
                }
             
            });

    });

    /**** AJOUTS DE LIGNES DE MÉDIAS SUPPLÉMENTAIRES ****/

    $(".media_next_row_btn_2").hide();
    $(".media_next_row_btn_3").hide();

    $.each(Array(24), function(item6) {

        if(item6 > 5) {

            $('.flex_col_'+ item6 +'').css("display", "none");

            // Cacher la colonne média
            $(".create_media_" + item6).hide();

            // Cacher le bouton corbeille
            $(".trash_media_btn_" + item6).hide();

            // Montrer le bouton de réactivation du média
            $(".restore_media_btn_" + item6).hide();

            // Cacher le bouton qui masque l'input
            $(".hide_input_btn_" + item6).hide();

            // Cacher le bouton de changement de l'input
            $(".change_input_btn_" + item6).hide();
        }

    });

    $(".media_next_row_btn_1").click(function () {
               
        $.each(Array(24), function(item7) {

            if(item7 > 5 && item7 < 12) {

                $('.flex_col_'+ item7 +'').css("display", "initial");

                // Montrer le bouton de réactivation du média
                $(".restore_media_btn_" + item7).show();

                $(".media_next_row_btn_1").hide();
                $(".media_next_row_btn_2").show();
                
            }
        
        });
        
    });

    $(".media_next_row_btn_2").click(function () {
               
        $.each(Array(24), function(item8) {

            if(item8 > 11 && item8 < 18) {

                $('.flex_col_'+ item8 +'').css("display", "initial");

                // Montrer le bouton de réactivation du média
                $(".restore_media_btn_" + item8).show();

                $(".media_next_row_btn_2").hide();
                $(".media_next_row_btn_3").show();
                
            }
        
        });
        
    });

    $(".media_next_row_btn_3").click(function () {
               
        $.each(Array(24), function(item9) {

            if(item9 > 17) {

                $('.flex_col_'+ item9 +'').css("display", "initial");

                // Montrer le bouton de réactivation du média
                $(".restore_media_btn_" + item9).show();

                $(".media_next_row_btn_3").hide();
                
            }
        
        });
        
    });

    /**** GÉNÉRATION DE PREVIEWS INTERACTIVES SUR LES MÉDIAS ****/
    $.each(Array(24), function(item10) {

        $('#figure_screens_'+ item10 +'_thumbnail').on('change', function() {

            $('#figure_screens_'+ item10 +'_thumbnail').blur(function() {         
                        
                if(!$(this).val()) {                      
                    // if it is blank. 
                    // alert('empty');

                    $(".default_picture_"+ item10 +"").html("<img src='/backgrounds/default_picture_2.jpg' width='100%' />");

                } else if ($(this).val().indexOf("https://www.youtube.com/watch?v=") > -1 || $(this).val().indexOf("https://youtu.be/") > -1 || $(this).val().indexOf("https://www.youtube.com/embed/") > -1) {

                var videoValue = $('#figure_screens_'+ item10 +'_thumbnail').val();

                $(".default_picture_"+ item10 +"").html("<img src='/backgrounds/youtube_capcha.jpg' width='100%' />");

                } else if ($(this).val().indexOf("https://") > -1 || $(this).val().indexOf("http://") > -1) {

                    var imageValue = $('#figure_screens_'+ item10 +'_thumbnail').val();

                    $(".default_picture_"+ item10 +"").html("<img src='"+ imageValue +"' width='100%'>");

                } else {

                    $(".default_picture_"+ item10 +"").html("<img src='/backgrounds/default_picture_2.jpg' width='100%' />");

                }

            });

        });

    });

    
    
// FIN DU DOM READY
});
