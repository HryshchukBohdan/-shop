function addToCart(productId) {
	console.log("js - addToCart()");
	$.ajax({
			type: 'POST',
			async: false,
			url: "/www/?controller=cart&action=addtocart&id=" + productId,
			dataType: "json",
			success: function(data) {
				if (data['success']) {
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
		url: "/www/?controller=cart&action=removefromcart&id=" + productId + '/',
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