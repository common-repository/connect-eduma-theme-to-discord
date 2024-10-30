(function( $ ) {
	'use strict';


	$('.connect-eduma-theme-discord-btn-disconnect').on('click', function (e) {
            
/* 		e.preventDefault();
		var userId = $(this).data('user-id');
		$.ajax({
			type: "POST",
			dataType: "JSON",
			url: etsEdumaParams.admin_ajax,
			data: { 'action': 'ets_eduma_discord_disconnect_from_discord', 'user_id': userId, 'ets_eduma_discord_nonce': etsEdumaParams.ets_eduma_discord_nonce },
			beforeSend: function () {
				$(".ets-spinner").addClass("ets-is-active");
			},
			success: function (response) {
				console.log(response);
				if (response.status == 1) {
					window.location = window.location.href.split("?")[0];
				}
			},
			error: function (response ,  textStatus, errorThrown) {
				console.log( textStatus + " :  " + response.status + " : " + errorThrown );
			}
		}); */
	});    

})( jQuery );
