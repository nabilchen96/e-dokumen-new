@extends('backend.app')
@push('style')
    <style> 
        .nav-tabs .nav-link.active { font-weight: bold; color: #007bff; border-bottom: 3px solid #007bff; } 
        .dataTables_wrapper { overflow-x: auto; }
    </style>
@endpush
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 text-white">
            <h3 class="font-weight-bold">Manajemen VMS (Visitor Management System)</h3>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card w-100">
                <div class="card-body">
                    <div class="mb-4">
                        <button class="btn btn-primary btn-sm" onclick="bukaModal()">
                            <i class="bi bi-plus-circle"></i> Tambah Tamu
                        </button>
                        
                        <a href="{{ url('export-pdf-tamu') }}" target="_blank" class="btn btn-danger btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </a>
                    </div>
                    
                    <ul class="nav nav-tabs mb-3" id="vmsTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab">ASN Kab. Bengkulu Utara</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab2" role="tab">ASN External</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab3" role="tab">Non-ASN</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                            <table id="t1" class="table table-striped w-100">
                                <thead class="bg-info text-white">
                                    <tr><th>No</th><th>NIP/Nama</th><th>Instansi</th><th>Keperluan</th><th>Tujuan</th><th>Tingkat Kepuasan</th><th>Aksi</th></tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab2" role="tabpanel">
                            <table id="t2" class="table table-striped w-100">
                                <thead class="bg-info text-white">
                                    <tr><th>No</th><th>NIP/Nama</th><th>Instansi</th><th>Keperluan</th><th>Tujuan</th><th>Tingkat Kepuasan</th><th>Aksi</th></tr>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab3" role="tabpanel">
                            <table id="t3" class="table table-striped w-100">
                                <thead class="bg-info text-white">
                                    <tr><th>No</th><th>Nama</th><th>Asal</th><th>Keperluan</th><th>Tujuan</th><th>Tingkat Kepuasan</th><th>Aksi</th></tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="m" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="f">
                    <div class="modal-header p-3">
                        <h5 class="modal-title m-2">Input Kunjungan Tamu</h5>
                    </div>
                    <div class="modal-body">
                        <div id="respon_error" class="text-danger mb-4"></div>
                        <div class="form-group">
                            <label>Jenis Tamu <sup class="text-danger">*</sup></label>
                            <select name="jenis_tamu" id="jt" class="form-control mb-2" onchange="cj()" required>
                                <option value="Pegawai Internal">ASN Kab. Bengkulu Utara</option>
                                <option value="Pegawai External">ASN External</option>
                                <option value="Non-Pegawai">Non-ASN</option>
                            </select>
                        </div>
                        <div id="dn" class="form-group">
                            <label>NIP <sup class="text-danger">*</sup></label>
                            <input type="text" name="nip" id="np" class="form-control mb-2" placeholder="Masukkan NIP" onblur="cn()">
                        </div>
                        <div class="form-group">
                            <label>Nama <sup class="text-danger">*</sup></label>
                            <input type="text" name="nama" id="nm" class="form-control mb-2" required>
                        </div>
                        <div class="form-group">
                            <label id="lbl_ia">Instansi/Asal <sup class="text-danger">*</sup></label>
                            <input type="text" name="instansi_asal" id="ia" class="form-control mb-2" required>
                        </div>
                        <div class="form-group">
                            <label>Keperluan <sup class="text-danger">*</sup></label>
                            <textarea name="keperluan" class="form-control mb-2" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Pegawai BKPSDM yang Dituju <sup class="text-danger">*</sup></label>
                            <select name="id_tujuan" id="it" class="form-control" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawai_bkpsdm as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer p-3">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Batal</button>
                        <button type="submit" id="s" class="btn btn-primary btn-sm">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
    let selectTujuan;

    document.addEventListener("DOMContentLoaded", function() { 
        selectTujuan = new TomSelect('#it');
        lt('#t1', 'Pegawai Internal'); 
        lt('#t2', 'Pegawai External'); 
        lt('#t3', 'Non-Pegawai'); 
    });

    function bukaModal() { 
        $('#f')[0].reset(); 
        selectTujuan.clear();
        cj(); 
        $('#m').modal('show'); 
    }

    function cj() { 
        let v = $('#jt').val(); 
        let dn = $('#dn');
        let nm = $('#nm');
        let ia = $('#ia');
        let lbl_ia = $('#lbl_ia');

        if(v === 'Pegawai Internal') {
            dn.show(); 
            nm.attr('readonly', true);
            ia.attr('readonly', true);
            lbl_ia.html('Instansi <sup class="text-danger">*</sup>');
        } else if(v === 'Pegawai External') {
            dn.show(); 
            nm.removeAttr('readonly');
            ia.removeAttr('readonly');
            lbl_ia.html('Instansi Asal <sup class="text-danger">*</sup>');
        } else {
            dn.hide(); 
            nm.removeAttr('readonly');
            ia.removeAttr('readonly');
            lbl_ia.html('Asal/Alamat <sup class="text-danger">*</sup>');
        } 
    }
    
    function cn() { 
        let nip = $('#np').val();
        if($('#jt').val() === 'Pegawai Internal' && nip.length > 5) {
            axios.get('/cari-pegawai/' + nip).then(r => { 
                if(r.data) { 
                    $('#nm').val(r.data.name); 
                    $('#ia').val(r.data.instansi_kerja); 
                } 
            });
        } 
    }

    function lt(id, j) { 
        $(id).DataTable({ 
            ajax: '/data-buku-tamu?jenis=' + j, 
            processing: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]], 
            columns: [
                { render: (d, t, r, m) => m.row + 1 },
                { render: (d, t, r) => (j !== 'Non-Pegawai') ? `<b>${r.nip}</b><br>${r.nama}` : r.nama },
                { data: 'instansi_asal' },
                { data: 'keperluan' },
                { data: 'nama_tujuan' },
                { render: (d, t, r) => {
                    let nilai = r.penilaian || 'Belum Dinilai';
                    let badgeClass = 'secondary';
                    if(nilai === 'Memuaskan') badgeClass = 'success';
                    else if(nilai === 'Sedang') badgeClass = 'warning';
                    else if(nilai === 'Kurang') badgeClass = 'danger';
                    
                    return `<span class="badge badge-${badgeClass}">${nilai}</span>`;
                }},
                { render: (d, t, r) => `
                    <div class="d-flex">
                        <button onclick="kw('${r.wa_tujuan}', '${r.nama}', '${r.keperluan}')" class="btn btn-sm btn-success mr-1" title="Kirim via WA Web">
                            <i class="bi bi-whatsapp"></i>
                        </button>
                        <button onclick="us(${r.id})" class="btn btn-sm btn-info mr-1" title="Tingkat Kepuasann">
                            <i class="bi bi-star"></i>
                        </button>
                        <button onclick="ht(${r.id})" class="btn btn-sm btn-danger" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `}
            ] 
        }); 
    }

    function kw(w, n, k) { 
        if(w.startsWith('0')) { w = '62' + w.substring(1); }
        let textMessage = `Halo, ada tamu atas nama *${n}* menunggu Anda. Keperluan: ${k}\n\n📌 Pesan ini dikirim otomatis dari aplikasi Buku Tamu.`; 
        let encodedMessage = encodeURIComponent(textMessage);
        let waUrl = `https://web.whatsapp.com/send?phone=${w}&text=${encodedMessage}`;
        window.open(waUrl, '_blank');
    }

    function us(id) { 
        Swal.fire({
            title: 'Tingkat Kepuasan',
            input: 'select',
            inputOptions: {
                'Kurang': 'Kurang',
                'Sedang': 'Sedang',
                'Memuaskan': 'Memuaskan'
            },
            inputPlaceholder: '-- Pilih Tingkat Kepuasan --',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                // Pastikan route backend Anda sudah menyesuaikan
                axios.post('/update-penilaian-tamu', { id: id, penilaian: result.value }).then((res) => {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Tingkat Kepuasan telah disimpan!', timer: 1500, showConfirmButton: false });
                    $('.table').DataTable().ajax.reload(null, false);
                }).catch((err) => {
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal menyimpan Tingkat Kepuasan!' });
                });
            }
        }); 
    }

    function ht(id) { 
        Swal.fire({
            title: "Yakin hapus data?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.value) {
                axios.post('/delete-buku-tamu', { id: id }).then((res) => {
                    if (res.data.responCode == 1) {
                        Swal.fire({ icon: 'success', title: 'Berhasil', timer: 1500, showConfirmButton: false });
                        $('.table').DataTable().ajax.reload(null, false);
                    }
                });
            }
        });
    }

    $('#f').submit(function(e){ 
        e.preventDefault(); 
        $('#s').attr('disabled', true); 
        axios.post('/store-buku-tamu', new FormData(this)).then((res) => { 
            if(res.data.responCode == 1) {
                Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Data kunjungan disimpan', timer: 2000, showConfirmButton: false });
                $('#m').modal('hide'); 
                $('.table').DataTable().ajax.reload(null, false); 
            }
            $('#s').attr('disabled', false); 
        }).catch(() => {
            $('#s').attr('disabled', false);
        }); 
    });
</script>
@endpush