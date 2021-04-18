$(document).ready(function () {

    /**** INTERACTIVITÉ DU FORMULAIRE DE L'IMAGE EN UNE ****/
    $(".update_featured_input").prop("readonly", true);
    // $(".update_featured_input").css("opacity", "0");

    $(".feature_arrow_btn").hide();

    $(".feature_pen_btn").click(function () {

        $(".update_featured_input").prop("readonly", false);
        
        $(".update_feature_box").css("opacity", "1");

        $(".feature_pen_btn").hide();

        $(".feature_arrow_btn").show();

    });

    $(".feature_trash_btn").click(function () {

        $(".update_featured_input").prop("readonly", false);
        
        $(".update_feature_box").css("opacity", "1");

        $(".update_featured_input").val("");

        $(".index-img").html("<img src='/backgrounds/default_picture.jpg' width='100%' />");

        $(".feature_pen_btn").hide();

        $(".feature_arrow_btn").show();

    });

    $(".feature_arrow_btn").click(function () {

        $(".update_featured_input").prop("readonly", true);
        
        $(".update_feature_box").css("opacity", "0");

        $(".feature_pen_btn").show();

        $(".feature_arrow_btn").hide();

    });

    /**** PREVIEW INTERACTIVE DE L'IMAGE EN UNE ****/
    $('.update_featured_input').on('change', function() {

        $('.update_featured_input').blur(function() {         
                      
            if(!$(this).val()) {     

                $(".index-img").html("<img src='/backgrounds/default_picture.jpg' width='100%' />");

            } else if ($(this).val().indexOf("https://") > -1 || $(this).val().indexOf("http://") > -1) {

                var featureImage = $(".update_featured_input").val();

                $(".index-img").html("<img src='"+ featureImage +"' width='100%'>");

            } else {

                $(".index-img").html("<img src='/backgrounds/default_picture.jpg' width='100%' />");

            }

        });

    });

    $.each(Array(24), function(item) {

        var trashMedia = $(".trash_media_btn_" + item);

        $(trashMedia).click(function () {
            
            // Cacher la colonne média
            $(".update_media_" + item).hide();

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
            $(".update_media_" + item2).show();

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

    /**** AJOUTS DE LIGNES DE MÉDIAS SUPPLÉMENTAIRES ****/

    $(".media_next_row_btn_2").hide();
    $(".media_next_row_btn_3").hide();

    $(".fake_btn").click(function () {

        $.each(Array(24), function(item6) {

            // if(item6 > 5) {
            if($('#figure_screens_'+ item6 +'_thumbnail').val().length === 0 && item6 > 5) {

                $('.flex_col_'+ item6 +'').css("display", "none");

                // Cacher la colonne média
                $(".update_media_" + item6).hide();

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

    });

    $(".media_next_row_btn_1").click(function () {
               
        $.each(Array(24), function(item7) {

            // if(item7 > 5 && item7 < 12) {
            if($('#figure_screens_'+ item7 +'_thumbnail').val().length === 0 && item7 > 5) {

                $('.flex_col_'+ item7 +'').css("display", "initial");

                // Montrer le bouton de réactivation du média
                $(".restore_media_btn_" + item7).show();

                $(".media_next_row_btn_1").hide();
                // $(".media_next_row_btn_2").show();
                
            }
        
        });
        
    });

    /*$(".media_next_row_btn_2").click(function () {
               
        $.each(Array(24), function(item8) {

            if(item8 > 11 && item8 < 18) {

                $('.flex_col_'+ item8 +'').css("display", "initial");

                // Montrer le bouton de réactivation du média
                $(".restore_media_btn_" + item8).show();

                $(".media_next_row_btn_2").hide();
                $(".media_next_row_btn_3").show();
                
            }
        
        });
        
    });*/

    /*$(".media_next_row_btn_3").click(function () {
               
        $.each(Array(24), function(item9) {

            if(item9 > 17) {

                $('.flex_col_'+ item9 +'').css("display", "initial");

                // Montrer le bouton de réactivation du média
                $(".restore_media_btn_" + item9).show();

                $(".media_next_row_btn_3").hide();
                
            }
        
        });
        
    });*/
    


    /**** AFFICHAGE DES IMAGES ET DES VIDÉOS ****/
    $('.screen_class').each(function(item10){

        // On cache les "default_picture" (que l'on affichera en remplacement par la suite)
        $(".default_picture_"+ item10 +"").hide();

        if(!$('#figure_screens_'+ item10 +'_thumbnail').val()) {       

            $(".default_photo_"+ item10 +"").attr('src', '/backgrounds/default_picture_2.jpg');

        } else if ($('#figure_screens_'+ item10 +'_thumbnail').val().length === 11) {

                var videoValue = $('#figure_screens_'+ item10 +'_thumbnail').val();

                $(".default_photo_"+ item10 +"").attr('src', 'https://img.youtube.com/vi/'+ videoValue +'/hqdefault.jpg');

        } else {

            var imageValue = $('#figure_screens_'+ item10 +'_thumbnail').val();

            $(".default_photo_"+ item10 +"").attr('src', imageValue);

        }

    });
    
    if ($(".update-col-title:has(li)").length > 0) {
        $(".update_feature_box").append("<li style='opacity:0;'>Error</li>");
    }

    /**** PREVIEWS INTERACTIVES SUR LES MÉDIAS ****/
    $.each(Array(24), function(item11) {

        // A condition qu'il n'y ait pas de rapports d'erreurs des formulaires émis après la tentative de sauvegarde de l'article
        if (!$(".update_feature_box:has(li)").length > 0) {

            $('#figure_screens_'+ item11 +'_thumbnail').on('change', function() {

                $('#figure_screens_'+ item11 +'_thumbnail').blur(function()          
                {         
                            
                    if(!$(this).val()) {       

                        $(".default_picture_"+ item11 +"").html("<img src='/backgrounds/default_picture_2.jpg' width='100%' class='substitute-img' />");

                        $(".default_picture_"+ item11 +"").show();

                        $(".default_photo_"+ item11 +"").hide();

                    } else if ($(this).val().indexOf("https://www.youtube.com/watch?v=") > -1 || $(this).val().indexOf("https://youtu.be/") > -1 || $(this).val().indexOf("https://www.youtube.com/embed/") > -1) {

                        var videoValue2 = $('#figure_screens_'+ item11 +'_thumbnail').val();

                        $(".default_picture_"+ item11 +"").html("<img src='/backgrounds/youtube_capcha.jpg' width='100%' class='substitute-img' />");

                        $(".default_picture_"+ item11 +"").show();

                        $(".default_photo_"+ item11 +"").hide();

                    } else if ($(this).val().indexOf("https://") > -1 || $(this).val().indexOf("http://") > -1) {

                        var imageValue2 = $('#figure_screens_'+ item11 +'_thumbnail').val();

                        $(".default_picture_"+ item11 +"").html("<img src='"+imageValue2+"' width='100%' class='substitute-img' />");

                        $(".default_picture_"+ item11 +"").show();

                        $(".default_photo_"+ item11 +"").hide();

                    } else {

                        $(".default_picture_"+ item11 +"").html("<img src='/backgrounds/default_picture_2.jpg' width='100%' class='substitute-img' />");

                        $(".default_picture_"+ item11 +"").show();

                        $(".default_photo_"+ item11 +"").hide();

                    }

                });

            });

        }

    });

    /**** SUPPRESSIONS DE FORMULAIRES VIDES LORS DE LA MISE À JOUR DE L'ARTICLE ****/

    $("#save_post").click(function () {
               
            $.each(Array(24), function(item12) {

                if(!$('#figure_screens_'+ item12 +'_thumbnail').val()) {

                    $('#figure_screens_'+ item12 +'_thumbnail').remove();
                    
                }
             
            });

    });

    $(".photo-step-errors").hide();

    /**** EN CAS DE MESSAGES D'ERREUR ! ****/
    if ($(".update_feature_box:has(li)").length > 0) {

        $(".update_featured_input").prop("readonly", false);
        
        $(".update_feature_box").css("opacity", "1");

        $(".feature_pen_btn").hide();

        $(".feature_arrow_btn").show();

        $(".index-img").html("<img src='/backgrounds/default_picture.jpg' width='100%' />");

        $(".media_next_row_btn_1").hide();

        $(".fake_btn").hide();

        $('.screen_class').css("width", "100%").css("height", "120px").css("padding", "10px 13px");

        $('.medias-multi-buttons').hide();

        $(".photo-step-regular").hide();

        $(".photo-step-errors").show();

    } else if ($(".update-col-title:has(li)").length > 0) {
     
        $(".media_next_row_btn_1").hide();

        $(".fake_btn").hide();

        $('.screen_class').css("width", "100%").css("height", "120px").css("padding", "10px 13px");

        $('.medias-multi-buttons').hide();

        $(".photo-step-regular").hide();

        $(".photo-step-errors").show();

    } else {
        
        $(".fake_btn").click();
        
        $(".fake_btn").hide();


    }



// FIN DU DOM READY
});
