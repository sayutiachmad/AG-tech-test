"use strict";

// Class Definition
var showEmployee = function(){

    var title = "Show Employee"

    var _initComponent = function(){

        _showEmployee();

    }

    var _showEmployee = () => {

        let url = $('#information-block').attr('target');
        let id = $('#information-block').attr('data-id');
        let method = "get";


        $.ajax({
            type: method,
            url: url+'/api/employee/'+id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': "Bearer "+$('meta[name="user-jwt-token"]').attr('content'),
            },
            data: {
            
            },
            dataType: "json",
            success: function (res) {
                
                if(res.result){

                    let empData = res.response.data

                    $('#text-container-name').html(empData.nama);                    
                    $('#text-container-nip').html(empData.nip);                    
                    $('#text-container-birth-place').html(empData.tempat_lahir);                    
                    $('#text-container-birth-date').html(moment(empData.tanggal_lahir).format('DD MMMM YYYY'));                    
                    $('#text-container-age').html(empData.umur);                    
                    $('#text-container-address').html(empData.alamat);                    
                    $('#text-container-mobile').html(empData.no_handphone);                    
                    $('#text-container-email').html(empData.email); 
                    
                    
                    let religion = 'Lainnya';

                    switch (empData.agama) {
                        case 'I':
                            religion = 'Islam'
                            break;
                        case 'KP':
                            religion = 'Kristen Protestan'
                            break;
                        case 'KK':
                            religion = 'Kristen Katolik'
                            break;
                        case 'H':
                            religion = 'Hindu'
                            break;
                        case 'B':
                            religion = 'Budha'
                            break;
                        case 'KH':
                            religion = 'Konghucu'
                            break;
                        default:
                            break;
                    }

                    $('#text-container-religion').html(religion); 

                    let gender = '-';
                    
                    switch (empData.jenis_kelamin) {
                        case 'L':
                            gender = "Laki-laki"
                            break;
                        
                        case 'P':
                            gender = "Perempuan"
                            break;
                        default:
                            break;
                    }

                    $('#text-container-gender').html(gender); 
                    
                    $('#loading-block').fadeOut('fast', function(){
                        $('#information-block').fadeIn('fast');
                    });
                    

                }else{

                    let msg = generalAlert('Terjadi Kesalahan', res.response.msg, 'danger');
                    $('#showEmployee-alert-text').html(msg);
                    $('#showEmployee-alert').show();
                }
            },
            error:function(xhr,error){
                if(xhr.responseJSON.errors){
                    let msg = generalAlert('Terjadi Kesalahan', xhr.responseJSON.message, 'danger');
                    $('#showEmployee-alert-text').html(msg)
                    $('#showEmployee-alert').show();
                }else{
                    let msg = generalAlert('Terjadi Kesalahan', 'Terjadi kesalahan saat melakukan showEmployee', 'danger');
                    $('#showEmployee-alert-text').html(msg)
                    $('#showEmployee-alert').show();
                }
                
            },
            complete: function(){
                
            }
        });


    }

    

    // Public Functions
    return {
        // public functions
        init: function() {

            _initComponent();

        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
	setTimeout(function(){
		showEmployee.init();
	}, 100)
});