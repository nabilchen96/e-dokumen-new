@extends('backend.app')
@push('style')
    <style>
        #myTable_filter input {
            height: 29.67px !important;
        }

        #myTable_length select {
            height: 29.67px !important;
        }

        .btn {
            border-radius: 50px !important;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #9e9e9e21 !important;
        }

        td,
        th {
            font-size: 13.5px !important;
            /* padding: 5px !important; */
            /* white-space: nowrap !important; */
        }

        td {
            padding: 7px !important;
        }

        /* Mengatur ukuran dan margin panah sorting di DataTables */
        table.dataTable thead .sorting::after,
        table.dataTable thead .sorting_asc::after,
        table.dataTable thead .sorting_desc::after {
            margin-bottom: 5px !important;
            content: "▲" !important;
            top: 7px !important;
        }

        table.dataTable thead .sorting::before,
        table.dataTable thead .sorting_asc::before,
        table.dataTable thead .sorting_desc::before {
            margin-top: -5px !important;
            content: "▼" !important;
            bottom: 7px !important;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 0.375rem;
        }
    </style>
@endpush
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Statistik SIASN</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-2">
            <a style="border-radius: 8px !important;" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalimport">
                <i class="bi bi-file-earmark-excel"></i> Import
            </a> &nbsp;
            <a style="border-radius: 8px !important;" href="#" class="btn btn-danger btn-sm" id="deleteButton">
                <i class="bi bi-bug"></i> Hapus Data Import
            </a>
            <!-- Modal Import-->
            <div class="modal fade" id="modalimport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="importForm" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header p-3">
                                <h5 class="modal-title m-2" id="exampleModalLabel">SIASN Import Form</h5>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Import Excel <sup class="text-danger">*</sup> </label>
                                    <input name="file" id="file" type="file" class="form-control form-control-sm mb-2"
                                        required>
                                    <ul>
                                        <li>
                                            <span>Unduh format import SIASN <a
                                                    href="{{ asset('format_import_siasn_terbaru.xlsx') }}">Template
                                                    Import SIASN</a>
                                            </span><br>
                                        </li>
                                        <li>
                                            <span>Gunakan tipe data date pada kolom TANGGAL LAHIR (dd/mm/yyyy)</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="modal-footer p-3">
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                                <button id="importButton" class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 mt-3">
                    <a style="text-decoration: none;" href="{{ url('detail-statistik-pendidikan') }}?pendidikan=S-3/Doktor">
                        <div class="card shadow bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                                    class="card-img-absolute" alt="circle">
                                <h4 class="font-weight-normal mb-3">
                                    Lulusan S3
                                    <i class="bi bi-person-circle float-right"></i>
                                </h4>
                                <h2>
                                    {{ @$s3 ?? 0}}
                                </h2>
                                <span>Orang <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-lg-3 mt-3">
                    <a style="text-decoration: none;" href="{{ url('detail-statistik-pendidikan') }}?pendidikan=S-2">
                        <div class="card shadow bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                                    class="card-img-absolute" alt="circle">
                                <h4 class="font-weight-normal mb-3">
                                    Lulusan S2
                                    <i class="bi bi-person-circle float-right"></i>
                                </h4>
                                <h2>
                                    {{ @$s2 ?? 0}}
                                </h2>
                                <span>Orang <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 mt-3">
                    <a style="text-decoration: none;"
                        href="{{ url('detail-statistik-pendidikan') }}?pendidikan=S-1/Sarjana">
                        <div class="card shadow bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                                    class="card-img-absolute" alt="circle">
                                <h4 class="font-weight-normal mb-3">
                                    Lulusan S1
                                    <i class="bi bi-person-circle float-right"></i>
                                </h4>
                                <h2>
                                    {{ @$s1 ?? 0}}
                                </h2>
                                <span>Orang <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 mt-3">
                    <a style="text-decoration: none;" href="{{ url('detail-statistik-pendidikan') }}?pendidikan=Diploma IV">
                        <div class="card shadow bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                                    class="card-img-absolute" alt="circle">
                                <h4 class="font-weight-normal mb-3">
                                    Lulusan DIV
                                    <i class="bi bi-person-circle float-right"></i>
                                </h4>
                                <h2>
                                    {{ @$d4 ?? 0}}
                                </h2>
                                <span>Orang <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 mt-3">
                    <a style="text-decoration: none;"
                        href="{{ url('detail-statistik-pendidikan') }}?pendidikan=Diploma III/Sarjana Muda">
                        <div class="card shadow bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                                    class="card-img-absolute" alt="circle">
                                <h4 class="font-weight-normal mb-3">
                                    Lulusan DIII
                                    <i class="bi bi-person-circle float-right"></i>
                                </h4>
                                <h2>
                                    {{ @$d3 ?? 0}}
                                </h2>
                                <span>Orang <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-lg-3 mt-3">
                    <a style="text-decoration: none;" href="{{ url('detail-statistik-pendidikan') }}?pendidikan=Diploma II">
                        <div class="card shadow bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                                    class="card-img-absolute" alt="circle">
                                <h4 class="font-weight-normal mb-3">
                                    Lulusan DII
                                    <i class="bi bi-person-circle float-right"></i>
                                </h4>
                                <h2>
                                    {{ @$d2 ?? 0}}
                                </h2>
                                <span>Orang <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 mt-3">
                    <a style="text-decoration: none;" href="{{ url('detail-statistik-pendidikan') }}?pendidikan=Diploma I">
                        <div class="card shadow bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                                    class="card-img-absolute" alt="circle">
                                <h4 class="font-weight-normal mb-3">
                                    Lulusan DI
                                    <i class="bi bi-person-circle float-right"></i>
                                </h4>
                                <h2>
                                    {{ @$d1 ?? 0}}
                                </h2>
                                <span>Orang <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>

                </div>
                <div class="col-lg-3 mt-3">
                    <a style="text-decoration: none;" href="{{ url('detail-statistik-pendidikan') }}?pendidikan=SMA">
                        <div class="card shadow bg-gradient-info card-img-holder text-white">
                            <div class="card-body">
                                <img src="https://themewagon.github.io/purple-react/static/media/circle.953c9ca0.svg"
                                    class="card-img-absolute" alt="circle">
                                <h4 class="font-weight-normal mb-3">
                                    Lulusan SMA
                                    <i class="bi bi-person-circle float-right"></i>
                                </h4>
                                <h2>
                                    {{ @$sma ?? 0 }}
                                </h2>
                                <span>Orang <i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <div id="jenisKelamin"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <div id="jenisJabatan"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <div id="container"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <div id="pangkat"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <div id="umur"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="mt-4">Distribusi SKPD</h3>
                    <p class="mb-4">Total Pegawai ASN Berdasarkan SKPD</p>
                    <table id="myTable" class="table table-striped display" style="width:100%">
                        <thead class="bg-info text-white">
                            <tr>
                                <th>No</th>
                                <th>SKPD</th>
                                <th>Laki-laki</th>
                                <th>Perempuan</th>
                                <th>Total</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script>
        axios.get('/data-pendidikan')
            .then(response => {
                const rawData = response.data;

                const categories = rawData.map(item => {
                    return item.tingkat_pendidikan == null ? 'Belum Isi' : item.tingkat_pendidikan;
                });
                const dataLaki = rawData.map(item => Number(item.laki_laki));
                const dataPerempuan = rawData.map(item => Number(item.perempuan));

                console.log(dataLaki);


                Highcharts.chart('container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Distribusi Pendidikan'
                    },
                    subtitle: {
                        text: 'Total Pegawai ASN Berdasarkan Pendidikan'
                    },
                    xAxis: {
                        categories: categories,
                        title: {
                            text: 'Tingkat Pendidikan'
                        }
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah Orang'
                        },
                        stackLabels: {
                            enabled: true,
                            style: {
                                fontWeight: 'bold'
                            }
                        }
                    },
                    legend: {
                        reversed: false
                    },
                    plotOptions: {
                        column: {
                            stacking: 'normal',
                        }
                    },
                    series: [
                        {
                            name: 'Laki-laki',
                            data: dataLaki,
                        },
                        {
                            name: 'Perempuan',
                            data: dataPerempuan,
                        }
                    ]
                });
            })
            .catch(error => {
                console.error('Gagal mengambil data chart:', error);
            });
    </script>
    <script>
        axios.get('/data-jenis-kelamin')
            .then(response => {
                const rawData = response.data;

                const dataPie = rawData.map(item => {
                    let label = item.jenis_kelamin
                    return {
                        name: label,
                        y: parseInt(item.total)
                    };
                });

                Highcharts.chart('jenisKelamin', {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: 'Distribusi Jenis Kelamin'
                    },
                    subtitle: {
                        text: 'Total Pegawai ASN Berdasarkan Jenis Kelamin'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y} orang)'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.y} ({point.percentage:.1f}%)'
                            },
                        }
                    },
                    series: [{
                        name: 'Persentase',
                        colorByPoint: true,
                        data: dataPie
                    }]
                });
            })
            .catch(error => {
                console.error('Gagal memuat data pie chart:', error);
            });
    </script>
    <script>
        axios.get('/data-jenis-jabatan')
            .then(response => {
                const rawData = response.data;

                const dataPie = rawData.map(item => {
                    let label = ''; // deklarasi di awal

                    if (item.jenis_jabatan != null) {
                        const words = item.jenis_jabatan.split(' ');
                        label = words[1] || words[0]; // kata kedua, fallback ke pertama
                    } else {
                        label = 'Lainnya'; // default jika null
                    }

                    return {
                        name: label,
                        y: parseInt(item.total)
                    };
                });

                Highcharts.chart('jenisJabatan', {
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: 'Distribusi Jenis Jabatan'
                    },
                    subtitle: {
                        text: 'Total Pegawai ASN Berdasarkan Jenis Jabatan'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> ({point.y} orang)'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.y} ({point.percentage:.1f}%)'
                            },
                        }
                    },
                    series: [{
                        name: 'Persentase',
                        colorByPoint: true,
                        data: dataPie
                    }]
                });
            })
            .catch(error => {
                console.error('Gagal memuat data pie chart:', error);
            });
    </script>
    <script>
        axios.get('/data-pangkat')
            .then(response => {
                const rawData = response.data;

                const categories = rawData.map(item => {


                    let label = ''; // deklarasi di awal

                    if (item.pangkat != null) {
                        const words = item.pangkat.split(' - ');
                        label = words[0]; // kata kedua, fallback ke pertama
                    } else {
                        label = 'Belum Isi'; // default jika null
                    }

                    return label;

                });
                const dataLaki = rawData.map(item => Number(item.laki_laki));
                const dataPerempuan = rawData.map(item => Number(item.perempuan));


                Highcharts.chart('pangkat', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Distribusi Pangkat'
                    },
                    subtitle: {
                        text: 'Total Pegawai ASN Berdasarkan Pangkat'
                    },
                    xAxis: {
                        categories: categories,

                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah Orang'
                        },
                        stackLabels: {
                            enabled: true,
                            style: {
                                fontWeight: 'bold'
                            }
                        }
                    },
                    legend: {
                        reversed: false
                    },
                    plotOptions: {
                        column: {
                            stacking: 'normal',
                        }
                    },
                    series: [
                        {
                            name: 'Laki-laki',
                            data: dataLaki,
                        },
                        {
                            name: 'Perempuan',
                            data: dataPerempuan,
                        }
                    ]
                });
            })
            .catch(error => {
                console.error('Gagal mengambil data chart:', error);
            });
    </script>
    <script>
        axios.get('/data-statistik-umur')
            .then(response => {
                const rawData = response.data;

                const categories = rawData.map(item => {
                    return item.umur;
                });
                const dataLaki = rawData.map(item => Number(item.laki_laki));
                const dataPerempuan = rawData.map(item => Number(item.perempuan));

                console.log(dataLaki);


                Highcharts.chart('umur', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Distribusi Umur'
                    },
                    subtitle: {
                        text: 'Total Pegawai ASN Berdasarkan Umur'
                    },
                    xAxis: {
                        categories: categories,

                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Jumlah Orang'
                        },
                        stackLabels: {
                            enabled: true,
                            style: {
                                fontWeight: 'bold'
                            }
                        }
                    },
                    legend: {
                        reversed: false
                    },
                    plotOptions: {
                        column: {
                            stacking: 'normal',
                            point: {
                                events: {
                                    click: function () {
                                        // Gantilah URL sesuai kebutuhan Anda
                                        const umur = this.category; // Kategori umur
                                        window.location.href = `/detail-statistik-umur?umur=${umur}`; // URL berdasarkan umur yang diklik
                                    }
                                }
                            }
                        }
                    },
                    series: [
                        {
                            name: 'Laki-laki',
                            data: dataLaki,
                        },
                        {
                            name: 'Perempuan',
                            data: dataPerempuan,
                        }
                    ]
                });
            })
            .catch(error => {
                console.error('Gagal mengambil data chart:', error);
            });
    </script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                ajax: {
                    url: '/data-statistik-skpd',
                    dataSrc: ''
                },
                pageLength: 100,
                columns: [
                    {
                        data: null,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'nama_skpd' },
                    { data: 'laki_laki' },
                    { data: 'perempuan' },
                    {
                        render: function (data, type, row) {
                            return Number(row.laki_laki) + Number(row.perempuan);
                        }
                    },
                    {
                        render: function (data, type, row) {
                            return `<a href="/detail-statistik-skpd?nama_skpd=${row.nama_skpd}">
                                        <button style="border-radius: 8px !important;" class="btn btn-primary">Detail</button>
                                    </a>`;
                        }
                    }
                ]
            });
        });
    </script>
    <script>
        document.getElementById('importForm').addEventListener('submit', function (event) {
            event.preventDefault();  // Mencegah reload halaman
            let formData = new FormData(this);  // Mengambil data form

            // Tampilkan SweetAlert proses loading
            Swal.fire({
                title: 'Sedang memproses data...',
                text: 'Mohon menunggu sesaat',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            axios.post('/import-siasn', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
            })
                .then(response => {
                    Swal.close(); // tutup loading jika berhasil
                    const data = response.data;

                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: `${data.message}`,
                        showConfirmButton: true
                    }).then(() => {
                        // Reload saat tombol OK ditekan
                        location.reload();
                    });
                })
                .catch(error => {

                    Swal.close(); // pastikan loading ditutup saat error

                    // Tampilkan error berdasarkan jenisnya
                    let errorMessage = 'Terjadi kesalahan saat mengimpor data.';
                    if (error.code === 'ECONNABORTED') {
                        errorMessage = 'Waktu proses melebihi batas. Silakan coba lagi atau cek ukuran data.';
                    } else if (error.response) {
                        errorMessage = `Server error: ${error}`;
                    } else if (error.request) {
                        errorMessage = 'Tidak ada respon dari server.';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: errorMessage
                    });
                });
        });

    </script>
    <script>
        document.getElementById('deleteButton').addEventListener('click', function (e) {
            e.preventDefault(); // Mencegah redirect langsung

            // Menampilkan SweetAlert konfirmasi
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengonfirmasi, maka arahkan ke URL untuk menghapus data
                    window.location.href = '{{ url('hapus-data-import') }}';
                }
            });
        });
    </script>
@endpush