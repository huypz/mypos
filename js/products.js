function addItem(item_id, quantity=1, in_cart=1, reload=false) {
    $(`#item-${item_id}`).css({
        "padding": "6px 21px",
        "cursor": "auto"
    });
    var add_btn = document.getElementById(`item-${item_id}`);
    add_btn.className = "add-item-container2";
    add_btn.innerHTML = `<div class="m-btn" onclick="mButton(${item_id}, ${reload})">
        <i class="gg-math-minus"></i></div> 
        <span id="item-${item_id}-amt" style="width: 25px">${in_cart}</span><div> 
        <div class="p-btn" onclick="pButton(${item_id}, ${reload})"><i class="gg-math-plus"></i></div>`;
    add_btn.setAttribute("onclick", "");
    
    if (quantity == 0) {
        return false;
    }

    var data = new Object();
    data.item_id = item_id;
    data.quantity = quantity;

    var options = new Object();
    options.data = data;
    options.dataType = 'text';
    options.type = 'POST';
    options.success = function(response) {
        if (reload) {
            location.reload();
        }
        updateCartTotal();
        if (response == 'OUT OF STOCK') {
            alert('Item out of stock');
        }
        else if (response == 'CORRECT') {
            
        } 
        else if (response == 'INCORRECT') {
            alert('Invalid user id');
        } 
        else if (response == 'INCOMPLETE') {
            alert('Invalid item id or quantity');
        } 
    };
    options.url = '/add_item.php';
    $.ajax(options);

    return true;
}

function mButton(item_id, reload=false) {
    var amt = document.getElementById(`item-${item_id}-amt`);
    var amt_val = parseInt(amt.textContent);
    if (amt_val <= 0) {
        amt.textContent = amt_val = 0;
        return false;
    }
    amt.textContent = --amt_val;
    addItem(item_id, -1, amt_val, reload);
    return true;
}

function pButton(item_id, reload=false) {
    var amt = document.getElementById(`item-${item_id}-amt`);
    var amt_val = parseInt(amt.textContent);
    amt.textContent = ++amt_val;
    addItem(item_id, 1, amt_val, reload);
    return true;
}

function updateCartTotal() {
    var options = new Object();
    options.data = {};
    options.dataType = 'text';
    options.type = 'GET';
    options.success = function(response) {
        var elem = document.getElementById("cart-total");
        elem.textContent = response;
    };
    options.url = '/cart_total.php';
    $.ajax(options);

    return true;
}