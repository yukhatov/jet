/**
 * Created by artur on 24.10.16.
 */
$('#button-save').on('click', function(){
    var selectedQuantity = $('#select-quantity').val(),
        itemId = $('#select-quantity').data('item-id'),
        orderId = $('#select-quantity').data('order-id');

    var data = {};
    data['orderId'] = orderId;
    data['itemId'] = itemId;
    data['quantity'] = selectedQuantity;

    $.ajax({
        'type': 'post',
        'url': orderId + '/items/' + itemId + '/edit/' + selectedQuantity,
        'dataType': 'json',
        'data': data
    }).success(function(json) {
        console.log('success');
    });
});