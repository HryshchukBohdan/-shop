function addToCart(productId) {
	console.log("js - addToCart()");
	$.ajax((
			type: 'POST',
			async: false,
			url: "/cart/add_product/" + productId + '/',
			dataType: 'json',
			success: function(data) {
				if (data['success']) {
					$('#cart_product').html(data['n_product']);

					$('#addCart_'+ productId).hide();
					$('#removeCart_'+ productId).show();
				}
			}
		))
}