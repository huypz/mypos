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
    data.in_cart = in_cart;

    var options = new Object();
    options.data = data;
    options.dataType = 'text';
    options.type = 'POST';
    options.success = function(response) {
        updateCartTotal();
        if (response == 'OUT OF STOCK') {
            var t = document.getElementById(`item-${item_id}-amt`);
            t.classList.add("error");
            alert('Item out of stock');
            location.reload();
            return false;
        }
        else if (response == 'CORRECT') {
            var t = document.getElementById(`item-${item_id}-amt`);
            t.classList.remove("error");
        } 
        else if (response == 'INCORRECT') {
            alert('Invalid user id');
            return false;
        } 
        else if (response == 'INCOMPLETE') {
            alert('Invalid item id or quantity');
            return false;
        } 
        if (reload) {
            location.reload();
        }
    };
    options.url = '/add_item.php';
    $.ajax(options);

    return false;
}

function editClick(oItem) {
    document.getElementById('editButton').style.display = "none";
    document.getElementById("saveButton").style.display = "inline";
    document.getElementById("cancelButton").style.display = "inline";
    document.getElementById("name").contentEditable = true;
    document.getElementById("category").contentEditable = true;
    document.getElementById("description").contentEditable = true;
    document.getElementById("stock").contentEditable = true;
    document.getElementById("price").contentEditable = true;
}

function cancelClick(oItem) {
    document.getElementById("editButton").style.display = "inline";
    document.getElementById("saveButton").style.display = "none";
    document.getElementById("cancelButton").style.display = "none";
    document.getElementById("name").contentEditable = false;
    document.getElementById("category").contentEditable = false;
    document.getElementById("description").contentEditable = false;
    document.getElementById("stock").contentEditable = false;
    document.getElementById("price").contentEditable = false;

    document.getElementById("name").textContent = oItem.name;
    document.getElementById("category").textContent = oItem.category;
    document.getElementById("description").textContent = oItem.description;
    document.getElementById("stock").textContent = oItem.stock;
    document.getElementById("price").textContent = oItem.price;
}

function saveClick(oItem) {
    var newPrice = parseFloat(document.getElementById("price").textContent.slice(1));
    if (isNaN(newPrice)) {
        alert("Price must be a valid number");
        return false;
    }

    document.getElementById("editButton").style.display = "inline";
    document.getElementById("saveButton").style.display = "none";
    document.getElementById("cancelButton").style.display = "none";
    document.getElementById("name").contentEditable = false;
    document.getElementById("category").contentEditable = false;
    document.getElementById("description").contentEditable = false;
    document.getElementById("stock").contentEditable = false;

    document.getElementById("price").textContent = `${newPrice.toFixed(2)}`
    document.getElementById("price").contentEditable = false;

    oItem = {
        name: document.getElementById("name").textContent,
        category: document.getElementById("category").textContent,
        description: document.getElementById("description").textContent,
        stock: document.getElementById("stock").textContent,
        price: document.getElementById("price").textContent,
        item_id: document.getElementById("prodId").textContent
    }

    var data = oItem;
    var options = new Object();
    options.data = data;
    options.dataType = 'text';
    options.type = 'POST';
    options.success = function (response) {
        alert(response);
        location.reload();
        /*if (response == 'OUT OF STOCK') {
            alert('Item out of stock');
        }
        else if (response == 'CORRECT') {
            alert('Item added')
        }
        else if (response == 'INCORRECT') {
            alert('Invalid user id');
        }
        else if (response == 'INCOMPLETE') {
            alert('Invalid item id or quantity')
        }*/
    };
    options.url = '/edit_item.php';
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
    ++amt_val;
    addItem(item_id, 1, amt_val, reload)
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