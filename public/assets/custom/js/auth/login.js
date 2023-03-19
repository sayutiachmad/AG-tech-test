"use strict";

// Class Definition
var login = function(){

    var title = "login"
    var table = '#tbl-login';
    var grid;
    var gridColCount = 0;
    var dateStart = moment().subtract(7, "days").startOf("day");
    var dateEnd = moment().endOf("day");

    var _initComponent = function(){

        $('#form-login').submit(function(){
            _loginJwt();
            return false;
        });

    }

    var _loginJwt = () => {

        $('#do-login').html('<i class="fa fa-sync fa-spin" aria-hidden="true"></i> Loading . . .').attr('disabled','true').addClass('disabled');

        $('#login-alert').hide();
        $('#login-alert-text').html('');

        let url = $('#form-login').attr('action');
        let method = "post";


        $.ajax({
            type: method,
            url: url+'/api/auth/login',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                email : $('#email').val(),
                password : $('#password').val(),
            },
            dataType: "json",
            success: function (res) {
                
                if(res.result){
                    _createCookies(res)
                }else{
                    $('#login-alert-text').html(res.response.msg)
                    $('#login-alert').show();
                }
            },
            error:function(xhr,error){



                if(xhr.responseJSON.error == 'Unauthorized'){
                    $('#login-alert-text').html('Periksa kembali username / email dan password anda');
                    $('#login-alert').show();
                }else{
                    $('#login-alert-text').html('Terjadi kesalahan saat melakukan login')
                    $('#login-alert').show();
                }
                
            },
            complete: function(){
                $('#do-login').html('<i class="fa fa-check" aria-hidden="true"></i> Save').removeAttr('disabled').removeClass('disabled');
            }
        });


    }

    var _createCookies = (res) => {
        $('#do-login').html('<i class="fa fa-sync fa-spin" aria-hidden="true"></i> Loading . . .').attr('disabled','true').addClass('disabled');

        $('#login-alert').hide();
        $('#login-alert-text').html('');

        let url = $('#form-login').attr('action');
        let method = "post";


        $.ajax({
            type: method,
            url: url+'/set-cookie',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                email : $('#email').val(),
                access_token : res.access_token,
                token_type : res.token_type,
                expires_in : 3600
            },
            dataType: "json",
            success: function (res) {
                
                if(res.result){
                    
                    window.location = url+'/dashboard';

                }else{
                    $('#login-alert-text').html(res.response.msg)
                    $('#login-alert').show();
                }
            },
            error:function(xhr,error){
                if(xhr.responseJSON.errors){
                    $('#login-alert-text').html(xhr.responseJSON.message)
                    $('#login-alert').show();
                }else{
                    $('#login-alert-text').html('Terjadi kesalahan saat melakukan login')
                    $('#login-alert').show();
                }
                
            },
            complete: function(){
                $('#do-login').html('<i class="fa fa-check" aria-hidden="true"></i> Save').removeAttr('disabled').removeClass('disabled');
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
		login.init();
	}, 100)
});