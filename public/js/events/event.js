$(document).ready(function () {

    $("#spinner").delay(1000).css("display", "none");
    $(".control-medias-container").css("display", "none");
    $(".control-medias").hide();
    $(".control-medias-2").hide();

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