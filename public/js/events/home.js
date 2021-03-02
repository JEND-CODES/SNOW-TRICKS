$(document).ready(function () {

    var totalTricks = $("#trick-box > .load-more").length;
    // alert(totalTricks);

    var x = 6;

    $(".hidden-up-btn").hide();

    $("#trick-box .load-more:lt("+x+")").show();

        $("#more-btn").click(function () {

        x = (x + 3 <= totalTricks) ? x + 3 : totalTricks;

        $("#trick-box .load-more:lt("+x+")").slideDown();

        // alert(x);

        // A ne montrer que si il y a plus de 15 tricks affichés
        if (x > 9) {
            $(".hidden-up-btn").show();
        }

    });

    /*
    $("#less-btn").click(function () {

        x = (x - 6 < 6) ? 6 : x - 6;

        // $("#trick-box .load-more").not(":lt("+x+")").hide();
        $("#trick-box .load-more").not(":lt("+x+")").slideUp();

    });
    */

    // JQUERY SCROLL TO TRICKS SECTION
    $("#go-to-tricks").click(function() { 

        $("html, body").animate({

            scrollTop: $("#trick-section").offset().top 

        }, 500); 

    });

    // Ce bouton pour remonter en haut ne s"affiche qu"à condition où plus de 15 tricks sont affichés
    $("#up-to-tricks").click(function() { 

        $("html, body").animate({

            scrollTop: $("#trick-section").offset().top 

        }, 800); 

    });

    // https://jsfiddle.net/cse_tushar/6FzSb/
    
});
