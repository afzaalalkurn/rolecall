$('.bxslider').bxSlider({
    minSlides: 2,
    maxSlides: 100,
    slideWidth: 1000,
    slideMargin: 30,
    moveSlides: 1,
    pager: false,
    autoHover: true,
    auto: false
});

$('.bxslidertalent').bxSlider({
    minSlides: 1,
    maxSlides: 100,
    slideWidth: 1170,
    slideMargin: 15,
    moveSlides: 1,
    pager: false,
    autoHover: true,
    auto: false
});

$('.bxslidertwo').bxSlider({
    minSlides: 4,
    maxSlides: 100,
    slideWidth: 1000,
    slideMargin: 20,
    moveSlides: 1,
    pager: false,
    autoHover: true,
    auto: false
});

$('.bxsliderdirector').bxSlider({
    minSlides: 1,
    maxSlides: 100,
    slideWidth: 1170,
    slideMargin: 15,
    moveSlides: 1,
    pager: false,
    autoHover: true,
    auto: false
});

$(function () {

    $('#Delete-Account').on('click', function (e) {

        e.preventDefault();
        if (confirm('Are you sure you want to delete this account?')) {

            $.ajax({
                type: "POST",
                url: $(this).attr('href'),
                dataType: 'JSON',
                data: {},
                success: function (json) {
                    var code = json.code = 'success' ? 'success' : 'denger';
                    $('#msg').html("<div id='' class='alert alert-"+code+"'>"+json.msg+"</div>").fadeIn('slow');
                    $('#msg').delay(3000).hide('slow');
                },
                error: function (exception) {
                    alert(exception);
                }
            });
            return true;
        }
        return false;
    });


    $('#Downgrade-Account').on('click', function (e) {

        e.preventDefault();
        if (confirm('Are you sure you want to downgrade this account?')) {

            $.ajax({
                type: "POST",
                url: $(this).attr('href'),
                dataType: 'JSON',
                data: {},
                success: function (json) {
                    var code = json.code = 'success' ? 'success' : 'denger';
                    $('#msg').html("<div id='' class='alert alert-"+code+"'>"+json.msg+"</div>").fadeIn('slow');
                    $('#msg').delay(3000).hide('slow');
                },
                error: function (exception) {
                    alert(exception);
                }
            });
            return true;
        }
        return false;
    });

});
