@extends('backend.app')
@push('style')
    <style>

        .dataTables_wrapper {
            overflow-x: auto;
        }
    </style>
@endpush
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 text-white text-white">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Data
                        {{ $jenis = DB::table('jenis_dokumens')->where('id', Request('jenis_dokumen'))->value('jenis_dokumen') }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <div class="card w-100">
                <div class="card-body">
                    <button type="button" class="btn btn-primary btn-sm mb-4" data-toggle="modal" data-target="#modal">
                        Tambah
                    </button>
                    <div class="table-responsive" style="overflow-x:auto;">
                        <table id="myTable" class="display nowrap table table-striped" style="width: 100%;">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Pemilik</th>
                                    <th>Jenis / No. Dokumen</th>
                                    <th>Tanggal Berlaku</th>
                                    <th>Tanggal Upload</th>
                                    <th>Unor Induk / Unor
                                    </th>
                                    <th>Status</th>
                                    <th>Alasan Ditolak / Arahan </th>
                                    <th width="5%">PDF</th>
                                    <th width="5%">Edit</th>
                                    <th width="5%">Hapus</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2" id="exampleModalLabel">Dokumen Form</h5>
                    </div>
                    @php
                        $variations = [
                            'dokumen berkala',
                            'Dokumen Berkala',
                            'Dokumen berkala',
                            'dokumen Berkala',
                            'DOKUMEN BERKALA',
                            'dok. berkala',
                            'dok berkala',
                            'Dok. Berkala',
                            'Dok Berkala',
                            'DOK. BERKALA',
                            'DOK BERKALA',
                            'dokumenberkala',
                            'DokumenBerkala',
                            'DOKUMENBERKALA',
                            'Dokumenberkala',
                            'dokumenBerkala',
                            'Kenaikan Gaji',
                            'Kenaikan gaji',
                            'kenaikan Gaji',
                            'kenaikangaji',
                            'KenaikanGaji',
                            'Kenaikangaji',
                            'kenaikanGaji',
                            'KENAIKAN GAJI',
                            'KENAIKANGAJI',
                            'SK Gaji Berkala',
                        ];

                        $kenaikan_gaji = DB::table('jenis_dokumens')->where('id', Request('jenis_dokumen'))->first();
                    @endphp
                    <div class="modal-body">
                        <div id="respon_error" class="text-danger mb-4"></div>
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="id_dokumen" id="id_dokumen" value="{{ Request('jenis_dokumen') }}">
                        <div class="form-group">
                            <label>Dokumen <sup class="text-danger">*</sup></label>
                            <input name="dokumen" id="dokumen" type="file" placeholder="Dokumen"
                                class="form-control form-control-sm" accept=".pdf, image/*">
                        </div>
                        <div class="form-group">
                            <label>Jenis Dokumen</label>
                            <input type="text" placeholder="Dokumen" value="{{ $jenis }}"
                                class="form-control form-control-sm" required readonly>
                        </div>
                        @if ($kenaikan_gaji->punya_nomor_dokumen == 'Ya')
                            <div class="form-group">
                                <label>Nomor Dokumen <sup class="text-danger">*</sup></label>
                                <input type="text" name="nomor_dokumen" id="nomor_dokumen" placeholder="nomor_dokumen"
                                    class="form-control form-control-sm" required>
                            </div>
                        @endif
                        @if (Str::contains(Str::lower($kenaikan_gaji->jenis_dokumen), 'gaji'))
                            <div class="form-group">
                                <label>Jenis Dokumen Berkala <sup class="text-danger">*</sup></label>
                                <select name="jenis_dokumen_berkala" id="jenis_dokumen_berkala"
                                    class="form-control form-control-sm" required>
                                    <option>Kenaikan Gaji</option>
                                    <option>Lainnya</option>
                                </select>
                            </div>
                        @endif


                        <div class="form-group">
                            <label>Tanggal Awal Dokumen <sup class="text-danger">*</sup></label>
                            <input type="date" placeholder="Tanggal Awal Dokumen" id="tanggal_dokumen"
                                name="tanggal_dokumen" class="form-control form-control-sm" required>
                            <small class="text-danger">*Untuk SK CPNS/PNS/P3K/Kenaikan Gaji Berkala/Kenaikan Pangkat/Jabatan
                                gunakan tanggal TMT</small>
                        </div>

                        @if ($kenaikan_gaji->punya_tgl_akhir == 'Ya')
                            <div class="form-group">
                                <label>Tanggal Akhir Dokumen <sup class="text-danger">*</sup></label>
                                <input type="date" placeholder="Tanggal Akhir Dokumen" id="tanggal_akhir_dokumen"
                                    name="tanggal_akhir_dokumen" class="form-control form-control-sm">
                                <small class="text-danger">*Untuk Tanggal Akhir SK Kenaikan Gaji Berkala di isi dengan
                                    tanggal pengajuan selanjutnya pada SK Kenaikan Gaji Berkala yang di Upload</small>
                            </div>
                        @endif
                        <div class="form-group">
                            <label>Pemilik <sup class="text-danger">*</sup></label>
                            @php
                                if (Auth::user()->role == 'Admin') {
                                    $users = DB::table('users')
                                            ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
                                            ->select('users.id', 'users.name', 'profils.nip')
                                            ->get();

                                } elseif (Auth::user()->role == 'SKPD') {
                                    $users = DB::table('dokumens')
                                            ->leftJoin('users', 'users.id', '=', 'dokumens.id_user')
                                            ->leftJoin('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
                                            ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
                                            ->select('users.id', 'users.name', 'profils.nip')
                                            ->where('dokumens.id_skpd', Auth::user()->id_skpd)
                                            ->groupBy('users.id')
                                            ->get();
                                } elseif (Auth::user()->role == 'OPD') {
                                    $users = DB::table('dokumens')
                                            ->leftJoin('users', 'users.id', '=', 'dokumens.id_user')
                                            ->leftJoin('unit_kerjas', 'unit_kerjas.id', '=', 'dokumens.id_unit_kerja')
                                            ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
                                            ->select('users.id', 'users.name', 'profils.nip')
                                            ->where('dokumens.id_unit_kerja', Auth::user()->id_unit_kerja)
                                            ->groupBy('users.id')
                                            ->get();
                                } else {
                                    $users = DB::table('users')
                                            ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
                                            ->select('users.id', 'users.name', 'profils.nip')
                                            ->where('users.id', Auth::id())
                                            ->get();
                                }
                            @endphp
                            <select name="id_user" id="id_user" required>
                                @foreach ($users as $item)
                                    <option value="">PILIH PEMILIK DOKUMEN</option>
                                    <option value="{{ $item->id }}">{{ $item->name }} NIP: {{ $item->nip }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Unit Organisasi Induk<sup class="text-danger">*</sup></label>
                            @php
                                $skpd = DB::table('skpds')->get();
                            @endphp
                            <select name="id_skpd" id="id_skpd" class="form-control"
                                {{ Auth::user()->role == 'Admin' ? '' : 'required' }}>
                                <option value="">PILIH UNIT ORGANISASI INDUK</option>
                                @foreach ($skpd as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_skpd }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Unit Organisasi <sup class="text-danger">*</sup></label>
                            <select name="id_unit_kerja" id="id_unit_kerja" class="form-control"
                                {{ Auth::user()->role == 'Admin' ? '' : 'required' }}>
                                <option value="">PILIH UNIT ORGANISASI</option>
                            </select>
                        </div>
                        @if (Auth::user()->role != 'Pegawai')
                            <div class="form-group">
                                <label>Status Dokumen</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">--PILIH STATUS--</option>
                                    <option>Sedang Dalam Pengecekan</option>
                                    <option>Dokumen Diterima</option>
                                    <option>Perlu Diperbaiki</option>
                                </select>
                            </div>
                            <div class="form-group mt-3" id="alasan_wrapper" style="display: none;">
                                <label>Alasan Perbaikan / Arahan<sup class="text-danger">*</sup></label>
                                <textarea name="alasan_ditolak" id="alasan_ditolak" class="form-control" rows="3"
                                    placeholder="Masukkan alasan penolakan atau arahan ..."></textarea>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer p-3">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        <button id="tombol_kirim" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            getData()
            // new TomSelect('#id_user');
            tomSelectUser = new TomSelect('#id_user');
        })


        function getData() {

            // Mendapatkan query string dari URL
            let params = new URLSearchParams(window.location.search);

            // Mendapatkan nilai parameter
            let jenis_dokumen = params.get('jenis_dokumen'); // "John"

            $("#myTable").DataTable({
                scrollX: true,
                "ordering": true,
                ajax: '/data-file-dokumen?jenis_dokumen=' + jenis_dokumen,
                processing: true,
                'language': {
                    'loadingRecords': '&nbsp;',
                    'processing': 'Loading...'
                },
                columnDefs: [{
                        orderable: false,
                        targets: [7, 8, 9]
                    } // Kolom ke-0 dan ke-2 tidak bisa di-sort
                ],
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `${row.name}<br><b>${row.nip}</b>`
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `${row.jenis_dokumen}
                                ${row.nomor_dokumen ? '<br> <b>No. '+row.nomor_dokumen+'</b>' : '<br> <b>No. -</b>'} <br>
                                ${row.jenis_dokumen_berkala ?? `Lainnya`}`
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `<b>Tanggal Awal:</b><br> ${row.tanggal_dokumen} <br> <b>Tanggal Akhir:</b><br> ${row.tanggal_akhir_dokumen ?? '-'}`
                        }
                    },
                    {
                        data: "created_at"
                    },
                    {
                        width: '300px',
                        targets: 5,
                        render: function(data, type, row, meta) {
                            return `
                                <div style="white-space: normal; width: 300px; overflow-wrap: break-word;">
                                    <strong>Unor Induk:</strong> ${row.nama_skpd}
                                </div>
                                <div style="white-space: normal; width: 300px; overflow-wrap: break-word;">
                                    <strong>Unor:</strong> ${row.unit_kerja ?? `-`}
                                </div>
                            `
                        }
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `${row.status ?? 'Belum Diperiksa'}
                            <br> <span style="display: none;">${row.dokumen}</span>`
                        }
                    },
                    {
                        data: 'alasan_ditolak'
                    },
                    {
                        render: function(data, type, row, meta) {
                            return `<a target="_blank" href="/convert-to-pdf/${row.dokumen}">
                        <i style="font-size: 1.5rem;" class="text-danger bi bi-file-earmark-pdf"></i>
                        </a>`
                                            }
                                        },
                                        {
                                            render: function(data, type, row, meta) {
                                                return `<a data-toggle="modal" data-target="#modal" data-bs-id=` + (row.id) + ` href="javascript:void(0)">
                            <i style="font-size: 1.5rem;" class="text-success bi bi-grid"></i>
                        </a>`
                                            }
                                        },
                                        {
                                            render: function(data, type, row, meta) {
                                                return `<a href="javascript:void(0)" onclick="hapusData(` + (row
                                                    .id) + `)">
                            <i style="font-size: 1.5rem;" class="text-danger bi bi-trash"></i>
                        </a>`
                        }
                    },
                ]
            })
        }

        $('#modal').on('show.bs.modal', function(event) {

            $(document).on('change', '#status', function () {
                const alasanWrapper = document.getElementById('alasan_wrapper');
                const alasanTextarea = document.getElementById('alasan_ditolak');

                if (this.value === 'Perlu Diperbaiki') {
                    alasanWrapper.style.display = 'block';
                    alasanTextarea.setAttribute('required', 'required');
                } else {
                    alasanWrapper.style.display = 'none';
                    alasanTextarea.removeAttribute('required');
                    alasanTextarea.value = '';
                }
            });

            const statusSelect = document.getElementById('status');
            const alasanWrapper = document.getElementById('alasan_wrapper');
            const alasanTextarea = document.getElementById('alasan_ditolak');

            // console.log('tes');
            

            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var recipient = button.data('bs-id'); // Ambil ID dari data-bs-id
            var cok = $("#myTable").DataTable().rows().data().toArray();

            let cokData = cok.find((dt) => dt.id == recipient);

            // Reset form dan error
            const form = document.getElementById("form");
            if (form) form.reset();

            $('#id').val('');
            $('.error').empty();

            if (recipient && cokData) {
                var modal = $(this);

                modal.find('#id').val(cokData.id);
                modal.find('#id_user').val(cokData.id_user);
                modal.find('#jenis_dokumen').val(cokData.jenis_dokumen);
                modal.find('#status').val(cokData.status);
                modal.find('#tanggal_dokumen').val(cokData.tanggal_dokumen);
                modal.find('#tanggal_akhir_dokumen').val(cokData.tanggal_akhir_dokumen);
                tomSelectUser.setValue(cokData.id_user);
                modal.find('#id_skpd').val(cokData.id_skpd);

                // Tampilkan alasan jika perlu
                if (alasanWrapper && alasanTextarea) {
                    if (cokData.status === 'Perlu Diperbaiki') {
                        alasanWrapper.style.display = 'block';
                        alasanTextarea.setAttribute('required', 'required');
                    } else {
                        alasanWrapper.style.display = 'none';
                        alasanTextarea.removeAttribute('required');
                        alasanTextarea.value = '';
                    }

                    modal.find('#alasan_ditolak').val(cokData.alasan_ditolak);
                }

                // Isi unit kerja berdasarkan skpd
                const skpdId = cokData.id_skpd;
                const unitKerjaSelect = document.getElementById('id_unit_kerja');
                if (unitKerjaSelect) {
                    unitKerjaSelect.innerHTML = '<option value="">Memuat data...</option>';

                    axios.get(`/data-unit-kerja/${skpdId}`)
                        .then(response => {
                            const data = response.data;
                            unitKerjaSelect.innerHTML = '<option value="">PILIH UNIT KERJA</option>';

                            data.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.id;
                                option.textContent = item.unit_kerja;
                                unitKerjaSelect.appendChild(option);
                            });

                            modal.find('#id_unit_kerja').val(cokData.id_unit_kerja);
                        })
                        .catch(error => {
                            console.error('Error fetching unit kerja:', error);
                            unitKerjaSelect.innerHTML = '<option value="">PILIH UNIT ORGANISASI</option>';
                        });
                }
            }
        });


        form.onsubmit = (e) => {

            // pastikan form valid
            const alasanWrapper = document.getElementById('alasan_wrapper');
            const alasanTextarea = document.getElementById('alasan_ditolak');

            if (alasanWrapper && alasanWrapper.style.display === 'none') {
                alasanTextarea.removeAttribute('required');
            }

            let formData = new FormData(form);

            document.getElementById('respon_error').innerHTML = ``

            e.preventDefault();

            document.getElementById("tombol_kirim").disabled = true;

            axios({
                    method: 'post',
                    url: formData.get('id') == '' ? '/store-file-dokumen' : '/update-file-dokumen',
                    data: formData,
                })
                .then(function(res) {
                    //handle success
                    if (res.data.responCode == 1) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: res.data.respon,
                            timer: 3000,
                            showConfirmButton: false
                        })

                        location.reload('/file-dokumen')

                    } else {
                        //respon
                        let respon_error = ``
                        Object.entries(res.data.respon).forEach(([field, messages]) => {
                            messages.forEach(message => {
                                respon_error += `<li>${message}</li>`;
                            });
                        });

                        document.getElementById('respon_error').innerHTML = respon_error
                    }

                    document.getElementById("tombol_kirim").disabled = false;
                })
                .catch(function(res) {
                    document.getElementById("tombol_kirim").disabled = false;
                    //handle error
                    console.log(res);
                });
        }

        hapusData = (id) => {
            Swal.fire({
                title: "Yakin hapus data?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "Batal"

            }).then((result) => {

                if (result.value) {
                    axios.post('/delete-file-dokumen', {
                            id
                        })
                        .then((response) => {
                            if (response.data.responCode == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    timer: 2000,
                                    showConfirmButton: false
                                })

                                $('#myTable').DataTable().clear().destroy();
                                getData();

                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Gagal...',
                                    text: response.data.respon,
                                })
                            }
                        }, (error) => {
                            console.log(error);
                        });
                }

            });
        }
    </script>
    <script>
        document.getElementById('id_skpd').addEventListener('change', function() {
            const skpdId = this.value; // Ambil id_skpd yang dipilih
            const unitKerjaSelect = document.getElementById('id_unit_kerja');

            // Kosongkan daftar unit kerja sebelum memuat data baru
            unitKerjaSelect.innerHTML = '<option value="">Memuat data...</option>';

            // Panggil data unit kerja dengan Axios
            axios.get(`/data-unit-kerja/${skpdId}`)
                .then(response => {
                    const data = response.data;
                    unitKerjaSelect.innerHTML = '<option value="">PILIH UNIT KERJA</option>'; // Reset pilihan

                    // Tambahkan setiap unit kerja ke dalam dropdown
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.unit_kerja;
                        unitKerjaSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching unit kerja:', error);
                    unitKerjaSelect.innerHTML = '<option value="">GAGAL MEMUAT DATA</option>';
                });
        });
    </script>
@endpush
