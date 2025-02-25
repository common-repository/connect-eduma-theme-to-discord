(function ($) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	if (etsEdumaParams.is_admin) {
		$(document).ready(function () {
			if (jQuery().select2) {
				$('#ets_eduma_discord_redirect_url').select2({ width: 'resolve' });
				$('#ets_eduma_discord_redirect_url').on('change', function () {
					$.ajax({
						url: etsEdumaParams.admin_ajax,
						type: "POST",
						context: this,
						data: { 'action': 'ets_eduma_discord_update_redirect_url', 'ets_eduma_page_id': $(this).val(), 'ets_eduma_discord_nonce': etsEdumaParams.ets_eduma_discord_nonce },
						beforeSend: function () {
							$('p.redirect-url').find('b').html("");
							$('p.ets-discord-update-message').css('display', 'none');
							$(this).siblings('p.description').find('span.spinner').addClass("ets-is-active").show();
						},
						success: function (data) {
							$('p.redirect-url').find('b').html(data.formated_discord_redirect_url);
							$('p.ets-discord-update-message').css('display', 'block');
							                                            
						},
						error: function (response, textStatus, errorThrown) {
							console.log(textStatus + " :  " + response.status + " : " + errorThrown);
						},
						complete: function () {
							$(this).siblings('p.description').find('span.spinner').removeClass("ets-is-active").hide();
						}
					});

				});
				if ($('#ets_eduma_pmpro_discord_redirect_url').length) {
					$('#ets_eduma_pmpro_discord_redirect_url').select2({ width: 'resolve' });
					$('#ets_eduma_pmpro_discord_redirect_url').on('change', function () {
						$.ajax({
							url: etsEdumaParams.admin_ajax,
							type: "POST",
							context: this,
							data: { 'action': 'ets_eduma_pmpro_discord_update_redirect_url', 'ets_eduma_pmpro_page_id': $(this).val(), 'ets_eduma_discord_nonce': etsEdumaParams.ets_eduma_discord_nonce },
							beforeSend: function () {
								$('p.redirect-url-eduma-pmpro').find('b').html("");
								$('p.ets-discord-update-message').css('display', 'none');
								$(this).siblings('p.description').find('span.spinner').addClass("ets-is-active").show();
							},
							success: function (data) {
								$('p.redirect-url-eduma-pmpro').find('b').html(data.formated_discord_redirect_url);
								$('p.ets-discord-update-message').css('display', 'block');
								                                           
							},
							error: function (response, textStatus, errorThrown) {
								console.log(textStatus + " :  " + response.status + " : " + errorThrown);
							},
							complete: function () {
								$(this).siblings('p.description').find('span.spinner').removeClass("ets-is-active").hide();
							}
						});

					});

				}
			}
			/*Load all roles from discord server*/
			$.ajax({
				type: "POST",
				dataType: "JSON",
				url: etsEdumaParams.admin_ajax,
				data: { 'action': 'ets_eduma_discord_load_discord_roles', 'ets_eduma_discord_nonce': etsEdumaParams.ets_eduma_discord_nonce },
				beforeSend: function () {
					$(".eduma-discord-roles .spinner").addClass("is-active");
					$(".eduma-pmpro-levels-discord-roles .spinner").addClass("is-active");
					$(".initialtab.spinner").addClass("is-active");
				},
				success: function (response) {
					if (response != null && response.hasOwnProperty('code') && response.code == 50001 && response.message == 'Missing Access') {
						$(".eduma-btn-connect-to-bot").show();
					} else if ( response.code === 10004 && response.message == 'Unknown Guild' ) {
						$(".eduma-btn-connect-to-bot").show().after('<p><b>The server ID is wrong or you did not connect the Bot.</b></p>');
					}else if( response.code === 0 && response.message == '401: Unauthorized' ) {
						$(".eduma-btn-connect-to-bot").show().html("Error: Unauthorized - The Bot Token is wrong").addClass('error-bk');							
					} else if (response == null || response.message == '401: Unauthorized' || response.hasOwnProperty('code') || response == 0) {
						$("#eduma-connect-discord-bot").show().html("Error: Please check all details are correct").addClass('error-bk');
					} else {
						if ($('.ets-tabs button[data-identity="level-mapping"]').length) {
							$('.ets-tabs button[data-identity="level-mapping"]').show();
						}
						if (response.bot_connected === 'yes') {
							$("#eduma-connect-discord-bot").show().html("Bot Connected <i class='fab fa-discord'></i>").addClass('not-active');
						} else {
							$("#eduma-connect-discord-bot").show().html("Error: Please check the Client ID is correct").addClass('error-bk');
						}

						var activeTab = localStorage.getItem('activeTab');
						if ($('.ets-tabs button[data-identity="level-mapping"]').length == 0 && activeTab == 'level-mapping') {
							$('.ets-tabs button[data-identity="settings"]').trigger('click');
						}
						$.each(response, function (key, val) {
							var isbot = false;
							if (val.hasOwnProperty('tags')) {
								if (val.tags.hasOwnProperty('bot_id')) {
									isbot = true;
								}
							}

							if (key != 'bot_connected' && key != 'previous_mapping' && key != 'previous_pmpro_mapping' && isbot == false && val.name != '@everyone') {
								$('.eduma-discord-roles').append('<div class="makeMeDraggable" style="background-color:#' + val.color.toString(16) + '" data-eduma_role_id="' + val.id + '" >' + val.name + '</div>');
								$('.eduma-pmpro-levels-discord-roles').append('<div class="makeMePmproDraggable" style="background-color:#' + val.color.toString(16) + '" data-eduma_pmpro_role_id="' + val.id + '" >' + val.name + '</div>');
								$('#eduma-defaultRole').append('<option value="' + val.id + '" >' + val.name + '</option>');
								if ($('#pmpro-defaultRole').length) {
									$('#pmpro-defaultRole').append('<option value="' + val.id + '" >' + val.name + '</option>');
								}
								makeDrag($('.makeMeDraggable'));
								makeDrag($('.makeMePmproDraggable'));
							}
						});
						var defaultRole = $('#selected_default_role').val();
						if (defaultRole) {
							$('#eduma-defaultRole option[value=' + defaultRole + ']').prop('selected', true);
						}
						if ($('#pmpro-selected_default_role').length) {
							var PmprodefaultRole = $('#pmpro-selected_default_role').val();
							if (PmprodefaultRole) {
								$('#pmpro-defaultRole option[value=' + PmprodefaultRole + ']').prop('selected', true);
							}
						}


						
						if (response.previous_mapping) {
							var mapjson = response.previous_mapping;
						} else {
							var mapjson = localStorage.getItem('eduma_mappingjson');
						}
						if (response.previous_pmpro_mapping) {
							var mappmprojson = response.previous_pmpro_mapping;
						} else {
							var mappmprojson = localStorage.getItem('eduma_pmpro_mappingjson');
						}

						$("#ets_eduma_mapping_json_val").html(mapjson);
						$.each(JSON.parse(mapjson), function (key, val) {
							var arrayofkey = key.split('id_');
							var preclone = $('*[data-eduma_role_id="' + val + '"]').clone();
							if (preclone.length > 1) {
								preclone.slice(1).hide();
							}

							if (jQuery('*[data-eduma_course_id="' + arrayofkey[1] + '"]').find('*[data-eduma_role_id="' + val + '"]').length == 0) {
								$('*[data-eduma_course_id="' + arrayofkey[1] + '"]').append(preclone).attr('data-drop-eduma_role_id', val).find('span').css({ 'order': '2' });
							}
							if ($('*[data-eduma_course_id="' + arrayofkey[1] + '"]').find('.makeMeDraggable').length >= 1) {
								$('*[data-eduma_course_id="' + arrayofkey[1] + '"]').droppable("destroy");
							}

							preclone.css({ 'width': '100%', 'left': '0', 'top': '0', 'margin-bottom': '0px', 'order': '1' }).attr('data-eduma_course_id', arrayofkey[1]);
							makeDrag(preclone);
						});
						$("#ets_eduma_mapping_pmpro_json_val").html(mappmprojson);
						
						$.each(JSON.parse(mappmprojson), function (key, val) {
							var arrayofkey = key.split('id_');
							var preclone_pmpro = $('*[data-eduma_pmpro_role_id="' + val + '"]').clone();
							if (preclone_pmpro.length > 1) {
								preclone_pmpro.slice(1).hide();
							}
							if (jQuery('*[data-pmpro_level_id="' + arrayofkey[1] + '"]').find('*[data-eduma_pmpro_role_id="' + val + '"]').length == 0) {
								$('*[data-pmpro_level_id="' + arrayofkey[1] + '"]').append(preclone_pmpro).attr('data-drop-eduma_pmpro_role_id', val).find('span').css({ 'order': '2' });
							}
							if ($('*[data-pmpro_level_id="' + arrayofkey[1] + '"]').find('.makeMePmproDraggable').length >= 1) {
								$('*[data-pmpro_level_id="' + arrayofkey[1] + '"]').droppable("destroy");
							}
							preclone_pmpro.css({ 'width': '100%', 'left': '0', 'top': '0', 'margin-bottom': '0px', 'order': '1' }).attr('data-pmpro_level_id', arrayofkey[1]);
							makeDrag(preclone_pmpro);

						});
					}

				},
				error: function (response) {
					$("#eduma-connect-discord-bot").show().html("Error: Please check all details are correct").addClass('error-bk');
					console.error(response);
				},
				complete: function () {
					$(".eduma-discord-roles .spinner").removeClass("is-active").css({ "float": "right" });
					$(".eduma-pmpro-levels-discord-roles .spinner").removeClass("is-active").css({ "float": "right" });
					$("#skeletabsTab1 .spinner").removeClass("is-active").css({ "float": "right", "display": "none" });
				}
			});
			/*Flush settings from local storage*/
			$("#revertMapping").on('click', function () {
				localStorage.removeItem('eduma_mapArray');
				localStorage.removeItem('eduma_mappingjson');
				localStorage.removeItem('eduma_pmpro_mapArray');
				localStorage.removeItem('eduma_pmpro_mappingjson');
				window.location.href = window.location.href;
			});
			/*Create droppable element*/
			function init() {
				if ($('.makeMeDroppable').length) {
					$('.makeMeDroppable').droppable({
						drop: handleDropEvent,
						hoverClass: 'hoverActive',
					});
				}
				if ($('.makePmproDroppable').length) {
					$('.makePmproDroppable').droppable({
						drop: handlePmproDropEvent,
						hoverClass: 'hoverActive',
					});
				}

				if ($('.eduma-discord-roles-col').length) {
					$('.eduma-discord-roles-col').droppable({
						drop: handlePreviousDropEvent,
						hoverClass: 'hoverActive',
					});
				}
				if ($('.eduma-pmpro-levels-discord-roles-col').length) {
					$('.eduma-pmpro-levels-discord-roles-col').droppable({
						drop: handlePmproPreviousDropEvent,
						hoverClass: 'hoverActive',
					});
				}
			}

			$(init);

			/*Create draggable element*/
			function makeDrag(el) {
				// Pass me an object, and I will make it draggable
				el.draggable({
					revert: "invalid",
					helper: 'clone',
					start: function (e, ui) {
						ui.helper.css({ "width": "45%" });
					}
				});
			}

			/*Handel droppable event for saved mapping*/
			function handlePreviousDropEvent(event, ui) {
				var draggable = ui.draggable;
				if (draggable.data('eduma_course_id')) {
					$(ui.draggable).remove().hide();
				}
				$(this).append(draggable);
				$('*[data-drop-eduma_role_id="' + draggable.data('eduma_role_id') + '"]').droppable({
					drop: handleDropEvent,
					hoverClass: 'hoverActive',
				});
				$('*[data-drop-eduma_role_id="' + draggable.data('eduma_role_id') + '"]').attr('data-drop-eduma_role_id', '');

				var oldItems = JSON.parse(localStorage.getItem('eduma_mapArray')) || [];
			
				$.each(oldItems, function (key, val) {
					if (val) {
						var arrayofval = val.split(',');
						if (arrayofval[0] == 'eduma_course_id_' + draggable.data('eduma_course_id') && arrayofval[1] == draggable.data('eduma_role_id')) {
							delete oldItems[key];
						}
					}
				});
				var jsonStart = "{";
				$.each(oldItems, function (key, val) {
					if (val) {
						var arrayofval = val.split(',');
						if (arrayofval[0] != 'eduma_course_id_' + draggable.data('eduma_course_id') || arrayofval[1] != draggable.data('eduma_role_id')) {
							jsonStart = jsonStart + '"' + arrayofval[0] + '":' + '"' + arrayofval[1] + '",';
						}
					}
				});
				localStorage.setItem('eduma_mapArray', JSON.stringify(oldItems));
				var lastChar = jsonStart.slice(-1);
				if (lastChar == ',') {
					jsonStart = jsonStart.slice(0, -1);
				}

				var eduma_mappingjson = jsonStart + '}';
				$("#ets_eduma_mapping_json_val").html(eduma_mappingjson);
				localStorage.setItem('eduma_mappingjson', eduma_mappingjson);
				draggable.css({ 'width': '100%', 'left': '0', 'top': '0', 'margin-bottom': '10px' });
			}
			function handlePmproPreviousDropEvent(event, ui) {

				var draggable = ui.draggable;
				if (draggable.data('pmpro_level_id')) {
					$(ui.draggable).remove().hide();
				}
				$(this).append(draggable);
				$('*[data-drop-eduma_pmpro_role_id="' + draggable.data('eduma_pmpro_role_id') + '"]').droppable({
					drop: handlePmproDropEvent,
					hoverClass: 'hoverActive',
				});
				$('*[data-drop-eduma_pmpro_role_id="' + draggable.data('eduma_pmpro_role_id') + '"]').attr('data-drop-eduma_pmpro_role_id', '');

				var oldItems = JSON.parse(localStorage.getItem('eduma_pmpro_mapArray')) || [];
				
				$.each(oldItems, function (key, val) {
					if (val) {
						var arrayofval = val.split(',');

						if (arrayofval[0] == 'pmpro_level_id_' + draggable.data('pmpro_level_id') && arrayofval[1] == draggable.data('eduma_pmpro_role_id')) {
							delete oldItems[key];
						} else {

						}
					}
				});
				var jsonStart = "{";
				$.each(oldItems, function (key, val) {
					if (val) {
						var arrayofval = val.split(',');
						if (arrayofval[0] != 'pmpro_level_id_' + draggable.data('pmpro_level_id') || arrayofval[1] != draggable.data('eduma_pmpro_role_id')) {
							jsonStart = jsonStart + '"' + arrayofval[0] + '":' + '"' + arrayofval[1] + '",';
						}
					}
				});
				localStorage.setItem('eduma_pmpro_mapArray', JSON.stringify(oldItems));
				var lastChar = jsonStart.slice(-1);
				if (lastChar == ',') {
					jsonStart = jsonStart.slice(0, -1);
				}

				var eduma_mappingjson = jsonStart + '}';
				
				$("#ets_eduma_mapping_pmpro_json_val").html(eduma_mappingjson);
				localStorage.setItem('eduma_pmpro_mappingjson', eduma_mappingjson);
				draggable.css({ 'width': '100%', 'left': '0', 'top': '0', 'margin-bottom': '10px' });
			}
			/*Handel droppable area for current mapping*/
			function handleDropEvent(event, ui) {
				var draggable = ui.draggable;
				var newItem = [];
				var newClone = $(ui.helper).clone();
				if ($(this).find(".makeMeDraggable").length >= 1) {
					return false;
				}
				$('*[data-drop-eduma_role_id="' + newClone.data('eduma_role_id') + '"]').droppable({
					drop: handleDropEvent,
					hoverClass: 'hoverActive',
				});
				$('*[data-drop-eduma_role_id="' + newClone.data('eduma_role_id') + '"]').attr('data-drop-eduma_role_id', '');
				if ($(this).data('drop-eduma_role_id') != newClone.data('eduma_role_id')) {
					var oldItems = JSON.parse(localStorage.getItem('eduma_mapArray')) || [];
					$(this).attr('data-drop-eduma_role_id', newClone.data('eduma_role_id'));
					newClone.attr('data-eduma_course_id', $(this).data('eduma_course_id'));

					$.each(oldItems, function (key, val) {
						if (val) {
							var arrayofval = val.split(',');
							if (arrayofval[0] == 'eduma_course_id_' + $(this).data('eduma_course_id')) {
								delete oldItems[key];
							}
						}
					});

					var newkey = 'eduma_course_id_' + $(this).data('eduma_course_id');
					oldItems.push(newkey + ',' + newClone.data('eduma_role_id'));
					var jsonStart = "{";
					$.each(oldItems, function (key, val) {
						if (val) {
							var arrayofval = val.split(',');
							if (arrayofval[0] == 'eduma_course_id_' + $(this).data('eduma_course_id') || arrayofval[1] != newClone.data('eduma_role_id') && arrayofval[0] != 'eduma_course_id_' + $(this).data('eduma_course_id') || arrayofval[1] == newClone.data('eduma_role_id')) {
								jsonStart = jsonStart + '"' + arrayofval[0] + '":' + '"' + arrayofval[1] + '",';
							}
						}
					});

					localStorage.setItem('eduma_mapArray', JSON.stringify(oldItems));
					var lastChar = jsonStart.slice(-1);
					if (lastChar == ',') {
						jsonStart = jsonStart.slice(0, -1);
					}

					var eduma_mappingjson = jsonStart + '}';
					localStorage.setItem('eduma_mappingjson', eduma_mappingjson);
					$("#ets_eduma_mapping_json_val").html(eduma_mappingjson);
				}

				$(this).append(newClone);
				$(this).find('span').css({ 'order': '2' });
				if (jQuery(this).find('.makeMeDraggable').length >= 1) {
					$(this).droppable("destroy");
				}
				makeDrag($('.makeMeDraggable'));
				newClone.css({ 'width': '100%', 'left': '0', 'top': '0', 'margin-bottom': '0px', 'position': 'unset', 'order': '1' });
			}

			function handlePmproDropEvent(event, ui) {
				var draggable = ui.draggable;
				var newItem = [];

				var newDefaultClone = $(ui.helper).clone();
				if ($(this).find(".makeMePmproDraggable").length >= 1) {
					return false;
				}
				$('*[data-drop-eduma_pmpro_role_id="' + newDefaultClone.data('eduma_pmpro_role_id') + '"]').droppable({
					drop: handlePmproDropEvent,
					hoverClass: 'hoverActive',
				});
				$('*[data-drop-eduma_pmpro_role_id="' + newDefaultClone.data('eduma_pmpro_role_id') + '"]').attr('data-drop-eduma_pmpro_role_id', '');
				if ($(this).data('drop-eduma_pmpro_role_id') != newDefaultClone.data('eduma_pmpro_role_id')) {
					var oldItems = JSON.parse(localStorage.getItem('eduma_pmpro_mapArray')) || [];
					$(this).attr('data-drop-eduma_pmpro_role_id', newDefaultClone.data('eduma_pmpro_role_id'));
					newDefaultClone.attr('data-pmpro_level_id', $(this).data('pmpro_level_id'));

					$.each(oldItems, function (key, val) {
						if (val) {
							var arrayofval = val.split(',');
							if (arrayofval[0] == 'data-pmpro_level_id' + $(this).data('pmpro_level_id')) {
								delete oldItems[key];
							}
						}
					});

					var newkey = 'pmpro_level_id_' + $(this).data('pmpro_level_id');
					oldItems.push(newkey + ',' + newDefaultClone.data('eduma_pmpro_role_id'));
					var jsonStart = "{";
					$.each(oldItems, function (key, val) {
						if (val) {
							var arrayofval = val.split(',');
							if (arrayofval[0] == 'pmpro_level_id_' + $(this).data('pmpro_level_id') || arrayofval[1] != newDefaultClone.data('eduma_pmpro_role_id') && arrayofval[0] != 'data-pmpro_level_id' + $(this).data('pmpro_level_id') || arrayofval[1] == newDefaultClone.data('eduma_pmpro_role_id')) {
								jsonStart = jsonStart + '"' + arrayofval[0] + '":' + '"' + arrayofval[1] + '",';
							}
						}
					});

					localStorage.setItem('eduma_pmpro_mapArray', JSON.stringify(oldItems));
					var lastChar = jsonStart.slice(-1);
					if (lastChar == ',') {
						jsonStart = jsonStart.slice(0, -1);
					}

					var eduma_pmpro_mappingjson = jsonStart + '}';
					localStorage.setItem('eduma_pmpro_mappingjson', eduma_pmpro_mappingjson);
					$("#ets_eduma_mapping_pmpro_json_val").html(eduma_pmpro_mappingjson);
				}
				$(this).append(newDefaultClone);
				$(this).find('span').css({ 'order': '2' });
				if (jQuery(this).find('.makeMePmproDraggable').length >= 1) {
					$(this).droppable("destroy");
				}
				makeDrag($('.makeMePmproDraggable'));

				newDefaultClone.css({ 'width': '100%', 'margin-bottom': '0px', 'left': '0', 'position': 'unset', 'order': '1' });
			}

			$('#ets_eduma_discord_connect_button_bg_color').wpColorPicker();
			$('#ets_eduma_discord_disconnect_button_bg_color').wpColorPicker();

			/**
			 * Clear LearnPress Discord log
			 */
			$('#ets-eduma-clrbtn').click(function (e) {
				e.preventDefault();
				$.ajax({
					url: etsEdumaParams.admin_ajax,
					type: "POST",
					data: { 'action': 'ets_eduma_discord_clear_logs', 'ets_eduma_discord_nonce': etsEdumaParams.ets_eduma_discord_nonce, },
					beforeSend: function () {
						$(".clr-log.spinner").addClass("is-active").show();
					},
					success: function (data) {
						if (data.error) {
							// handle the error
							alert(data.error.msg);
						} else {
							$('.error-log').html("Clear logs Sucesssfully !");
						}
					},
					error: function (response) {
						console.error(response);
					},
					complete: function () {
						$(".clr-log.spinner").removeClass("is-active").hide();
					}
				});
			});

			/*Clear log  PMPRO log call-back*/
			if ($('#eduma-pmpro-clrbtn').length) {
				$('#eduma-pmpro-clrbtn').click(function (e) {
					e.preventDefault();
					$.ajax({
						url: etsEdumaParams.admin_ajax,
						type: "POST",
						data: { 'action': 'ets_eduma_pmpro_discord_clear_logs', 'ets_eduma_pmpro_discord_nonce': etsEdumaParams.ets_eduma_discord_nonce, },
						beforeSend: function () {
							$("div.eduma-pmpro-clrbtndiv .clr-log.spinner").addClass("is-active").show();
						},
						success: function (data) {
							if (data.error) {
								// handle the error
								alert(data.error.msg);
							} else {
								$('.error-log-pmpro').html("Clear logs Sucesssfully !");
							}
						},
						error: function (response) {
							console.error(response);
						},
						complete: function () {
							$("div.eduma-pmpro-clrbtndiv .clr-log.spinner").removeClass("is-active").hide();
						}
					});
				});
			}
			$('.disconnect-discord-user').click(function (e) {
				e.preventDefault();
				$.ajax({
					url: etsEdumaParams.admin_ajax,
					type: "POST",
					context: this,
					data: { 'action': 'ets_eduma_learnpress_discord_disconnect_user', 'ets_eduma_learnpress_discord_user_id': $(this).data('user-id'), 'ets_eduma_discord_nonce': etsEdumaParams.ets_eduma_discord_nonce, },
					beforeSend: function () {
						$(this).find('span').addClass("is-active").show();
					},
					success: function (data) {

						if (data.error) {
							// handle the error 
							alert(data.error.msg);
						} else {
							$(this).prop('disabled', true);
						}
					},
					error: function (response, textStatus, errorThrown) {
						console.log(textStatus + " :  " + response.status + " : " + errorThrown);
					},
					complete: function () {
						$(this).find('span').removeClass("is-active").hide();
					}
				});
			});

			$('a.ets-eduma-step').on('click', function(e){
				e.preventDefault();
				var step = $(this).data('step');
				$('div.ets-eduma-theme-disccord-guide').find('.ets-eduma-step').removeClass('active');
				$(this).addClass('active');
				$('div.ets-eduma-theme-disccord-guide').find('div.tc-step').removeClass('active');
				$('div.' + step ).addClass('active');
			});

		}); // document ready
	}
	/*Tab options*/

	$.skeletabs.setDefaults({
		keyboard: false,
	});

})(jQuery);
