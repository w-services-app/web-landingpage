$(document).ready(function () {

    var navbarli = $('#nav li');
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    if (scrollTop == 0) {
        $("#nav li").first().addClass("current");
    }

    $('.container').waypoint(function () {
        var hash = $(this).attr('id');
        navbarli.removeClass('current');
        $.each(navbarli, function () {
            if ($(this).children('a').attr('href').slice(1) == hash) {
                $(this).addClass('current');
            }
        });
        $(".nav li a").click(function () {
            var hash = $(this).attr('id');

            $.each(navbarli, function () {
                if ($(this).children('a').attr('href').slice(1) == hash) {
                    $(this).addClass('current');
                    $.waypoints('refresh');
                }
            });

        });
        offset: '50%';
    });

//плавность прокрутки добовляем с верхнего меню
    $("#navbar li a").click(function () {
        var selected = $(this).attr('href');
        $.scrollTo(selected, 800);
        return false;
    });
    $("#want a").click(function () {
        var selected = $(this).attr('href');
        $.scrollTo(selected, 800);
        return false;
    });



//плавность прокрутки добовляем с футера в самый вверх
    $(window).scroll(function () {
        if ($(this).scrollTop() > 0) {
            $('.back_top').fadeIn();
        } else {
            $('.back_top').fadeOut();
        }
    });
    $('.back_top a').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });
    $.getScript("js/ajax.js", function () {
    });
});