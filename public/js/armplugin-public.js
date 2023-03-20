jQuery(document).ready(function($) {

	let js_btn= $('#js_submit_btn');

	js_btn.click(function (e){
		let js_name = $('#js_name').val();
		let js_password = $('#js_password').val();
		let js_email = $('#js_email').val();

		e.preventDefault();

		$.ajax({
			url: from_back.ajaxurl,
			type: 'get',
			data: {
				'action': 'front_action',
				'name': js_name,
				'password': js_password,
				'email': js_email
			},
			success: function (response) {
				console.log(response);
			},
			error: function (response){
				console.log(response)
			}
		});
	})
});