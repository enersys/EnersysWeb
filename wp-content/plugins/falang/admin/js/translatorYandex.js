function translateService(sourceText){
	var translatedText;
	var data = {
		action : 'yandex_translate',
		sourceLanguageCode: translator.from,
		targetLanguageCode: translator.to,
		format: 'HTML',
		texts: [sourceText]
	};

	jQuery.ajax({
		type: 'POST',
		//v2 cloud don't support ajax query
		//url: "https://translate.api.cloud.yandex.net/translate/v2/translate",
		url: ajaxurl,
//		headers:  {
//  		'Authorization': 'Api-Key '+YandexKey,
//			"accept": "application/json",
//		},
		dataType: 'json',
		data: data,
		success: function (result) {
			$data = JSON.parse(result.data);
			if (result.success) {
				translatedText = $data.translations[0].text;
			} else {
				translatedText = result.text[0];
			}
		},
		error: function (xhr) {
			translatedText = "ERROR "+xhr.responseJSON["code"]+": "+xhr.responseJSON["message"];
		},
		async:false
	});

	return translatedText;
}