function getData(obj_form) {

    var hData = {};
    $('input, textarea, select', obj_form).each(function() {
        if (this.name && this.name!='') {
            hData[this.name] = this.value;
            console.log('hData[' + this.name + '] = ' + hData[this.name]);
        }
    });

    return hData;
}

function newCategory() {

    var postData = getData('#blockNewCategory');

    $.ajax({
        type: 'POST',
        async: true,
        url: "/?controller=admin&action=addnewcat",
        data: postData,
        dataType: 'json',
        success: function(data) {
            if (data['success']) {

                alert(data['message']);
                $('#newCategoryName').val('');

            } else {
                alert(data['message']);
            }
        }
    })
}

function updateCat(catId) {

    console.log("js - updateCa("+catId+")");

    var parentId = $('#parentId_' + catId).val();
    var newName = $('#catName_' + catId).val();

    var postData = {catId: catId,
                parentId: parentId,
                newName: newName};
    $.ajax({
        type: 'POST',
        async: true,
        url: "/?controller=admin&action=updatecategory",
        data: postData,
        dataType: 'json',
        success: function(data) {

            alert(data['message']);
        }
    })
}

function addProduct() {

    var productName = $('#newProductName').val();
    var productPrice = $('#newProductPrice').val();
    var productDesc = $('#newProductDesc').val();
    var productCat = $('#newProductCat').val();

    var postData = {productName: productName,
                    productPrice: productPrice,
                    productDesc: productDesc,
                    productCat: productCat};
    $.ajax({
        type: 'POST',
        async: true,
        url: "/?controller=admin&action=addproduct",
        data: postData,
        dataType: 'json',
        success: function(data) {

            alert(data['message']);

            if (data['success']) {

                $('#newProductName').val('');
                $('#newProductPrice').val('');
                $('#newProductDesc').val('');
                $('#newProductCat').val('');

            }
        }
    })
}

function updateProduct(id) {

    var productName = $('#prodName_' + id).val();
    var productPrice = $('#prodPrice_' + id).val();
    var productDesc = $('#productDesc_' + id).val();
    var productCat = $('#productCatId').val();
    var productStatus = $('#prodStatus_' + id).attr('checked');

    if (! productStatus) {

        productStatus = 1

    } else {

        productStatus = 0
    }

    var postData = {id: id,
                    name: productName,
                    price: productPrice,
                    desc: productDesc,
                    cat: productCat,
                    status: productStatus};
    $.ajax({
        type: 'POST',
        async: true,
        url: "/?controller=admin&action=updateproduct",
        data: postData,
        dataType: 'json',
        success: function(data) {

            alert(data['message']);
        }
    })
}

function showProducts(id) {

    var odjName = "#purchasesForOrderId_" + id;

    if ($(odjName).css('display') != 'table-row' ) {
        $(odjName).show();
    } else {
        $(odjName).hide();
    }
}

function updateOrderStatus(id) {

    var status = $('#ordStatus_' + id).attr('checked');

    if (! status) {

        status = 0

    } else {

        status = 1
    }

    var postData = {id: id,
                    status: status};
    $.ajax({
        type: 'POST',
        async: true,
        url: "/?controller=admin&action=setorderstatus",
        data: postData,
        dataType: 'json',
        success: function(data) {

            if (! data['success']) {

                alert(data['message']);
            }
        }
    })
}

function updateDataPayment(id) {

    var data_pay = $('#dataPayment_' + id).val();

    var postData = {id: id,
                    date_payment: data_pay};
    $.ajax({
        type: 'POST',
        async: true,
        url: "/?controller=admin&action=setorderdatapayment",
        data: postData,
        dataType: 'json',
        success: function(data) {

            if (! data['success']) {

                alert(data['message']);
            }
        }
    })
}

function addIst() {

    var name = $('#newIntName').val();
    var name2 = $('#newIntSName').val();
    var name3 = $('#newIntTName').val();
    var desc = $('#newIntDesc').val();

    var postData = {name: name,
        name2: name2,
        name3: name3,
        desc: desc};
    $.ajax({
        type: 'POST',
        async: true,
        url: "/?controller=admin&action=addinstructor",
        data: postData,
        dataType: 'json',
        success: function(data) {

            alert(data['message']);

            if (data['success']) {

                $('#newIntName').val('');
                $('#newIntSName').val('');
                $('#newIntTName').val('');
                $('#newIntDesc').val('');

            }
        }
    })
}

function updateIns(id) {

    var name = $('#IntName_' + id).val();
    var name2 = $('#IntSName_' + id).val();
    var name3 = $('#IntTName_' + id).val();
    var desc = $('#intDesc_' + id).val();
    var status = $('#intStatus_' + id).attr('checked');

    if (! status) {

       status = 0

    } else {

        status = 1
    }

    var postData = {id: id,
        name: name,
        name2: name2,
        name3: name3,
        desc: desc,
        status: status};
    $.ajax({
        type: 'POST',
        async: true,
        url: "/?controller=admin&action=updateinstructor",
        data: postData,
        dataType: 'json',
        success: function(data) {

            alert(data['message']);
        }
    })
}

