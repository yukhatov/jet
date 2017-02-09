var inventoryTable,
    isAllRulesSaved = true;

$(document).ready(function() {
    inventoryTable = $("#inventory-rule-table").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": Routing.generate('ruleManagerBrandTableData'),
            "data": function (d) {
                d.brandId = $('table').data('brand-id')
                d.order = {0: {
                    'column': 14,
                    'dir': 'desc'
                }}
            },
        },
        "columns": [
            { "data": "ruleId" },
            { "data": "title" },
            { "data": "colorCode" },
            { "data": "size" },
            { "data": "upc" },
            { "data": "rule.discount" },
            { "data": "rule.shipping" },
            { "data": "rule.baseFactor" },
            { "data": "rule.minFactor" },
            { "data": "rule.maxFactor" },
            { "data": "rule.minIncome" },
            { "data": "rule.minIncomePerc" },
            {},
        ],
        "columnDefs": [
            { "orderable": false, "targets": [0,1,2,3,4,5,6,7,8,9,10,11,12] },
            { "visible": false, "targets": 0 },
            { className: "action", "targets": 12 },
            {
                "render": function ( data, type, row ) {
                    if(row.ruleId)
                    {
                        return '<a href="" class="remove"><i class="fa fa-remove fa-lg" aria-hidden="true"></i></a>  <a href="" class="edit"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></a>';
                    }else{
                        return '<a href="" class="edit"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></a>';
                    }
                },
                "targets": 12
            },
            {
                "render": function ( data, type, row ) {
                    return '<label><input disabled id="discount" type="text" value="'+ data +'"></label>';
                },
                "targets": [5]
            },
            {
                "render": function ( data, type, row ) {
                    return '<label><input disabled id="shipping" type="text" value="'+ data +'"></label>';
                },
                "targets": [6]
            },
            {
                "render": function ( data, type, row ) {
                    return '<label><input disabled id="base-factor" type="text" value="'+ data +'"></label>';
                },
                "targets": [7]
            },
            {
                "render": function ( data, type, row ) {
                    return '<label><input disabled id="min-factor" type="text" value="'+ data +'"></label>';
                },
                "targets": [8]
            },
            {
                "render": function ( data, type, row ) {
                    return '<label><input disabled id="max-factor" type="text" value="'+ data +'"></label>';
                },
                "targets": [9]
            },
            {
                "render": function ( data, type, row ) {
                    return '<label><input disabled id="min-income" type="text" value="'+ data +'"></label>';
                },
                "targets": [10]
            },
            {
                "render": function ( data, type, row ) {
                    return '<label><input disabled id="min-income-perc" type="text" value="'+ data +'"></label>';
                },
                "targets": [11]
            },
        ],
        // Per-row function to iterate cells
        "createdRow": function (row, data, rowIndex) {
            $( row ).attr('data-item-id', data.id);

            if(data.ruleId){
                $( row ).addClass( "bold-row" );
            }
        },
        "dom": "ftr" +							// https://datatables.net/reference/option/dom
        "<'row'<'col-sm-4'i><'col-sm-4'p><'col-sm-4'l>>",
        "order": [[0, "desc"]],
        "pageLength": 25,
        "language": {
            search: "_INPUT_",				// search filter
            searchPlaceholder: 'Search by UPC, Title',
            "paginate": {							// pagination
                "previous": '<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>',
                "next": 		'<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'
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
    });
});

$('#button-back').on('click', function(){
    window.history.back();
});

/*
 * Alert before go away
 * */
$(window).on("beforeunload", function() {
    if(!isAllRulesSaved) return true;
});

$(document).on('click', '.edit', function(e) {
    e.preventDefault();

    isAllRulesSaved = !isAllRulesSaved;

    var tr = $(this).closest('tr').find('input');

    if( $(this).find('i').hasClass("fa fa-edit") )
    {
        $(this).find('i').removeClass("fa fa-edit").addClass( "fa fa-save" )
        tr.removeAttr('disabled');

        /* appending close button */
        $(this).parent().append('<a href="" class="close"><i class="fa fa-window-close-o" aria-hidden="true"></i></a>');
    }else{
        if(saveRule($(this).closest('tr')))
        {
            $(this).find('i').removeClass("fa fa-save").addClass( "fa fa-edit" )
            tr.attr('disabled', true);
        }

        /* removing close button */
        $(this).parent().find('a.close').remove();
    }
});

$(document).on('click', '.remove', function(e) {
    e.preventDefault();

    if($.ajax({
            'type': 'post',
            'url': Routing.generate('itemRemoveRule', { itemId: $(this).closest('tr').data('item-id') }),
            'dataType': 'json',
        }).success(function(json) {
            return json.success;
        })){
        //set data from brand rule
        setBrandRule($(this).closest('tr').data('item-id'), $(this).closest('tr'));

        // remove styling and 'remove' button
        $(this).closest('tr').removeClass('bold-row');

        if( $(this).parent().find('i.fa-save'))
        {
            $(this).parent().find('i.fa-save').removeClass("fa-save").addClass( "fa-edit" );

            isAllRulesSaved = !isAllRulesSaved;
        }

        $(this).closest('tr').find('input').attr('disabled', true);
        $(this).parent().find('a.close').remove();

        $(this).remove();
    }
});

$(document).on('click', '.close', function(e) {
    e.preventDefault();

    isAllRulesSaved = !isAllRulesSaved;

    var tr = $(this).closest('tr').find('input');
    tr.attr('disabled', true);

    $(this).parent().find('i.fa-save').removeClass("fa-save").addClass( "fa-edit" );
    $(this).remove();
});

function saveRule(row){
    var itemId = row.data('item-id');

    var rule = {};
    rule['discount'] = row.find('#discount').val();
    rule['shipping'] = row.find('#shipping').val();
    rule['baseFactor'] = row.find('#base-factor').val();
    rule['minFactor'] = row.find('#min-factor').val();
    rule['maxFactor'] = row.find('#max-factor').val();
    rule['minIncome'] = row.find('#min-income').val();
    rule['minIncomePerc'] = row.find('#min-income-perc').val();

    if(validRule(rule) && itemId)
    {
        return $.ajax({
            'type': 'post',
            'url': Routing.generate('itemSaveRule', { itemId: itemId }),
            'dataType': 'json',
            'data': rule
        }).success(function(json) {
            if(!json.success){
                //alert('Error: brand not found');
            }else{
                row.children(".action").html('<a href="" class="remove"><i class="fa fa-remove fa-lg" aria-hidden="true"></i></a>  <a href="" class="edit"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></a>');
                row.addClass('bold-row');
            }

            return json.success;
        });
    }
}

function validRule(rule){
    var isValid = true;

    for(var propertyName in rule) {
        if(isNaN(rule[propertyName])){
            isValid = false;
        }
    }

    return isValid;
}

function setBrandRule(id, row){
    $.ajax({
        'type': 'post',
        'url': Routing.generate('itemGetRule', { itemId: id }),
        'dataType': 'json',
        'success': function(json) {
            if(json.rule)
            {
                row.find('#discount').val(json.rule.discount);
                row.find('#shipping').val(json.rule.shipping);
                row.find('#base-factor').val(json.rule.baseFactor);
                row.find('#min-factor').val(json.rule.minFactor);
                row.find('#max-factor').val(json.rule.maxFactor);
                row.find('#min-income').val(json.rule.minIncome);
                row.find('#min-income-perc').val(json.rule.minIncomePerc);
            }
        }
    });
}