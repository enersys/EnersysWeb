(function($) {
	if (falang) {
		$.ajaxSetup({
			beforeSend: function (jqXHR, settings) {
				if (settings.type=='POST') {
					if (typeof settings.data === "string") {
						settings.data = (settings.data ? settings.data+'&' : '')+falang.query_var+"="+falang.current;
					} else if (typeof settings.data === "object") {
						settings.data[falang.query_var] = falang.current;
					}
				} else {
					settings.url += (settings.url.indexOf('?') > -1 ? '&' : '?')+falang.query_var+"="+falang.current;
				}
			}
		});
	}
}(jQuery))