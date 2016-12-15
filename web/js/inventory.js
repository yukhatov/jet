var inventoryTable,
	selectBrands = document.getElementById("js-brand");

$(document).ready(function() {
	inventoryTable = $("#inventory-table").DataTable({
		// "dom": 'ftirpl',
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": Routing.generate('inventoryTableData'),
			"data": function (d) {
				d.providerId = $('select[id=js-provider] option:selected').val(),
				d.brandId = $('select[id=js-brand] option:selected').val()
			},
		},
		"drawCallback": fnCallback,
		"columns": [
			{ "data": "providerName" },
			{ "data": "brandName" },
			{ "data": "title" },
			{ "data": "colorTitle" },
			{ "data": "colorCode" },
			{ "data": "size" },
			{ "data": "upc" },
			{ "data": "sku" },
			{ "data": "asin" },
			{ "data": "price" },
			{ "data": "wholePrice" },
			{ "data": "stockCount" },
			{ "data": "fullStatus" },
			{ "data": "createdDate" },
		],
		"dom": "zftr" +							// https://datatables.net/reference/option/dom
					 "<'row'<'col-sm-4'i><'col-sm-4'p><'col-sm-4'l>>",
		"order": [[0, "asc"]],
		"pageLength": 10,
		"language": {
			search: "_INPUT_",				// search filter
			searchPlaceholder: 'Search by UPC, ASIN, Title',
			"paginate": {							// pagination
				"previous": '<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>',
				"next": 		'<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'
			}
		},
	});
});

function fnCallback(response){
	if(response.json.requestParameters.brandId == 0){
		fillSelectBrands(response.json.brands);
	}
}

$('select[id=js-provider]').change(function(){
	resetSelectBrands();
	inventoryTable.ajax.reload();
});

$('select[id=js-brand]').change(function(){
	inventoryTable.ajax.reload();
});

function fillSelectBrands(brands){
	if(brands.length)
	{
		brands.forEach(function(brand, i, brands) {
			var option = document.createElement("option");

			option.text = brand.title;
			option.value = brand.id;

			selectBrands.appendChild(option);
		});
	}
}

function resetSelectBrands(){
	while (selectBrands.firstChild) {
		selectBrands.removeChild(selectBrands.firstChild);
	}

	var singleOption = document.createElement("option");

	singleOption.text = 'All brands';
	singleOption.value = 0;

	selectBrands.appendChild(singleOption);
}
