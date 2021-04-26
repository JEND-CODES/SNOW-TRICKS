$(document).ready(function () {

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

    if ($(".create_feature_box:has(li)").length > 0) {
        $(".create_featured_input").prop("readonly", false);
        $(".create_feature_box").css("opacity", "1");
        $(".feature_pen_btn").hide();
        $(".feature_arrow_btn").show();
        $(".screen_class").css("width", "100%").css("height", "120px").css("padding", "10px 13px");
        $(".medias-multi-buttons").hide();
        $(".media_next_row_btn_1").hide();
        $(".photo-step-regular").hide();
        $(".photo-step-errors").show();
    }

    if ($(".create-col-title:has(li)").length > 0) {
        $(".screen_class").css("width", "100%").css("height", "120px").css("padding", "10px 13px");
        $(".medias-multi-buttons").hide();
        $(".media_next_row_btn_1").hide();
        $(".photo-step-regular").hide();
        $(".photo-step-errors").show();
    }

    $(".create_featured_input").on("change", function() {
        $(".create_featured_input").blur(function() {    
            if(!$(this).val()) {        
                $(".default_img").html("<img src='/backgrounds/default_picture.jpg' width='100%' />");
            } else if ($(this).val().indexOf("https://") > -1 || $(this).val().indexOf("http://") > -1) {
                var featureImage = $(".create_featured_input").val();
                $(".default_img").html("<img src='"+ featureImage +"' width='100%'>");
            } else {
                $(".default_img").html("<img src='/backgrounds/default_picture.jpg' width='100%' />");
            }
        });
    });

    $.each(Array(24), function(item) {
        var trashMedia = $(".trash_media_btn_" + item);

        $(trashMedia).click(function () {  
            $(".create_media_" + item).hide();
            $("#figure_screens_"+ item +"_thumbnail").val("");
            $(".trash_media_btn_" + item).hide();
            $(".restore_media_btn_" + item).show();
            $(".hide_input_btn_" + item).hide();
            $(".change_input_btn_" + item).hide();
        });
    });

    $.each(Array(24), function(item2) {
        var restoreMedia = $(".restore_media_btn_" + item2);

        $(restoreMedia).click(function () {
            $(".create_media_" + item2).show();
            $(".restore_media_btn_" + item2).hide();
            $(".trash_media_btn_" + item2).show();
            $(".hide_input_btn_" + item2).show();
            $(".change_input_btn_" + item2).hide();
            $("#figure_screens_"+ item2 +"_thumbnail").css("width", "100%").css("height", "120px").css("padding", "10px 13px");
        });
    });

    $.each(Array(24), function(item3) {
        var changeInput = $(".change_input_btn_" + item3);

        $(changeInput).click(function () {
            if ($("#figure_screens_"+ item3 +"_thumbnail").width() !== "100%" ) {
                $("#figure_screens_"+ item3 +"_thumbnail").css("width", "100%").css("height", "120px").css("padding", "10px 13px");
                $(".change_input_btn_" + item3).hide();
                $(".hide_input_btn_" + item3).show();
            } 
        });
    });

    $.each(Array(24), function(item4) {
        var hideInput = $(".hide_input_btn_" + item4);

        $(hideInput).click(function () {
            $("#figure_screens_"+ item4 +"_thumbnail").css("width", "0px").css("height", "0px").css("padding", "0px");
            $(".hide_input_btn_" + item4).hide();
            $(".change_input_btn_" + item4).show();
        });
    });

    $("#save_post").click(function () {        
        $.each(Array(24), function(item5) {
            if(!$("#figure_screens_"+ item5 +"_thumbnail").val()) {
                $("#figure_screens_"+ item5 +"_thumbnail").remove();   
            }
        });
    });

    $(".media_next_row_btn_2").hide();
    $(".media_next_row_btn_3").hide();

    $.each(Array(24), function(item6) {
        if(item6 > 5) {
            $(".flex_col_"+ item6 +"").css("display", "none");
            $(".create_media_" + item6).hide();
            $(".trash_media_btn_" + item6).hide();
            $(".restore_media_btn_" + item6).hide();
            $(".hide_input_btn_" + item6).hide();
            $(".change_input_btn_" + item6).hide();
        }
    });

    $(".media_next_row_btn_1").click(function () {
        $.each(Array(24), function(item7) {
            if(item7 > 5 && item7 < 12) {
                $(".flex_col_"+ item7 +"").css("display", "initial");
                $(".restore_media_btn_" + item7).show();
                $(".media_next_row_btn_1").hide();
                $(".media_next_row_btn_2").show();
            }
        });
    });

    $(".media_next_row_btn_2").click(function () {
        $.each(Array(24), function(item8) {
            if(item8 > 11 && item8 < 18) {
                $(".flex_col_"+ item8 +"").css("display", "initial");
                $(".restore_media_btn_" + item8).show();
                $(".media_next_row_btn_2").hide();
                $(".media_next_row_btn_3").show();
            }
        });
    });

    $(".media_next_row_btn_3").click(function () {
        $.each(Array(24), function(item9) {
            if(item9 > 17) {
                $(".flex_col_"+ item9 +"").css("display", "initial");
                $(".restore_media_btn_" + item9).show();
                $(".media_next_row_btn_3").hide();
            }
        });
    });

    $.each(Array(24), function(item10) {
        $("#figure_screens_"+ item10 +"_thumbnail").on("change", function() {

            var firstCase = !$(this).val();
            var secondCase = $(this).val().indexOf("https://www.youtube.com/watch?v=") > -1 || $(this).val().indexOf("https://youtu.be/") > -1 || $(this).val().indexOf("https://www.youtube.com/embed/") > -1;
            var thirdCase = $(this).val().indexOf("https://") > -1 || $(this).val().indexOf("http://") > -1;

            switch(true) {
                case firstCase: 
                    $(".default_picture_"+ item10 +"").html("<img src='/backgrounds/default_picture_2.jpg' width='100%' />");
                    break;
                case secondCase:
                    $(".default_picture_"+ item10 +"").html("<img src='/backgrounds/youtube_capcha.jpg' width='100%' />");
                    break;
                case thirdCase:
                    var imageValue = $("#figure_screens_"+ item10 +"_thumbnail").val();
                    $(".default_picture_"+ item10 +"").html("<img src='"+ imageValue +"' width='100%'>");
                    break;
                default:
                    $(".default_picture_"+ item10 +"").html("<img src='/backgrounds/default_picture_2.jpg' width='100%' />");
            }   
       
        });
    });

});