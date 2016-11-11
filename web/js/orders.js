/**
 * Created by artur on 03.11.16.
 */

$(document).ready(function(){
	$("#orders-table").dataTable({
		"dom": 'ftr',				// https://datatables.net/reference/option/dom
		"order": [[0, "desc"]], 	// columns sorting
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
					} );
 
				column.data().unique().sort().each( function ( d, j ) {
					select.append( '<option value="'+d+'">'+d+'</option>' )
				} );
			} );
		}
	});
});
