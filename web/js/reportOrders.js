
var table;

$( document ).ready(function() {
	$('input[id="daterange"]').daterangepicker(
		{
			locale: {
			format: 'YYYY-MM-DD'
			}
		}
	);

	table = $("#orders-report-table").DataTable({
		"buttons": [
			'excel'
		],
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": Routing.generate('ordersReportTableData'),
			"data": function (d) {
				d.fromDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD'),
				d.toDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');
			},
		},
		"columnDefs": [ {
			"targets": [5,8,9],
			"orderable": false
		} ],
		"columns": [
			{ "data": "title" },
			{ "data": "order.orderPlacedDate" },
			{ "data": "order.status" },
			{ "data": "order.shipmentTrackingNumber" },
			{ "data": "quantity" },
			{ "data": "inventory.wholePrice"},
			{ "data": "shippingCost"},
			{ "data": "clearOrderPrice"},
			{ "data": "inventory.clearIncome"},
			{ "data": "inventory.incomePercentage"},
		],
		"dom": "Brt" +							// https://datatables.net/reference/option/dom
		"<'row'<'col-sm-4'i><'col-sm-4'p><'col-sm-4'l>>",
		"order": [[1, "asc"]],
		"pageLength": 25,
		"language": {
			"paginate": {							// pagination
				"previous": '<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>',
				"next": 	'<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'
			},
		},
	});

	table.buttons().container()
		.appendTo('.reports-filters')
		.find('.buttons-excel').prepend('<i class="fa fa-lg fa-file-excel-o" aria-hidden="true"></i>')

});

$('#daterange').on('apply.daterangepicker', function(ev, picker) {
	table.ajax.reload();
});
