var inventoryTable,
	selectProvider = document.getElementById("js-provider"),
	selectBrand = document.getElementById("js-brand");

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
		"columns": [ // Должны быть в таком же кол-ве и порядке как обьявленные колонки в InventoryItemRepository. (Сортировка)
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
		"dom": "ftr" +							// https://datatables.net/reference/option/dom
					 "<'row'<'col-sm-4'i><'col-sm-4'p><'col-sm-4'l>>",
		"order": [[0, "asc"]],
		"pageLength": 25,
		"language": {
			search: "_INPUT_",				// search filter
			searchPlaceholder: 'Search by UPC, ASIN, Title',
			"paginate": {							// pagination
				"previous": '<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>',
				"next": 		'<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'
			},
			// processing : "<i class='fa fa-spinner fa-spin fa-3x fa-fw preloader-spinner'></i>"
			processing : 
				'	<div class="preloader-spinner">	'+
				'		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="64" height="64" fill="white">	'+
				'			<path opacity=".2" d="M16 0 A16 16 0 0 0 16 32 A16 16 0 0 0 16 0 M16 4 A12 12 0 0 1 16 28 A12 12 0 0 1 16 4"/>	'+
				'			<path d="M16 0 A16 16 0 0 1 32 16 L28 16 A12 12 0 0 0 16 4z">	'+
				'				<animateTransform attributeName="transform" type="rotate" from="0 16 16" to="360 16 16" dur="0.8s" repeatCount="indefinite" />	'+
				'			</path>	'+
				'		</svg>	'+
				'	</div>	'
		},
	});

	$("#inventory-table_filter").append(selectProvider, selectBrand);
});

function fnCallback(response){
	if(response.json.requestParameters.brandId == 0){
		fillSelectBrand(response.json.brands);
	}
}

$('select[id=js-provider]').change(function(){
	resetSelectBrand();
	inventoryTable.ajax.reload();
});

$('select[id=js-brand]').change(function(){
	inventoryTable.ajax.reload();
});

function fillSelectBrand(brands){
	if(brands.length) {
		brands.forEach(function(brand, i, brands) {
			var option = document.createElement("option");

			option.text = brand.title;
			option.value = brand.id;

			selectBrand.appendChild(option);
		});
	}
}

function resetSelectBrand(){
	while (selectBrand.firstChild) {
		selectBrand.removeChild(selectBrand.firstChild);
	}

	var singleOption = document.createElement("option");

	singleOption.text = 'All brands';
	singleOption.value = 0;

	selectBrand.appendChild(singleOption);
}
