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

function addToCart(productId) {

	console.log("js - addToCart()");
	$.ajax({
			type: 'POST',
			async: true,
			url: "/cart/addtocart/" + productId,
			dataType: "json",
			success: function(data) {
				if (data['success']) {
					debugger;
					$('#cart_product').html(data['n_product']);

					$('#addCart_'+ productId).hide();
					$('#removeCart_'+ productId).show();
				}
			}
		})
}

function removeFromCart(productId) {

	console.log("js - removeFromCart("+productId+")");
	$.ajax({
		type: 'POST',
		async: false,
		url: "/cart/removefromcart/" + productId,
		dataType: 'json',
		success: function(data) {
			if (data['success']) {
				$('#cart_product').html(data['n_product']);

				$('#addCart_'+ productId).show();
				$('#removeCart_'+ productId).hide();
			}
		}
	})
}

function login() {

    var postData = getData('#loginBox');

    $.ajax({
        type: 'POST',
        async: true,
        url: "/user/login",
        data: postData,
        dataType: 'json',
        success: function(data) {
            if (data['success']) {

                $('#registerBox').hide();
                $('#loginBox').hide();

                $('#userLink').attr('href', '/?controller=user');
                $('#userLink').html(data['displayName']);
                $('#userBox').show();

                $('#phone').val(data['phone']);
                $('#adress').val(data['adress']);
                $('#name').val(data['name']);

                $('#btnSaveOrder').show();

            } else {
                alert(data['message']);
            }
        }
    })
}









function conversionPrice(productId) {

	var newCnt = $('#prodCnt_' + productId).val();
	var prodPrice = $('#prodPrice_' + productId).attr('value');
	var prodRealPrice = newCnt * prodPrice;

	$('#prodRealPrice_' + productId).html(prodRealPrice);
}



function registerNewUser() {
	
	var postData = getData('#registerBox');

	$.ajax({
		type: 'POST',
		async: true,
		url: "/?controller=user&action=register",
		data: postData,
		dataType: 'json',
		success: function(data) {
			if (data['success']) {
				alert('Регистрация прошла успешно');

				// Блок левого столпца
				$('#registerBox').hide();

				$('#userLink').attr('href', '/?controller=user');
				$('#userLink').html(data['userName']);
				$('#userBox').show();

				// Страница заказа
                $('#loginBox').hide();
                $('#btnSaveOrder').show();

			} else {
				alert(data['message']);
			}
		}
	})
}



function showRegisterBox() {

    if ($('#registerBoxHidden').css('display') != 'block' ) {
        $('#registerBoxHidden').show();
    } else {
        $('#registerBoxHidden').hide();
    }
}

function updateUserData() {

    console.log("js - updateUserData()");

    var phone = $('#newPhone').val();
    var adress = $('#newAdress').val();
    var pwd1 = $('#newPwd1').val();
    var pwd2 = $('#newPwd2').val();
    var curPwd = $('#curPwd').val();
    var name = $('#newName').val();

    var postData = {phone: phone,
                adress: adress,
                pwd1: pwd1,
                pwd2: pwd2,
                curPwd: curPwd,
                name: name};
    $.ajax({
        type: 'POST',
        async: true,
        url: "/?controller=user&action=update",
        data: postData,
        dataType: 'json',
        success: function(data) {
            if (data['success']) {

                $('#userLink').html(data['userName']);
                alert(data['message']);

            } else {

                alert(data['message']);
            }
        }
    })
}

function saveOrder() {

    var postData = getData('#frmOrder');

    $.ajax({
        type: 'POST',
        async: false,
        url: "/?controller=cart&action=saveorder",
        data: postData,
        dataType: 'json',
        success: function(data) {
            if (data['success']) {

                alert(data['message']);
                document.location = '/';

            } else {

                alert(data['message']);
            }
        }
    })
}

function showProduct(id) {

    var odjName = "#purchasesForOrderId_" + id;

    if ($(odjName).css('display') != 'table-row' ) {
        $(odjName).show();
    } else {
        $(odjName).hide();
    }
}