@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-3">
        <div class="card text-bg-primary" style="height:120px;">
            <div class="card-body">
                <h5>Total Karyawan</h5>
                <h1 class="text-end">
                    {{ $totalEmployee }}
                </h1>
            </div>
        </div>
    </div>
</div>
    
@endsection