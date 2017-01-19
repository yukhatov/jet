
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
					}, 0);

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
				"targets": [4,7,8],
				"orderable": false
			},
			{ className: "text-right", "targets": [4, 5, 6, 7] },
		],
		"columns": [
			{ "data": "order.orderPlacedDate" },
			{ "data": "titleWithOrderLink" },
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
		"order": [[0, "desc"]],
		"pageLength": 25,
		"language": {
			"paginate": {							// pagination
				"previous": '<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>',
				"next": 	'<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'
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