$(document).ready(function() {

	$("#orders-table").dataTable({
		"fixedHeader": true,
		"dom": "ftr" +							// https://datatables.net/reference/option/dom
					 "<'row'<'col-sm-4'i><'col-sm-4'p><'col-sm-4'l>>",
		"order": [[0, "desc"]],
		"pageLength": 50,
		"language": {
			search: "_INPUT_",				// search filter
			searchPlaceholder: 'Search',
			"paginate": {							// pagination
				"previous": '<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>',
				"next": 		'<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'
			}
		},
		initComplete: function () {
			this.api().columns([1]).every( function () {
				var column = this;
				var select = $('<select><option value=""></option></select>')
					.appendTo('#orders-table_filter')
					.addClass('form-control input-sm')
					.on( 'change', function () {
						var val = $.fn.dataTable.util.escapeRegex(
							$(this).val()
						);
						column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
					} )
					.wrap('<div class="column-filter">');

				var title = $( column.header() ).text();			// get column's title
				select.before('<span>' +title+ ' </span>');		// set column's title before its filter

				column.data().unique().sort().each( function ( d, j ) {
					select
						.append( '<option value="'+d+'">'+d+'</option>' )
						.find('option:first').text('All');
				});
			});
		}
	});

});