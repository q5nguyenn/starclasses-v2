$(document).ready(function () {
	//Show hide password
	$('.show-password').click(function (e) {
		e.preventDefault();
		$(this).find(">:first-child").toggleClass("bi-eye");
		$(this).find(">:first-child").toggleClass("bi-eye-slash");
		if ($(this).find(">:first-child").hasClass("bi-eye")) {
			$('#password').attr('type', 'text');
		} else {
			$('#password').attr('type', 'password');
		}
	});
});
