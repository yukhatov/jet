$(document).ready(function() {

  $("#inventory-table").dataTable({
		"dom": 'ftirpl',				// https://datatables.net/reference/option/dom
		"order": [[0, "desc"]],
	  "iDisplayLength": 50,
		"language": {				// search filter
			search: "_INPUT_",
			searchPlaceholder: "Search Orders"
		},
		initComplete: function () {
			this.api().columns([0, 1]).every( function () {
				var column = this;
				var select = $('<select><option value=""></option></select>')
					.appendTo('#inventory-table_filter')
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
				});
			});
		}
  });

});