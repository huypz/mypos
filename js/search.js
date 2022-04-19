$(function() {
    $('#search').submit(function() {
        var input;
        if ($('#search-input').val().length > 0) {
            input = $('#search-input').val();
        } 
        if (input) {
            var data = new Object();
            data.input = input;
    
            var options = new Object();
            options.data = data;
            options.dataType = 'text';
            options.type = 'GET';
            options.success = function(response) {};
            options.url = '/search.php';
            $.ajax(options);
        }
        return false;
    });
});