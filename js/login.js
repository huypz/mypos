$(function() {
    $('.login-btn').click(function() {
        $('.login-dialog').show();
    });

    $('.login-dialog .close-btn').click(function() {
        $('.login-dialog').hide();
    });

    $('#logout a').click(function() {
        $.ajax({
            data: '',
            url: '/logout.php',
            method: 'GET',
            success: function(response) {
                location.reload();
            }
        });
    });

    $('#login').submit(function() {
        var user, password;

        if ($('#user').val().length > 0) {
            user = $('#user').val();
        }
        else {
            alert('Please enter a username/email.')
        }

        if ($('#password').val().length > 0) {
            password = $('#password').val();
        }
        else {
            alert('Please enter a password.');
        }

        if (user && password) {
            var data = new Object();
            data.user = user;
            data.password = password;

            var options = new Object();
            options.data = data;
            options.dataType = 'text';
            options.type = 'get';
            options.success = function(response) {
                if (response == 'INCORRECT') {
                    alert('Invalid credentials');
                }
                else {
                    location.reload();
                }
            };
            options.url = '/login.php';
            $.ajax(options);
        }
        return false;
    });
});