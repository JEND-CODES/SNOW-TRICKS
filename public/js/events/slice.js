$(document).ready(function () {

    var totalTricks = $("#trick-box > .load-more").length;

    var x = 6;

    $(".hidden-up-btn").hide();

    $("#trick-box .load-more:lt("+x+")").show();

        $("#more-btn").click(function () {

        x = (x + 3 <= totalTricks) ? x + 3 : totalTricks;

        $("#trick-box .load-more:lt("+x+")").slideDown();

        if (x > 9) {
            $(".hidden-up-btn").show();
        }

    });

    $("#go-to-tricks").click(function() { 

        $("html, body").animate({

            scrollTop: $("#trick-section").offset().top 

        }, 500); 

    });

    $("#up-to-tricks").click(function() { 

        $("html, body").animate({

            scrollTop: $("#trick-section").offset().top 

        }, 800); 

    });
    
});