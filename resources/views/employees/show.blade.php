@extends('layouts.app')

@once
    @push('script')
        <script src="{{ asset('assets/custom/js/employee/show.js') }}"></script>
    @endpush
@endonce

@section('content')

    <div class="row mb-4">
        <div class="col">
            <a href="{{ route('app.employee') }}" class="btn btn-secondary"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Data Karyawan
                </div>
                <div class="card-body">
                    
                    <div class="row" id="information-block" target="{{ route('app.index') }}" data-id="{{ $id }}" style="display: none;">
                        <div class="col">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-4">
                                            Nama
                                        </div>
                                        <div class="col-1">:</div>
                                        <div class="col-6">          
                                            <span id="text-container-name"></span>                  
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-4">
                                            NIP
                                        </div>
                                        <div class="col-1">:</div>
                                        <div class="col-6">      
                                            <span id="text-container-nip"></span>                      
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-4">
                                            Tempat Lahir
                                        </div>
                                        <div class="col-1">:</div>
                                        <div class="col-6">         
                                            <span id="text-container-birth-place"></span>                   
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-4">
                                            Tanggal Lahir
                                        </div>
                                        <div class="col-1">:</div>
                                        <div class="col-6">          
                                            <span id="text-container-birth-date"></span>                  
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-4">
                                            Umur
                                        </div>
                                        <div class="col-1">:</div>
                                        <div class="col-6">    
                                            <span id="text-container-age"></span>                        
                                        </div>
                                    </div>
                                </li>
                                
                            </ul>
                        </div>
                        <div class="col">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-4">
                                            Agama
                                        </div>
                                        <div class="col-1">:</div>
                                        <div class="col-6">        
                                            <span id="text-container-religion"></span>                    
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-4">
                                            Jenis Kelamin
                                        </div>
                                        <div class="col-1">:</div>
                                        <div class="col-6">         
                                            <span id="text-container-gender"></span>                   
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-4">
                                            No. HP
                                        </div>
                                        <div class="col-1">:</div>
                                        <div class="col-6">       
                                            <span id="text-container-mobile"></span>                     
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-4">
                                            Email
                                        </div>
                                        <div class="col-1">:</div>
                                        <div class="col-6">             
                                            <span id="text-container-email"></span>               
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-4">
                                            Alamat
                                        </div>
                                        <div class="col-1">:</div>
                                        <div class="col-6">            
                                            <span id="text-container-address"></span>                
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row" id="loading-block">
                        <div class="col text-center">
                            <i class="fas fa-spinner fa-4x fa-spin" aria-hidden="true"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    
@endsection