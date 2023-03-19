"use strict";

// Class Definition
var register = function(){

    var title = "register"
    var table = '#tbl-register';
    var grid;
    var gridColCount = 0;
    var dateStart = moment().subtract(7, "days").startOf("day");
    var dateEnd = moment().endOf("day");

    var _initComponent = function(){

        $('#form-register').submit(function(e){
            _registerUser();
            return false;
        });

    }

    var _registerUser = () => {

        $('#do-register').html('<i class="fa fa-sync fa-spin" aria-hidden="true"></i> Loading . . .').attr('disabled','true').addClass('disabled');

        $('#register-alert, #register-info').hide();
        $('#register-alert-text, #register-info-text').html('');

        let url = $('#form-register').attr('action');
        let method = "post";


        $.ajax({
            type: method,
            url: url+'/api/auth/register',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name : $('#name').val(),
                email : $('#email').val(),
                username : $('#username').val(),
                password : $('#password').val(),
                password_confirmation : $('#password-confirm').val(),
            },
            dataType: "json",
            success: function (res) {
                
                if(res.result){
                     $('#register-info-text').html("Pendaftaran berhasil, silahkan masuk melalui halaman login")
                    $('#register-info').show();
                }else{

                    let msg = generalAlert('Terjadi Kesalahan', res.response.msg, 'danger');
                    $('#register-alert-text').html(msg);
                    $('#register-alert').show();
                }
            },
            error:function(xhr,error){
                if(xhr.responseJSON.errors){
                    let msg = generalAlert('Terjadi Kesalahan', xhr.responseJSON.message, 'danger');
                    $('#register-alert-text').html(msg)
                    $('#register-alert').show();
                }else{
                    let msg = generalAlert('Terjadi Kesalahan', 'Terjadi kesalahan saat melakukan register', 'danger');
                    $('#register-alert-text').html(msg)
                    $('#register-alert').show();
                }
                
            },
            complete: function(){
                $('#do-register').html('Register').removeAttr('disabled').removeClass('disabled');
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
		register.init();
	}, 100)
});