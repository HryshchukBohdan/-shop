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