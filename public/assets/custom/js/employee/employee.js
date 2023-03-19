"use strict";

// Class Definition
var employee = function(){

    var title = "Employee"
    var table = '#tbl-employee';
    var grid;
    var gridColCount = 0;
    var generalToast;
    var toast;

    var _initComponent = function(){

        $('#fl-form').submit(function(){
            grid.ajax.reload();
            return false;
        });

        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            clearBtn:true,
            startView:2
        });

        $('#new-employee').on('click', function(){
            _clearForm();
            $('[name="form_action"]').val('ADD');
            $('#modal-employe-label-title').html('Data Karyawan Baru');
            $('#modal-form-employee').modal('show');
        });

        $('#emp-birth-date').on('change', function(){
            let bd = $(this).val();
            bd = moment(bd, 'DD-MM-YYYY').format("YYYY-MM-DD");
            let age = moment().diff(bd, 'years',false);

            $('#emp-age').val(age);
        });

        $('#form-employee').submit(function(){

            _saveNewEmployee();

            return false;
        });

        generalToast = document.getElementById('general-toast');
        toast = new bootstrap.Toast(generalToast);
     
    }

    var _initGrid = function(){
        grid = $(table).DataTable({
            paging:true,
            responsive: true,
            processing: true,
            scrollCollapse: true,
			ajax: {
				url: $(table).attr('target')+"/api/employee/list",
				type: 'post',
				headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': "Bearer "+$('meta[name="user-jwt-token"]').attr('content'),
                },
                data:function(d){
                    return $('#fl-form').serializeArray();
                }
			},
            drawCallback: function () {
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
			columns: [
                {
                    data: null,
                    searchable:false,
                    orderable:false,
                    defaultContent: "",
                },
                {
                    data:null,
                    searchable:false,
                    orderable:false,
                    defaultContent:"",
                    width:'150px',
                    render:(data,type,row) => {
                        let opt = '';
                        let profile = $(table).attr('target')+'/employee';

                        opt += '<a href="'+profile+"/"+row.id+'" class="btn btn-link btn-color-gray-600 btn-active-color-primary py-0 mx-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" data-bs-title="Detail Karyawan"><i class="fa fa-user" aria-hidden="true"></i></a>';
                        opt += '<a href="javascript:;" class="btn btn-link btn-color-gray-600 btn-active-color-warning py-0 mx-1 edit-data" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" data-bs-title="Ubah Data"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        opt += '<a href="javascript:;" class="btn btn-link btn-color-gray-600 btn-active-color-danger py-0 mx-1 remove-data" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-inverse" data-bs-placement="top" data-bs-title="Hapus Data"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                        return opt;
                    }
                },
                {
                    data:'nama'
                },
                {
                    data:'nip'
                },
                {
                    data:'tempat_lahir'
                },
                {
                    data:'tanggal_lahir',
                    render:function(data){
                        return moment(data).format('DD MMMM YYYY');
                    }
                },
                {
                    data:'umur',
                    class:'text-center'
                },
                {
                    data:'alamat'
                },
                {
                    data:'agama',
                    render: function(data){

                        let religion = 'Lainnya';

                        switch (data) {
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

                        return religion;

                    }
                },
                {
                    data:'jenis_kelamin',
                    class:'text-center',
                    render:function(data){

                        if(data == 'L'){
                            return `<span class="badge text-bg-info">Laki-laki</span>`;
                        }

                        if(data == 'P'){
                            return `<span class="badge text-bg-success">Perempuan</span>`;
                        }

                        return '-';

                    }
                },
                {
                    data:'no_handphone',
                    class:'text-end'
                },
                {
                    data:'email'
                }
			],
			order:[]
        });
        
        grid.on( 'order.dt search.dt', function () {
            grid.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        }).draw();

        $(table).find('tbody').on('click','.edit-data',function(){

            _clearForm();
            $('input[name="form_action"]').val('EDIT');
            $('#modal-employe-label-title').html('Ubah Data Karyawan');

            let tableData = grid.row($(this).parents('tr')).data();

            $('input[name="emp_name"]').val(tableData.nama);
            $('input[name="emp_nip"]').val(tableData.nip);
            $('input[name="emp_birth_place"]').val(tableData.tempat_lahir);
            $('input[name="emp_birth_date"]').val(moment(tableData.tanggal_lahir).format('DD-MM-YYYY')).trigger('change');
            $('input[name="emp_address"]').val(tableData.alamat);
            $('select[name="emp_religion"]').val(tableData.agama).trigger('change');
            $('select[name="emp_gender"]').val(tableData.jenis_kelamin).trigger('change');
            $('input[name="emp_mobile"]').val(tableData.no_handphone);
            $('input[name="emp_email"]').val(tableData.email);
            $('input[name="emp_id"]').val(tableData.id);
            



            $('#modal-form-employee').modal('show');
        });

        $(table).find('tbody').on('click','.remove-data',function(){
            let id  = grid.row($(this).parents('tr')).data().id;

            $.confirm({
                title: "Hapus Karyawan",
                content:  "Apakah anda yakin ingin menghapus data karyawan ini?",
                type: 'red',
                buttons: {
                    remove: {
                        text:'Delete',
                        btnClass:"btn-danger",
                        action:function(){
                            $.alert({
                                type:'red',
                                buttons: {
                                    close: {
                                        btnClass:'btn-red'
                                    }
                                },
                                content: function(){
                                    var self = this;
                                    
                                    return $.ajax({
                                        url: $(table).attr('target')+"/api/employee/"+id,
                                        type: 'delete',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                            'Content-Type': 'application/json',
                                            'Authorization': "Bearer "+$('meta[name="user-jwt-token"]').attr('content'),
                                        },
                                        data: {

                                        },
                                        dataType:'json'
                                    })
                                    .done(function(res) {
                                        if(res.result){
                                            self.setContent('Berhasil menghapus data karyawan');
                                            self.setTitle("Berhasil");
                                            grid.ajax.reload();
                                        }else{
                                            self.setContent('Gagal menghapus data karyawan');
                                            self.setTitle("Gagal");
                                        }
                                        

                                    })
                                    .fail(function() {
                                        self.setContent('Terjadi kesalahan saat menghapus data karyawan');
                                    });
                                }
                            });
                        }
                    },
                    cancel: function () {

                    },
                }
            });
        });
    }

    var _saveNewEmployee = () => {

        $('#save-employee').html('<i class="fa fa-sync fa-spin" aria-hidden="true"></i> Loading . . .').attr('disabled','true').addClass('disabled');

        $('#employee-alert, #employee-info').hide();
        $('#employee-alert-text, #employee-info-text').html('');

        let formAction = $('[name="form_action"]').val();

        let id = $('#form-employee input[name="emp_id"]').val();;

        let url = $('#form-employee').attr('action');
        let method = "post";
        let formData = $('#form-employee').serialize();
        let targetUrl = '';

        if(formAction == 'ADD'){
            targetUrl = url+'/api/employee/'
            method = "post";
        }else{
            targetUrl = url+'/api/employee/'+id
            method = "put";
        }


        $.ajax({
            type: method,
            url: targetUrl,
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': "Bearer "+$('meta[name="user-jwt-token"]').attr('content'),
            },
            data: formData,
            dataType: "json",
            success: function (res) {
                
                if(res.result){
                    $('#modal-form-employee').modal('hide');
                    _clearForm();
                    $('#general-toast-text').html('Berhasil menyimpan data karyawan baru');
                    toast.show();
                    grid.ajax.reload();
                }else{
                    let msg = generalAlert('Terjadi Kesalahan', res.response.msg, 'danger');
                    $('#employee-alert-text').html(msg);
                    $('#employee-alert').show();
                }
            },
            error:function(xhr,error){
                if(xhr.responseJSON.errors){
                    let msg = generalAlert('Terjadi Kesalahan', xhr.responseJSON.message, 'danger');
                    $('#employee-alert-text').html(msg);
                    $('#employee-alert').show();
                }else{
                    let msg = generalAlert('Terjadi Kesalahan', 'Terjadi kesalahan saat menyimpan data karyawan', 'danger');
                    $('#employee-alert-text').html(msg);
                    $('#employee-alert').show();
                }
                
            },
            complete: function(){
                $('#save-employee').html('<i class="fa fa-check" aria-hidden="true"></i> Save').removeAttr('disabled').removeClass('disabled');
            }
        });


    }

    var _clearForm = () => {
        $('#form-employee input[type="text"]').val("");
        $('#form-employee input[name="emp_id"]').val("");
        $('#form-employee select').val('').trigger('change');
    }

    


    // Public Functions
    return {
        // public functions
        init: function() {

            _initComponent();
            _initGrid();

        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
	setTimeout(function(){
		employee.init();
	}, 100)
});