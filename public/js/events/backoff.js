$(document).ready(function () {

    var totalTricks = $("#trick-box > .load-more").length;

    var x = 6;

    $('#trick-box .load-more:lt('+x+')').show();

        $('#more-btn').click(function () {

        x = (x + 3 <= totalTricks) ? x + 3 : totalTricks;

        $('#trick-box .load-more:lt('+x+')').slideDown();

    });

});