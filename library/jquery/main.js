function addToCart(productId) {

	console.log("js - addToCart()");
	$.ajax({
			type: 'POST',
			async: true,
			url: "/?controller=cart&action=addtocart&id=" + productId,
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
		url: "/?controller=cart&action=removefromcart&id=" + productId + '/',
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

function conversionPrice(productId) {

	var newCnt = $('#prodCnt_' + productId).val();
	var prodPrice = $('#prodPrice_' + productId).attr('value');
	var prodRealPrice = newCnt * prodPrice;

	$('#prodRealPrice_' + productId).html(prodRealPrice);
}

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
			} else {
				alert(data['message']);
			}
		}
	})
}

function login() {

	//var email = $('#loginEmail').val();
	//var pwd = $('#loginPwd').val();

    //var postData = "email="+ email +"&pwd=" +pwd;

    var postData = getData('#loginBox');


    $.ajax({
        type: 'POST',
        async: true,
        url: "/?controller=user&action=login",
        data: postData,
        dataType: 'json',
        success: function(data) {
            if (data['success']) {

                $('#registerBox').hide();
                $('#loginBox').hide();

                $('#userLink').attr('href', '/?controller=user');
                $('#userLink').html(data['displayName']);
                $('#userBox').show();

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