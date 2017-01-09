/**
 * Created by artur on 05.01.17.
 */
$(document).ready(function() {
    var table = $("#afs-report-table").DataTable({
        "fixedHeader": true,
        "dom": "ftr" +							// https://datatables.net/reference/option/dom
            "<'row'<'col-sm-4'i><'col-sm-4'p><'col-sm-4'l>>",
        "order": [[0, "asc"]],
        "pageLength": -1,
        "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
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
            //  for totals
            var colonne = api.row(0).data().length;
            var groupid = -1;
            var subtotale = new Array();
            //
            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    groupid++;
                    $(rows).eq( i ).before(
                        '<tr class="group"><td>'+group+'</td></tr>'
                    );

                    last = group;
                }

                // counting totals
                val = api.row(api.row($(rows).eq( i )).index()).data();      //current order index
                $.each(val,function(index2,val2){
                    if (typeof subtotale[groupid] =='undefined'){
                        subtotale[groupid] = new Array();
                    }
                    if (typeof subtotale[groupid][index2] =='undefined'){
                        subtotale[groupid][index2] = 0;
                    }

                    valore = Number(val2.replace('€',"").replace('.',"").replace(',',"."));
                    subtotale[groupid][index2] += valore;
                });
            } );

            //appending totals
            $('tbody').find('.group').each(function (i,v) {
                var rowCount = $(this).nextUntil('.group').length;
                $(this).find('td:first').append($('<span />', { 'class': 'rowCount-grid' }).append($('<b />', { 'text': ' ('+rowCount+')' })));

                var subtd = '';

                for (var a = 2; a < colonne; a++)
                {
                    subtd += '<td>' + subtotale[i][a] + '</td>';
                }

                $(this).append(subtd);
            });
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

