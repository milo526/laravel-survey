$( document ).ready(function() {
    $('#categories-menu').click(function (event) {
        $list = $('#categories-menu-list');
        if($list.hasClass('sv-block')){
            $list.addClass('sv-hidden').removeClass('sv-block')
        } else {
            $list.addClass('sv-block').removeClass('sv-hidden')
        }
    })

    $('#collapse').click(function (event) {
        $list = $('#menu');
        if($list.hasClass('sv-block')){
            $list.addClass('sv-hidden').removeClass('sv-block')
        } else {
            $list.addClass('sv-block').removeClass('sv-hidden')
        }
    })
});