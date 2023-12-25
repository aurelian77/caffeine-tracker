$(function(){
    // ---------------------------------------------------
    $('#notific-trigger').on('click', function(){
        if ($('#notific').hasClass('none')) {
            $('#notific').removeClass('none');
        } else {
            $('#notific').addClass('none');
        }
    });

    $('#notific').on('click', function(e){
        e.stopPropagation();
    });

    $('body').on('click', function(e){
        if ($(e.target).attr('id') != 'notific-trigger') {
            $('#notific').addClass('none');
        }
    });
    // ---------------------------------------------------
    $('#user-trigger').on('click', function(){
        if ($('#user').hasClass('none')) {
            $('#user').removeClass('none');
        } else {
            $('#user').addClass('none');
        }
    });

    $('#user').on('click', function(e){
        e.stopPropagation();
    });

    $('body').on('click', function(e){
        if ($(e.target).attr('id') != 'user-trigger') {
            $('#user').addClass('none');
        }
    });
    // ---------------------------------------------------
});
