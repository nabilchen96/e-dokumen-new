@extends('backend.app')
@section('content')
<div class="row" style="margin-top: -200px;">
    <div class="col-md-12 text-white">
        <div class="row">
            <div class="col-12 col-xl-8 mb-xl-0">
                <h3 class="font-weight-bold">Data Shift</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-4">
        <div class="card w-100">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="table table-striped" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Shift</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Mulai Scan Masuk</th>
                                <th>Akhir Scan Masuk</th>
                                <th>Mulai Scan Pulang</th>
                                <th>Akhir Scan Pulang</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('script')
    <script>
        window.userRole = "{{ Auth::user()->role }}";
    </script>
    <script src="{{ asset('js/backend/shift/index.js') }}"></script>
@endpush