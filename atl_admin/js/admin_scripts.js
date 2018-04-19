(function($) {
	var path = window.location.pathname

	$(".nav a").each(function() {
		var href = $(this).attr("href")
		
		if ( href == path) {
			$(this).parent("li").addClass("active")
		}
	});

	$("[template]").click(function(){
		var template = $(this).attr("template")
		template = $("#"+template).html()

		if ($(this).attr("template-target")) {
			$($(this).attr("template-target")).append(template)
		} else {
			$(this).before(template)
		}

		return false
	});

})(jQuery);