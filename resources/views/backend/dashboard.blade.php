@extends('backend.app')
@push('style')
    <link href="{{ asset('bell.css') }}" rel="stylesheet">
@endpush
@section('content')
@php
    @$data_user = Auth::user();
@endphp

<div class="row" style="margin-top: -200px;">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Dashboard</h3>
                <h6 class="font-weight-normal mb-0">Hi, {{ Auth::user()->name }}.
                    Welcome back to Aplikasi ASNBKL</h6>
            </div>
            @if (Auth::user()->role == 'Pegawai' && $dokumenBelumDiupload)
                <div class="col-lg-12 mt-3">
                    <div class="card">
                        <div class="card-body">
                            <i class="text-danger bi bi-exclamation-triangle"></i>
                            Anda belum mengupload dokumen <b>{{ $dokumenBelumDiupload }}</b>. Klik menu dokumen dan pilih
                            jenis dokumen yang ingin diupload.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection