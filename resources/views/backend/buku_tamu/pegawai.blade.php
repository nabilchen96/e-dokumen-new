@extends('backend.app')
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 text-white"><h3 class="font-weight-bold">Buku Tamu Digital (BYOD)</h3></div>
    </div>
    <div class="row mt-4">
        <!-- Form Input -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">Isi Buku Tamu</div>
                <div class="card-body">
                    <form id="formPegawai">
                        <!-- UBAH DISINI: value diubah menjadi "Pegawai Internal" agar terbaca di tab ASN Kab. Bengkulu Utara pada Admin -->
                        <input type="hidden" name="jenis_tamu" value="Pegawai Internal">
                        
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" value="{{ Auth::user()->name }}" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label>NIP</label>
                            <input type="text" name="nip" value="{{ $profil->nip ?? '' }}" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label>Instansi</label>
                            <input type="text" name="instansi_asal" value="{{ $profil->instansi_kerja ?? '' }}" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="form-group">
                            <label>Keperluan <sup class="text-danger">*</sup></label>
                            <textarea name="keperluan" class="form-control form-control-sm" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Pegawai Tujuan <sup class="text-danger">*</sup></label>
                            <select name="id_tujuan" id="id_tujuan" required>
                                <option value="">-- Pilih Pegawai --</option>
                                @foreach($pegawai_bkpsdm as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" id="btn_submit" class="btn btn-success btn-block mt-3">Submit Kunjungan</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Riwayat -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">Riwayat Kunjungan Saya</div>
                <div class="card-body table-responsive">
                    <table id="tableHistory" class="table table-striped w-100">
                        <thead class="bg-info text-white"><tr><th>Tgl</th><th>Keperluan</th><th>Tujuan</th><th>Status</th></tr></thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#id_tujuan');
        $("#tableHistory").DataTable({
            ajax: '/data-buku-tamu',
            columns: [
                { render: (data, type, row) => new Date(row.created_at).toLocaleDateString('id-ID') },
                { data: 'keperluan' }, { data: 'nama_tujuan' },
                { render: (data, type, row) => `<span class="badge badge-${row.status == 'Selesai' ? 'success' : 'warning'}">${row.status}</span>` },
            ]
        });
    });

    $('#formPegawai').submit(function(e) {
        e.preventDefault();
        $('#btn_submit').attr('disabled', true);
        axios.post('/store-buku-tamu', new FormData(this)).then(() => {
            $('#tableHistory').DataTable().ajax.reload();
            Swal.fire({icon: 'success', title: 'Berhasil', timer: 2000, showConfirmButton: false});
            $('[name="keperluan"]').val(''); $('#id_tujuan')[0].tomselect.clear();
            $('#btn_submit').attr('disabled', false);
        });
    });
</script>
@endpush