$(document).ready(function () {
    $('#menu__toggle').click(function(){
        if ($(this).prop('checked')) {
            $("body").addClass('scroll');
            $('.checksubmenuhide').each(function(index) {
                $(this).prop('checked', false);
            });
            $(".gradient__uni .text__page").hide();
        } else {
            $("body").removeClass('scroll');
            $(".gradient__uni .text__page").show();
        }
    });

    $('.checksubmenuhide').change(function(){
        var current = $(this).prop('checked');
        $('.checksubmenuhide').each(function(index) {
            $(this).prop('checked', false);
        });
        if (current) {
            $(this).prop('checked', true);
        } else {
            $(this).prop('checked', false);
        }
    });
});
