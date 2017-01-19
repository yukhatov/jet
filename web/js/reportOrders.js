
var table,
	summary;

var col_date = 0,
	col_title = 1,
	col_asin = 2,
	col_qty = 3,
	col_whole_price = 4,
	col_ship_price = 5,
	col_sold = 6,
	col_income = 7,
	col_prec = 8;

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
			this.api().columns($('.sum')).every(function(){
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
			{
				extend: 'excel',
				text: 'Export',
				footer: 'true',
				title: 'Jet orders report'
			}
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
		"columnDefs": [
			{
				"targets": [col_whole_price, col_income, col_prec],
				"orderable": false
			},
			{ className: "text-right", "targets": [col_whole_price, col_ship_price, col_sold, col_income] },
			{
				"render": function ( data, type, row ) {
					var href = Routing.generate("order", { id: row.orderId });
					return '<a href="' + href + '" target="_blank">' + data + '</a>';
				},
				"targets": col_title
			},
		],
		"columns": [
			{ "data": "order.orderPlacedDate" },
			{ "data": "title" },
			{ "data": "inventory.asin" },
			{ "data": "quantity" },
			{ "data": "inventory.wholePrice"},
			{ "data": "shippingCost"},
			{ "data": "clearOrderPrice"},
			{ "data": "inventory.clearIncome"},
			{ "data": "inventory.incomePercentage"},
		],
		"dom": "Brt" +							// https://datatables.net/reference/option/dom
		"<'row'<'col-sm-4'i><'col-sm-4'p><'col-sm-4'l>>",
		"order": [[col_date, "desc"]],
		"pageLength": 25,
		"language": {
			"paginate": {							// pagination
				"previous": '<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>',
				"next": 	'<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'
			},
		},
		'footerCallback': function (){
			// calculating sums
			this.api().columns('.sum', { page: 'current' }).every(function(){
				var column = this;

				var sum = column
					.data()
					.reduce(function (a, b) {
						a = parseFloat(a);
						if(isNaN(a)){ a = 0; }

						b = parseFloat(b);
						if(isNaN(b)){ b = 0; }

						return a + b;
					}, 0);

				$(column.footer()).html(sum.toFixed(2));
			});

			setPercentTotal();
		}
	});

	table.buttons().container()
		.appendTo('.reports-filters')
		.find('.buttons-excel').prepend('<i class="fa fa-lg fa-file-excel-o" aria-hidden="true"></i>')
});

$('#daterange').on('apply.daterangepicker', function(ev, picker) {
	table.ajax.reload();
});

function setPercentTotal(){ // calculating income percent total
	var priceTotal = parseFloat($('#js-price-total').html()),
		incomeTotal = parseFloat($('#js-income-total').html());

	$('#js-perc-total').html((incomeTotal / priceTotal).toFixed(2) * 100);
}