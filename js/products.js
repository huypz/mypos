function addItem(item_id, quantity=1) {
    var data = new Object();
    data.item_id = item_id;
    data.quantity = quantity;

    var options = new Object();
    options.data = data;
    options.dataType = 'text';
    options.type = 'POST';
    options.success = function(response) {
        if (response == 'CORRECT') {
            alert('Item added')
        } 
        else if (response == 'INCORRECT') {
            alert('Invalid user id');
        } 
        else if (response == 'INCOMPLETE') {
            alert('Invalid item id or quantity')
        } 
    };
    options.url = '/add_item.php';
    $.ajax(options);
    return true;
}