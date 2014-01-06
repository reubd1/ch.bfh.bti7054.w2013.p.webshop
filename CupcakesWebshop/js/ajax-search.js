	$(function() {
		$(".search").keyup(function() {
			var searchid = $(this).val();
			var dataString = 'search=' + searchid;
			if (searchid != '') {
				$.ajax({
					type : "POST",
					url : "main.php",
					data : dataString,
					cache : false,
					success : function(html) {
						$("#res").html(html).show();
					}
				});
			}
			return false;
		});

		jQuery("#res").live("click", function(e) {
			var $clicked = $(e.target);
			var $name = $clicked.find('.name').html();
			var decoded = $("<div/>").html($name).text();
			$('#searchid').val(decoded);
		});
		jQuery(document).live("click", function(e) {
			var $clicked = $(e.target);
			if (!$clicked.hasClass("search")) {
				jQuery("#res").fadeOut();
			}
		});
		$('#searchid').click(function() {
			jQuery("#res").fadeIn();
		});
	});