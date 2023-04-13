// $('#table-map').dataTable({}); 

$('div#alert-success').delay(5000).slideUp();

//$('#start-date, #end-date').datetimepicker({});

/*
$('#user-birthday, #search-statistic').datetimepicker({
	format: 'Y-m-d'
});
*/

$('.input-clear').click(function() {
   $('.frm-filter input:text, .frm-filter select').val(null);
});

$('#dropdown-paginate-limit a').click(function() {
	var val = $(this).attr('data-value');
	var url = getFullUrl();
	var rootPath = getRootPath(url);
	var extractUrl = extractQueryStringFromUrl(url);
	//alert(extractUrl);
	if (extractUrl) {
		//alert('true');
		var queryObject = getQueryObject(extractUrl);
		console.log(queryObject);
		if (Object.keys(queryObject).indexOf('page') > -1) {
			delete queryObject['page'];
		}
		if (Object.keys(queryObject).indexOf('limit') > -1) {
			queryObject['limit'] = val;
		}
		if (Object.keys(queryObject).indexOf('limit') === -1) {
			queryObject = $.extend(queryObject, {limit : val});
		}
		console.log(queryObject);
		var newParamString= getQueryStringFromQueryObject(queryObject);
		url = [rootPath, newParamString].join('?');
		window.location.href = url;
	}else{
		url = [[url, 'limit'].join('?'),val].join('=');
		window.location.href = url;
	}

});

function confirmDelete(){
	var conf = confirm("このデータを削除します。 よろしいでしょうか?");
	return conf ;
}


function getFullUrl() {
	return window.location.href;
}

function getRootPath(url) {
	var idx = url.indexOf('?');
	if(idx > -1) {
		return url.substring(0, idx);
	} else {
		return url;
	}
}

function extractQueryStringFromUrl(url) {
	var idx = url.indexOf('?');
	if(idx > -1) {
		return url.substring(idx+1);
	} else {
		return null;
	}
}

// some-query=somevalue&page=12&limit=20
function getQueryObject(queryString) {
	var queryObject = {};
	$.map(queryString.split('&'), function(v, k){
		var y = v.split('=');
		queryObject[y[0]] = y[1];
	});
	return queryObject;
}

function getQueryStringFromQueryObject(queryObject) {
	return $.map(queryObject, function(v, k){
		return [k, v].join('=');
	}).join('&');
}