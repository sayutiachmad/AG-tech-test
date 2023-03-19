@extends('layouts.app')

@once
    @push('script')
        <script src="{{ asset('assets/custom/js/employee/employee.js') }}"></script>
    @endpush
@endonce

@section('content')
    <div class="row">
        <div class="col">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title">Data Karyawan</h5>
                        </div>
                        
                        <div class="card-toolbar">
                            <a href="javascript:;" class="btn btn-primary btm-sm py-0" id="new-employee"><i class="fa fa-plus" aria-hidden="true"></i> Karyawan Baru</a>
                        </div>
                    </div>
                    
                </div>
                <div class="card-body ">
                    
                    <form action="" id="fl-form">
                        <div class="row mb-3 p-3">
                            <h5 class="card-title mb-2">Filter</h5>
                       
                            <div class="col-3 mb-3">
                                <label for="" class="form-label">Nama</label>
                                <input type="text" class="form-control" placeholder="Nama" name="fl_name" id="fl-name">
                            </div>
                            <div class="col-3 mb-3">
                                <label for="" class="form-label">NIP</label>
                                <input type="text" class="form-control" placeholder="NIP" name="fl_nip" id="fl-nip">
                            </div>
                            <div class="col-3 mb-3">
                                <label for="" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control" placeholder="Tempat Lahir" name="fl_birth_place" id="fl-birth-place">
                            </div>
                            <div class="col-3 mb-3">
                                <label for="" class="form-label">Tanggal Lahir</label>
                                <input type="text" class="form-control datepicker" placeholder="Tanggal Lahir" name="fl_birth_date" id="fl-birth-date" style="padding: .375rem .75rem">
                            </div>
                            <div class="col-2 mb-3">
                                <label for="" class="form-label">Umur</label>
                                <input type="text" class="form-control" placeholder="Umur" name="fl_age" id="fl-age">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">Alamat</label>
                                <input type="text" class="form-control" placeholder="Alamat" name="fl_adress" id="fl-address">
                            </div>
                            <div class="col-4 mb-3">
                                <label for="" class="form-label">Agama</label>
                                <select name="fl_religion" id="fl-religion" class="form-select">
                                    <option value="ALL" selected>Semua</option>
                                    <option value="I">Islam</option>
                                    <option value="KP">Kristen Protestan</option>
                                    <option value="KK">Kristen Katolik</option>
                                    <option value="H">Hindu</option>
                                    <option value="B">Budha</option>
                                    <option value="KH">Konghucu</option>
                                    <option value="O">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-2 mb-3">
                                <label for="" class="form-label">Jenis Kelamin</label>
                                <select name="fl_gender" id="fl-gender" class="form-select">
                                    <option value="ALL" selected>Semua</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="" class="form-label">No. HP</label>
                                <input type="text" class="form-control" placeholder="No. HP" name="fl_mobile" id="fl-mobile">
                            </div>
                            <div class="col-3 mb-3">
                                <label for="" class="form-label">Email</label>
                                <input type="text" class="form-control" placeholder="Email" name="fl_email" id="fl-email">
                            </div>
                            <div class="col-3 mb-3">
                                <button type="submit" class="btn btn-success" style="margin-top:2em;" id="fl-btn"><i class="fa fa-filter" aria-hidden="true"></i> Filter Data</button>
                            </div>
                        </div>
                    </form>

                    <div class="row p-3">
                        <table class="table table-bordered table-hover table-striped table-sm" id="tbl-employee" style="width: 100%;" target="{{ route('app.index') }}">
                            <thead>
                                <th>No.</th>
                                <th>Option</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Tempat Lahir</th>
                                <th>Tgl Lahir</th>
                                <th>Umur</th>
                                <th>Alamat</th>
                                <th>Agama</th>
                                <th>Jenis Kelamin</th>
                                <th>No. Hp</th>
                                <th>Email</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal-form-employee" tabindex="-1" aria-labelledby="modal-form-employee-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="modal-employe-label-title">Data Karyawan Baru</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="{{ route('app.index') }}" method="post" id="form-employee">
            @csrf
            <div class="modal-body">

                <div class="row p-2">
                    <div id="employee-alert" style="display:none;">
                        <span id="employee-alert-text"></span>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" placeholder="Nama" name="emp_name" id="emp-name" required autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIP</label>
                        <input type="text" class="form-control" placeholder="NIP" name="emp_nip" id="emp-nip" required autocomplete="off">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" placeholder="Tempat Lahir" name="emp_birth_place" id="emp-birth_place" required autocomplete="off">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tangal Lahir</label>
                        <input type="text" class="form-control datepicker" placeholder="Tanggal Lahir" name="emp_birth_date" id="emp-birth-date" style="padding:.375rem .75rem;" required autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Umur</label>
                        <input type="text" class="form-control" placeholder="Umur" name="emp_age" id="emp-age" readonly autocomplete="off">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" placeholder="Alamat" name="emp_address" id="emp-address">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Agama</label>
                        <select name="emp_religion" id="emp-religion" class="form-select">
                            <option value="" selected disabled>Pilih Agama</option>
                            <option value="I" >Islam</option>
                            <option value="KP" >Kristen Protestan</option>
                            <option value="KK" >Kristen Katolik</option>
                            <option value="H" >Hindu</option>
                            <option value="B" >Budha</option>
                            <option value="KH" >Konghucu</option>
                            <option value="O" >Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Jenis Kelamin</label>
                        <select name="emp_gender" id="emp-gender" class="form-select">
                            <option value="" selected disabled>Pilih Jenis Kelamin</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">No. HP</label>
                        <input type="text" class="form-control" placeholder="No. HP" name="emp_mobile" id="emp-mobile" required autocomplete="off">
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Email</label>
                        <input type="text" class="form-control" placeholder="Email" name="emp_email" id="emp-email" required autocomplete="off">
                    </div>

                    <input type="hidden" name="form_action" value="ADD">
                    <input type="hidden" name="emp_id" value="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="save-employee"><i class="fa fa-check" aria-hidden="true"></i> Save</button>
            </div>
        </form>
        </div>
    </div>
    </div>

    <div class="toast-container position-fixed bottom-0 top-0 end-0 p-3">
        <div id="general-toast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <span id="general-toast-text"></span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection