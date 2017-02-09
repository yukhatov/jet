/**
 * Created by artur on 30.01.17.
 */

var table,
    isAllRulesSaved = true;

$(document).ready(function() {
    tableInit();
    hideAllBrands();
});

function hideAllBrands()
{
    //$('*[data-brand-id]').hide();
    $("[data-brand-id][data-rule='null']").hide();
}

function showBrandsByProvider(providerId) {
    $('*[data-provider=' + providerId + ']').show();
}

function hideBrandsByProvider(providerId) {
    $('[data-provider=' + providerId + ']:not(.bold-row)').hide();
}

$(document).on('click', '.provider-group', function(e) {
    e.preventDefault();

    var providerId = $(this).closest('tr').data('provider-id');

    if( $(this).find('i').hasClass("fa-chevron-down") )
    {
        $(this).find('i').removeClass("fa-chevron-down").addClass( "fa-chevron-up" )
        showBrandsByProvider(providerId);
    }else{
        $(this).find('i').removeClass("fa-chevron-up").addClass( "fa-chevron-down" )
        hideBrandsByProvider(providerId);
    }
});

$(document).on('click', '#show-all-button', function(e) {

    if($(this).html() == 'Show all')
    {
        $('.provider-group').trigger('click');
        $(this).html('Hide all');
    }else{
        $('.provider-group').trigger('click');
        $(this).html('Show all');
    }
});

function tableInit()
{
    table = $("#rule-manager-table").DataTable({
        "fixedHeader": true,
        "dom": "ftr" +							// https://datatables.net/reference/option/dom
        "<'row'<'col-sm-4'i><'col-sm-4'p><'col-sm-4'l>>",
        "aaSorting": [],
        "pageLength": -1,
        "lengthMenu": [[10, 25, 50, -1], [25, 50, 100, "All"]],
        "language": {
            search: "_INPUT_",				// search filter
            searchPlaceholder: 'Search',
            "paginate": {							// pagination
                "previous": '<i class="fa fa-3x fa-angle-left" aria-hidden="true"></i>',
                "next": 		'<i class="fa fa-3x fa-angle-right" aria-hidden="true"></i>'
            }
        },
        "columnDefs": [
            { "width": "4.5%", "targets": 8 }
        ]
    });
}

$(document).on('click', '.remove', function(e) {
    e.preventDefault();

    if($.ajax({
        'type': 'post',
        'url': Routing.generate('removeRule', { brandId: $(this).closest('tr').data('brand-id') }),
        'dataType': 'json',
    }).success(function(json) {
        return json.success;
    })){
        //set data from provider rule
        setProviderRule($(this).closest('tr').data('brand-id'), $(this).closest('tr'));

        // remove styling and 'remove' button
        $(this).closest('tr').removeClass('bold-row');
        /* remove data attr */
        $(this).closest('tr').data('rule', null);
        /* if all hidden - hide */
        if($('[data-provider-id=' + $(this).closest('tr').data('provider') +']').find('.fa-chevron-down').length){
            $(this).closest('tr').hide();
        }

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

$(document).on('click', '.edit', function(e) {
    e.preventDefault();

    isAllRulesSaved = !isAllRulesSaved;

    var tr = $(this).closest('tr').find('input');

    if( $(this).find('i').hasClass("fa fa-edit") )
    {
        $(this).find('i').removeClass("fa fa-edit").addClass( "fa fa-save" )
        tr.removeAttr('disabled');
        tr.focus();

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

$(document).on('click', '.close', function(e) {
    e.preventDefault();

    isAllRulesSaved = !isAllRulesSaved;

    var tr = $(this).closest('tr').find('input');
    tr.attr('disabled', true);

    $(this).parent().find('i.fa-save').removeClass("fa-save").addClass( "fa-edit" );
    $(this).remove();
});
/*
* Alert before go away
* */
$(window).on("beforeunload", function() {
    if(!isAllRulesSaved) return true;
});

function saveRule(row)
{
    var brandId = row.data('brand-id'),
        providerId = row.data('provider-id');

    var rule = {};
    rule['discount'] = row.find('#discount').val();
    rule['shipping'] = row.find('#shipping').val();
    rule['baseFactor'] = row.find('#base-factor').val();
    rule['minFactor'] = row.find('#min-factor').val();
    rule['maxFactor'] = row.find('#max-factor').val();
    rule['minIncome'] = row.find('#min-income').val();
    rule['minIncomePerc'] = row.find('#min-income-perc').val();

    if(validRule(rule))
    {
        var result = false;

        if(brandId)
        {
            return $.ajax({
                'type': 'post',
                'url': Routing.generate('brandSaveRule', { brandId: brandId }),
                'dataType': 'json',
                'data': rule
            }).success(function(json) {
                if(!json.success){
                    //alert('Error: brand not found');
                }else{
                    row.children(".action").html('<a href="" class="remove"><i class="fa fa-remove fa-lg" aria-hidden="true"></i></a>  <a href="" class="edit"><i class="fa fa-edit fa-lg" aria-hidden="true"></i></a>');
                    row.addClass('bold-row');
                    row.data('rule', json.ruleId);
                }

                return json.success;
            });
        }else{
            if(providerId)
            {
                return $.ajax({
                    'type': 'post',
                    'url': Routing.generate('providerSaveRule', { providerId: providerId }),
                    'dataType': 'json',
                    'data': rule
                }).success(function(json) {
                    if(!json.success){
                        //alert('Error: provider not found');
                    }else{
                        location.reload();
                    }

                    return json.success;
                });
            } else {
                return false;
            }
        }
    }else{
        alert('Digits only');

        return false;
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

function setProviderRule(id, row){
    $.ajax({
        'type': 'post',
        'url': Routing.generate('brandGetRule', { brandId: id }),
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

                row.data('rule', null);
            }
        }
    });
}
