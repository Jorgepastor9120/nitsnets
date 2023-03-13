import './bootstrap';

import Alpine from 'alpinejs';

import 'flowbite';

window.Alpine = Alpine;

Alpine.start();

$(document).ready(function(){

    $('.select2').select2({
        width: 'resolve',
        template: 'moderm'
    });

    $(function() {
        $('#datepicker').datepicker({
            dateFormat: 'dd/mm/yy',
            onSelect: function(dateText, inst) {

                let member_id = $('#member_id').val();
                let court_id = $('#court_id').val();
                let date = $('#datepicker').val();
                let dateFormated = date.replaceAll('/', '-');

                if (dateFormated) {
                    $.ajax({
                        url: '/get-hours/'+ member_id + '/' + court_id + '/' + dateFormated,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            if(data.cantidadReservasSocio < 3) {
                                $('#hour').empty();
                                $('#hour').append('<option value="">Selecciona una hora</option>');
                                $.each(data.hours, function (key, name) {
                                    $('#hour').append('<option value="' + name.id + '">' + name.name + '</option>');
                                });
                            } else {
                                $('#hour').empty();
                                $('#hour').append('<option value="">Este socio no puede hacer mas reservas este día.</option>');
                            }
                        }
                    });
                } else {
                    $('#hour').empty();
                    $('#hour').append('<option value="">Seleccione una hora</option>');
                }
            
            }
          });
      });

});
