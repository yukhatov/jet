/**
 * Created by artur on 24.10.16.
 */
$('#button-back').on('click', function(){
    window.location.replace("/orders");
});

$('.button-save').on('click', function(){
    var selectedQuantity = $(this).parent().closest('tr').find('#select-quantity').val(),
        itemId = $(this).parent().closest('tr').find('#select-quantity').data('item-id'),
        orderId = $(this).parent().closest('tr').find('#select-quantity').data('order-id');

    var data = {};
    data['orderId'] = orderId;
    data['itemId'] = itemId;
    data['quantity'] = selectedQuantity;

    $.ajax({
        'type': 'post',
        'url': "/editItem",
        'dataType': 'json',
        'data': data
    }).success(function(json) {
        console.log('success');
    });
});

$('.approve-order').on('click', function(){
    if($(this).hasClass('disabled')){
        return;
    }

    var statusId = $(this).data('status-id'),
        orderId = $('#select-quantity').data('order-id');

    var data = {};
    data['orderId'] = orderId;
    data['statusId'] = statusId;

    $.ajax({
        'type': 'post',
        'url': '/approve',
        'dataType': 'json',
        'data': data
    }).success(function(json) {
        if(json.success){
            notification(true);
        }else{
            notification(false);
        }
    });
});

$('#cancel-order').on('click', function(){
    if($(this).hasClass('disabled')){
        return;
    }

    var data = {};
    data['orderId'] = $('#select-quantity').data('order-id');

    $.ajax({
        'type': 'post',
        'url': '/cancel',
        'dataType': 'json',
        'data': data
    }).success(function(json) {
        if(json.success){
            notification(true);
        }else{
            notification(false);
        }
    });
});

$('#ship-order').on('click', function() {

    if($(this).hasClass('disabled')){
        return;
    }

    var orderForm = document.getElementById('order-form');

    if(orderForm.style.display == 'none')
    {
        orderForm.style.display = '';
    }else{
        orderForm.style.display = 'none';
    }

    var orderId = $('#select-quantity').data('order-id');
});

$('#form_save').on('click', function(e) {
    if(validateForm(e))
    {
        notification(true);
    }
});

function validateForm(e)
{
    var tackingNumber = document.getElementById('form_shipment_tracking_number').value;

    if(!tackingNumber)
    {
        alert('Tracking number required!');
        e.preventDefault();

        return false;
    }else{
        if(isNaN(tackingNumber))
        {
            alert('Tracking number must consist of digits only!');
            e.preventDefault();

            return false;
        }
    }

    return true;
}

$('#tracking-number').on('blur', function(e) {
    console.log('test');
});

function saveTN(e){
    if(e.keyCode === 13){
        var tn = $('#tracking-number').val();

        /*var data = {};
        data['tn'] = $('#tracking-number').val();

        $.ajax({
            'type': 'post',
            'url': '/cancel',
            'dataType': 'json',
            'data': data
        }).success(function(json) {
            if(json.success){
                notification(true);
            }else{
                notification(false);
            }
        });*/
    }
}

function notification(flag)
{
    if(flag)
    {
        alert('Your request is accepted and gonna be executed within 10 minutes.');
    }else{
        alert('Your request is rejected.');
    }
}
