@extends('backend.app')
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 text-white">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">API</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-12 mt-4">
            <div class="card w-100">
                <!-- resources/views/api-tester.blade.php -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <h3 class="mb-4">Daftar API</h3>
                            <hr>
                            <ul class="list-group" style="max-height: 700px; overflow-y: auto;">
                                <li class="list-group-item">
                                    DATA PROFIL
                                </li>
                                <li class="list-group-item">
                                    &nbsp; &nbsp; <i class="bi bi-arrow-return-right"></i> GET DATA PROFIL
                                </li>
                                <li class="list-group-item">
                                    DATA JENIS DOKUMEN
                                </li>
                                <li class="list-group-item">
                                    &nbsp; &nbsp; <i class="bi bi-arrow-return-right"></i> GET DATA JENIS DOKUMEN
                                </li>
                                <li class="list-group-item">
                                    DATA SKPD
                                </li>
                                <li class="list-group-item">
                                    &nbsp; &nbsp; <i class="bi bi-arrow-return-right"></i> GET DATA SKPD
                                </li>
                                <li class="list-group-item">
                                    DATA UNIT KERJA
                                </li>
                                <li class="list-group-item">
                                    &nbsp; &nbsp; <i class="bi bi-arrow-return-right"></i> GET DATA UNIT KERJA
                                </li>
                                <li class="list-group-item">
                                    DATA INSTANSI
                                </li>
                                <li class="list-group-item">
                                    &nbsp; &nbsp; <i class="bi bi-arrow-return-right"></i> GET DATA INSTANSI
                                </li>
                                <li class="list-group-item">
                                    DATA INFORMASI
                                </li>
                                <li class="list-group-item">
                                    &nbsp; &nbsp; <i class="bi bi-arrow-return-right"></i> GET DATA INFORMASI
                                </li>
                                <li class="list-group-item">
                                    DATA DOKUMEN
                                </li>
                                <li class="list-group-item">
                                    &nbsp; &nbsp; <i class="bi bi-arrow-return-right"></i> GET DATA DOKUMEN
                                </li>
                                <li class="list-group-item">
                                    DATA KENAIKAN GAJI
                                </li>
                                <li class="list-group-item">
                                    &nbsp; &nbsp; <i class="bi bi-arrow-return-right"></i> GET DATA KENAIKAN GAJI
                                </li>
                            </ul>

                        </div>
                        <div class="col-lg-8">
                            <h3 class="mb-4">Get Data Profil</h3>
                            <hr>
                            <form id="apiForm">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label style="font-size: 16px;">Method</label>
                                            <select name="method" id="method" class="form-control form-control-sm">
                                                <option value="GET">GET</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label style="font-size: 16px;">Endpoint</label>
                                            <input class="form-control form-control-sm" type="text" id="endpoint"
                                                value="http://127.0.0.1:8000/api/profil?limit=5" style="width: 100%;">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label style="font-size: 16px; color: white;">Endpoint</label>
                                            <button class="w-100 btn btn-primary btn-sm"
                                                style="border-radius: 5px !important;" type="submit">
                                                Send
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <b>Response</b>
                            <pre class="mt-2" id="response" style="max-height:600px; overflow-y:auto; background:#f2f2f2; padding:10px;">Response</pre>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.getElementById('apiForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const method = document.getElementById('method').value;
            const url = document.getElementById('endpoint').value;

            document.getElementById('response').textContent = "Loading...";

            fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: null
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('response').textContent = JSON.stringify(data, null, 4);
                })
                .catch(err => {
                    document.getElementById('response').textContent = "Error: " + err;
                });
        });
    </script>
@endpush
