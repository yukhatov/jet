$(document).ready(function() {

	$("#orders-table").dataTable({
		"dom": 'ftirpl',				// https://datatables.net/reference/option/dom
		"order": [[0, "desc"]],
		"iDisplayLength": 50,
		// columns sorting
		// "oLanguage": {
		// 	"sSearch": ""
		// },
		"language": {				// search filter
			search: "_INPUT_",
			searchPlaceholder: "Search Orders"
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
					.wrap('<div class="filter-by-status">')
					.before( '<span>Status </span>' );
 
				column.data().unique().sort().each( function ( d, j ) {
					select.append( '<option value="'+d+'">'+d+'</option>' )
				} );
			} );
		}
	});

});
