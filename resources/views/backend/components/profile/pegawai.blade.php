<form action="{{ url('update-profil-pegawai') }}" method="POST">
    @csrf
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('data'))
        <div class="alert alert-danger">
            <strong>Gagal Mengirim Data!:</strong>
            <ul>
                @foreach(session('data.respon')->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <input type="hidden" name="id" value="{{ Request('id') }}">
    <input type="hidden" name="id_user" value="{{ $profil->id_user }}">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Status Pegawai <sup class="text-danger">*</sup></label>
                <select name="status_pegawai" class="form-control" id="status_pegawai" required>
                    <option value="">--PILIH STATUS PEGAWAI--</option>
                    <option {{ $profil->status_pegawai == 'PNS' ? 'selected' : '' }}>PNS</option>
                    <option {{ $profil->status_pegawai == 'P3K' ? 'selected' : '' }}>P3K</option>
                    <option value="Honorer" {{ $profil->status_pegawai == 'Honorer' ? 'selected' : '' }}>Non ASN</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Golongan/Pangkat <sup class="text-danger">*</sup></label>
                <select name="pangkat" class="form-control" id="pangkat">
                    <option value="">--PILIH GOLONGAN/PANGKAT</option>
                    <option {{ $profil->pangkat == 'I/a - Juru Muda' ? 'selected' : '' }}>I/a - Juru Muda</option>
                    <option {{ $profil->pangkat == 'I/b - Juru Muda Tingkat I' ? 'selected' : '' }}>I/b - Juru Muda
                        Tingkat I</option>
                    <option {{ $profil->pangkat == 'I/c - Juru' ? 'selected' : '' }}>I/c - Juru</option>
                    <option {{ $profil->pangkat == 'I/d - Juru Tingkat I' ? 'selected' : '' }}>I/d - Juru Tingkat I
                    </option>
                    <option {{ $profil->pangkat == 'II/a - Pengatur Muda' ? 'selected' : '' }}>II/a - Pengatur Muda
                    </option>
                    <option {{ $profil->pangkat == 'II/b - Pengatur Muda Tingkat I' ? 'selected' : '' }}>II/b - Pengatur
                        Muda Tingkat I</option>
                    <option {{ $profil->pangkat == 'II/c - Pengatur' ? 'selected' : '' }}>II/c - Pengatur</option>
                    <option {{ $profil->pangkat == 'II/d - Pengatur Tingkat I' ? 'selected' : '' }}>II/d - Pengatur
                        Tingkat I</option>
                    <option {{ $profil->pangkat == 'III/a - Penata Muda' ? 'selected' : '' }}>III/a - Penata Muda</option>
                    <option {{ $profil->pangkat == 'III/b - Penata Muda Tingkat I' ? 'selected' : '' }}>III/b - Penata
                        Muda Tingkat I</option>
                    <option {{ $profil->pangkat == 'III/c - Penata' ? 'selected' : '' }}>III/c - Penata</option>
                    <option {{ $profil->pangkat == 'III/d - Penata Tingkat I' ? 'selected' : '' }}>III/d - Penata Tingkat
                        I</option>
                    <option {{ $profil->pangkat == 'IV/a - Pembina' ? 'selected' : '' }}>IV/a - Pembina</option>
                    <option {{ $profil->pangkat == 'IV/b - Pembina Tingkat I - Pembina Tk.I' ? 'selected' : '' }}>IV/b -
                        Pembina Tingkat I - Pembina Tk.I</option>
                    <option {{ $profil->pangkat == 'IV/c - Pembina Utama Muda' ? 'selected' : '' }}>IV/c - Pembina Utama
                        Muda</option>
                    <option {{ $profil->pangkat == 'IV/d - Pembina Utama Madya' ? 'selected' : '' }}>IV/d - Pembina Utama
                        Madya</option>
                    <option {{ $profil->pangkat == 'IV/e - Pembina Utama' ? 'selected' : '' }}>IV/e - Pembina Utama
                    </option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Jabatan <sup class="text-danger">*</sup></label>
                <input name="jabatan" id="jabatan" value="{{ $profil->jabatan }}" type="text" placeholder="Jabatan"
                    class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleInputEmail1">NIP <sup class="text-danger">*</sup></label>
                <input name="nip" id="nip" value="{{ $profil->nip }}" type="text" placeholder="NIP"
                    class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleInputEmail1">Email Gov</label>
                <input name="email_gov" value="{{ @$profil->email_gov }}" id="email_gov" type="email"
                    placeholder="Email Gov" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Jenis Pegawai <sup class="text-danger">*</sup></label>
                <select name="jenis_pegawai" class="form-control" id="jenis_pegawai" required>
                    <option value="">--PILIH JENIS PEGAWAI--</option>
                    <option {{ $profil->jenis_pegawai == 'PNS Daerah Kab./Kota yang Bekerja pada Kab./Kota' ? 'selected' : '' }}>PNS Daerah Kab./Kota yang Bekerja pada Kab./Kota</option>
                    <option {{ $profil->jenis_pegawai == 'PNS Daerah Provinsi yang Bekerja pada Provinsi' ? 'selected' : '' }}>PNS Daerah Provinsi yang Bekerja pada Provinsi</option>
                    <option {{ $profil->jenis_pegawai == 'PNS Pusat DPK pada Pemerintah Kabupaten/Kota' ? 'selected' : '' }}>PNS Pusat DPK pada Pemerintah Kabupaten/Kota</option>
                    <option {{ $profil->jenis_pegawai == 'PNS Pusat DPK pada Pemerintah Provinsi' ? 'selected' : '' }}>PNS
                        Pusat DPK pada Pemerintah Provinsi</option>
                    <option {{ $profil->jenis_pegawai == 'PNS Pusat yang Bekerja pada Departemen/Lembaga' ? 'selected' : '' }}>PNS Pusat yang Bekerja pada Departemen/Lembaga</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Kedudukan Hukum <sup class="text-danger">*</sup></label>
                <select name="kedudukan_hukum" class="form-control" id="kedudukan_hukum" required>
                    <option value="">--PILIH KEDUDUKAN HUKUM--</option>
                    <option {{ $profil->kedudukan_hukum == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option {{ $profil->kedudukan_hukum == 'Masa Persiapan Pensiun' ? 'selected' : '' }}>Masa Persiapan
                        Pensiun</option>
                    <option {{ $profil->kedudukan_hukum == 'Pemberhentian Sementara' ? 'selected' : '' }}>Pemberhentian
                        Sementara</option>
                    <option {{ $profil->kedudukan_hukum == 'PNS Kena Hukuman Disiplin' ? 'selected' : '' }}>PNS Kena
                        Hukuman Disiplin</option>
                    <option {{ $profil->kedudukan_hukum == 'PPPK Aktif' ? 'selected' : '' }}>PPPK Aktif</option>
                    <option {{ $profil->kedudukan_hukum == 'PPPK Tidak Aktif' ? 'selected' : '' }}>PPPK Tidak Aktif
                    </option>
                    <option {{ $profil->kedudukan_hukum == 'Tugas Belajar' ? 'selected' : '' }}>Tugas Belajar</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Status CPNS <sup class="text-danger">*</sup></label>
                <select name="status_cpns" class="form-control" id="status_cpns" required>
                    <option value="">--STATUS CPNS--</option>
                    <option {{ $profil->status_cpns == 'C' ? 'selected' : '' }}>C</option>
                    <option {{ $profil->status_cpns == 'P' ? 'selected' : '' }}>P</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleInputPassword1">Kartu ASN Virtual <sup class="text-danger">*</sup></label>
                <input name="kartu_asn_virtual" value="{{ $profil->kartu_asn_virtual }}" id="kartu_asn_virtual"
                    type="text" placeholder="Kartu ASN Virtual" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleInputPassword1">Nomor SK CPNS <sup class="text-danger">*</sup></label>
                <input name="nomor_sk_cpns" value="{{ $profil->nomor_sk_cpns }}" id="nomor_sk_cpns" type="text"
                    placeholder="Nomor SK CPNS" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleInputPassword1">Tanggal SK CPNS <sup class="text-danger">*</sup></label>
                <input name="tanggal_sk_cpns" value="{{ $profil->tanggal_sk_cpns }}" id="tanggal_sk_cpns" type="date"
                    placeholder="Tanggal SK CPNS" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleInputPassword1">TMT CPNS <sup class="text-danger">*</sup></label>
                <input name="tmt_cpns" id="tmt_cpns" value="{{ $profil->tmt_cpns }}" type="date" placeholder="TMT CPNS"
                    class="form-control form-control-sm">
            </div>
        </div>
        <!-- PNS  -->
        <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleInputPassword1">Nomor SK PNS <sup class="text-danger">*</sup></label>
                <input name="nomor_sk_pns" value="{{ $profil->nomor_sk_pns }}" id="nomor_sk_pns" type="text"
                    placeholder="Nomor SK PNS" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleInputPassword1">Tanggal SK PNS <sup class="text-danger">*</sup></label>
                <input name="tanggal_sk_pns" value="{{ $profil->tanggal_sk_pns }}" id="tanggal_sk_pns" type="date"
                    placeholder="Tanggal SK PNS" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleInputPassword1">TMT PNS <sup class="text-danger">*</sup></label>
                <input name="tmt_pns" id="tmt_pns" value="{{ $profil->tmt_pns }}" type="date" placeholder="TMT PNS"
                    class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleInputPassword1">TMT Golongan <sup class="text-danger">*</sup></label>
                <input name="tmt_golongan" value="{{ $profil->tmt_golongan }}" id="tmt_golongan" type="date"
                    placeholder="TMT Golongan" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleInputPassword1">MK Tahun <sup class="text-danger">*</sup></label>
                <input name="mk_tahun" id="mk_tahun" value="{{ $profil->mk_tahun }}" type="number"
                    placeholder="MK Tahun" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="exampleInputPassword1">MK Bulan <sup class="text-danger">*</sup></label>
                <input name="mk_bulan" id="mk_bulan" value="{{ $profil->mk_bulan }}" type="number"
                    placeholder="MK bulan" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Jenis Jabatan <sup class="text-danger">*</sup></label>
                <select name="jenis_jabatan" class="form-control" id="jenis_jabatan" required>
                    <option value="">--PILIH JENIS JABATAN--</option>
                    <option {{ $profil->jenis_jabatan == 'Jabatan Fungsional' ? 'selected' : '' }}>Jabatan Fungsional
                    </option>
                    <option {{ $profil->jenis_jabatan == 'Jabatan Pelaksana' ? 'selected' : '' }}>Jabatan Pelaksana
                    </option>
                    <option {{ $profil->jenis_jabatan == 'Jabatan Struktural' ? 'selected' : '' }}>Jabatan Struktural
                    </option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>KPKN </label>
                <input name="kpkn" id="kpkn" value="{{ @$profil->kpkn }}" type="text"
                    placeholder="KPKN" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Lokasi Kerja </label>
                <input name="lokasi_kerja" id="lokasi_kerja" value="{{ @$profil->lokasi_kerja }}" type="text"
                    placeholder="Lokasi Kerja" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Unor </label>
                <input name="unor_nama" id="unor_nama" value="{{ @$profil->unor_nama }}" type="text"
                    placeholder="Unor" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Instansi Induk </label>
                <input name="instansi_induk" id="instansi_induk" value="{{ @$profil->instansi_induk }}" type="text"
                    placeholder="Instansi Induk" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Instansi Kerja </label>
                <input name="instansi_kerja" id="instansi_kerja" value="{{ @$profil->instansi_kerja }}" type="text"
                    placeholder="Instansi Kerja" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Satuan Kerja </label>
                <input name="satuan_kerja_induk" id="satuan_kerja_induk" value="{{ @$profil->satuan_kerja_induk }}" type="text"
                    placeholder="Satuan Kerja" class="form-control form-control-sm">
            </div>
        </div>
        <div class="col-lg-12">
            <button id="tombol_kirim" class="btn btn-primary" style="border-radius: 8px !important;">Submit</button>
        </div>
    </div>
</form>