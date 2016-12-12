/**
 * Created by artur on 25.11.16.
 */

$( document ).ready(function() {
       $('input[id="daterange"]').daterangepicker(
           {
                  locale: {
                         format: 'YYYY-MM-DD'
                  }
           }
       );
});

$('#daterange').on('apply.daterangepicker', function(ev, picker) {
       filter();
});

$('select[name=provider], select[name=brand]').change(function(){
       filter();
});

function filter()
{
       var selectedProvider = $('select[name=provider] option:selected').val(),
           selectedBrand = $('select[name=brand] option:selected').val(),
           fromDate = $('#daterange').data('daterangepicker').startDate.format('YYYY-MM-DD'),
           toDate = $('#daterange').data('daterangepicker').endDate.format('YYYY-MM-DD');

       window.location.href = Routing.generate('instock') + '/' + fromDate + '/' + toDate + '/' + selectedProvider + '/' + selectedBrand;
}
