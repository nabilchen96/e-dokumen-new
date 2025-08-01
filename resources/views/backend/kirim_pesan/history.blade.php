@extends('backend.app')
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 text-white">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Kirim Pesan</h3>
                    <h4>{{ @$skpd->nama_skpd ? 'Unor ' . $skpd->nama_skpd : '' }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-2">
            <!-- Wrapper untuk membuat scroll khusus tabel -->

            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('kirim-pesan') }}/?id_skpd={{ $skpd->id }}">
                                Kirim Pesan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ url('history-kirim-pesan') }}/?id_skpd={{ $skpd->id }}">
                                History Pesan
                            </a>
                        </li>
                    </ul>
                    

                    <table id="myTable" class="table table-striped" style="width: 100%;">
                        <thead class="bg-info text-white">
                            <tr>
                                <th width="5%">
                                    No
                                </th>
                                <th width="20%">Nama / No.Whatsapp</th>
                                <th width="30%">Pesan</th>
                                <th width="10%">Status</th>
                                <th width="5%">Tanggal Dibuat</th>
                                <th width="5%">Terakhir Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $k => $item)
                                <tr>
                                    <td>{{ $k+1 }}</td>
                                    <td>{{ $item->name }} <br> {{ $item->no_wa }} </td>
                                    <td>{{ $item->pesan }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $("#myTable").DataTable({})
    </script>
@endpush
