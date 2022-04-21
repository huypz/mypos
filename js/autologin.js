$(function() {
    var options = new Object();
    options.data = [];
    options.dataType = 'text';
    options.type = 'get';
    options.success = function(response) {
        if (response == 'NOT FOUND') {
            $('.logout').hide();
            $('.login span').text('Log In');
            $('.login').show();
        }
        else {
            $('.login').hide();
            $('.logout span').text(response);
            $('.logout').show();
        }
    };
    options.url = '/autologin.php';
    $.ajax(options);

    updateCartTotal();

    return false;
});