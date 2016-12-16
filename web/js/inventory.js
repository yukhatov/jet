var inventoryTable,
	selectStock = document.getElementById("js-stock"),
	selectStatus = document.getElementById("js-status"),
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
				d.brandId = $('select[id=js-brand] option:selected').val(),
				d.stock = $('select[id=js-stock] option:selected').val(),
				d.status = $('select[id=js-status] option:selected').val()
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
		"dom": "f<'backend-filters'>tr" +							// https://datatables.net/reference/option/dom
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
			processing :  ' <div class="preloader-spinner"> ' +
										'   <svg version="1.1" id="preloader" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" ' +
										'    width="50px" height="50px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve"> ' +
										'   <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946 ' +
										'     s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634 ' +
										'     c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/> ' +
										'   <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0 ' +
										'     C22.32,8.481,24.301,9.057,26.013,10.047z"> ' +
										'     <animateTransform attributeType="xml" ' +
										'       attributeName="transform" ' +
										'       type="rotate" ' +
										'       from="0 20 20" ' +
										'       to="360 20 20" ' +
										'       dur="1s" ' +
										'       repeatCount="indefinite"/> ' +
										'     </path> ' +
										'   </svg> ' +
										' </div> ' +
										' <p><strong>Processing...</strong></p>'
		},
	});

	$("#inventory-table_filter").append(selectProvider, selectBrand, selectStock, selectStatus);
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

$('select[id=js-stock]').change(function(){
	inventoryTable.ajax.reload();
});

$('select[id=js-status]').change(function(){
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
