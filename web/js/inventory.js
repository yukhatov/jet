var inventoryTable;

$(document).ready(function() {

	inventoryTable =

	$("#inventory-table").DataTable({
		// "dom": 'ftirpl',
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": Routing.generate('inventoryTableData'),
			"data": function (d) {
				d.providerId = $('select[name=provider] option:selected').val(),
				d.brandId = $('select[name=brand] option:selected').val()
			}
		},
		"columns": [
			{ "data": "brandName" },
			{ "data": "providerName" },
			{ "data": "upc" },
			{ "data": "sku" },
		],

		"dom": "ftr" +							// https://datatables.net/reference/option/dom
					 "<'row'<'col-sm-4'i><'col-sm-4'p><'col-sm-4'l>>",
		"order": [[0, "desc"]],
		"pageLength": 10,
		"language": {
			search: "_INPUT_",				// search filter
			searchPlaceholder: 'Search by UPC',
			"paginate": {							// pagination
				"previous": '<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>',
				"next": 		'<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'
			}
		},
	});
});



$('select[name=provider], select[name=brand]').change(function(){
	//filter();
	console.log(inventoryTable);

	inventoryTable.ajax.reload();
});

function filter()
{
	var selectedProvider = $('select[name=provider] option:selected').val(),
		selectedBrand = $('select[name=brand] option:selected').val();

	window.location.href = Routing.generate('inventory') + '/' + selectedProvider + '/' + selectedBrand;
}