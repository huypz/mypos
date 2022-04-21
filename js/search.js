$(function() {
    $('#search').keyup(function() {
        var input;
        if ($('#search-input').val().length > 0) {
            input = $('#search-input').val();
        }
        else {
            var list = document.getElementById('autocomplete-list');
            list.innerHTML = "";
        }
        if (input) {
            input = String(input).toLowerCase();
            var data = new Object();
            data.input = input;
    
            var options = new Object();
            options.data = data;
            options.dataType = 'text';
            options.type = 'GET';
            options.success = function(response) {
                var list = document.getElementById('autocomplete-list');
                list.innerHTML = response;
                
            };
            options.url = '/search.php';
            $.ajax(options);
        }
        return false;
    });
});