/**
 * Created by artur on 05.01.17.
 */
$(document).ready(function() {
    $("#afs-report-table").DataTable({
        "dom": "ftr" +							// https://datatables.net/reference/option/dom
            "<'row'<'col-sm-4'i><'col-sm-4'p><'col-sm-4'l>>",
        "order": [[0, "asc"]],
        "pageLength": 25,
        "language": {
            search: "_INPUT_",				// search filter
            searchPlaceholder: 'Search',
            "paginate": {							// pagination
                "previous": '<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>',
                "next": 		'<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'
            }
        },
        "columnDefs": [
            { "visible": false, "targets": 0 },
            /*{ "orderable": false, "targets": 1 }*/
        ],
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="8">'+group+'</td></tr>'
                    );

                    last = group;
                }
            } );
        },
        initComplete: function () {
            this.api().columns([0]).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo('#afs-report-table_filter')
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
