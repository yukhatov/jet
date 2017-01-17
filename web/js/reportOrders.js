
var table,
	summary;

$( document ).ready(function() {
	$('input[id="daterange"]').daterangepicker(
		{
			locale: {
			format: 'YYYY-MM-DD'
			}
		}
	);

	summary = $("#orders-report-summary-table").DataTable({
		"dom": '',
		'initComplete': function (){
			console.log(this.api().columns());

			this.api().columns($('.sum')).every(function(){
				console.log('OK');
				var column = this;

				var sum = column
					.data()
					.reduce(function (a, b) {
						a = parseInt(a, 10);
						if(isNaN(a)){ a = 0; }

						b = parseInt(b, 10);
						if(isNaN(b)){ b = 0; }

						return a + b;
					});

				$(column.footer()).html(sum);
			});
		}
	});

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
			{ "data": "order.orderPlacedDate" },
			{ "data": "title" },
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