<form id="formProfil" method="post" action="{{ url('update-profil') }}">
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
                    <li>{{ @$error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <input type="hidden" name="id" value="{{ Request('id') }}">
        <input type="hidden" name="id_user" value="{{ @$profil->id_user }}">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Nama Lengkap <sup class="text-danger">*</sup></label>
                <input name="name" id="name" type="text" value="{{ @$profil->name }}" placeholder="Nama Lengkap"
                    class="form-control form-control-sm" aria-describedby="emailHelp" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>NIK <sup class="text-danger">*</sup></label>
                <input type="number" name="nik" value="{{ @$profil->nik }}" class="form-control" id="nik"
                    placeholder="NIK" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Email address <sup class="text-danger">*</sup></label>
                <input value="{{ @$profil->email }}" name="email" id="email" class="form-control form-control-sm" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="no_wa">No Whatsapp <sup class="text-danger">*</sup></label>
                <input id="no_wa" name="no_wa" type="text" value="{{ @$profil->no_wa }}" placeholder="082777120"
                    class="form-control form-control-sm" aria-describedby="emailHelp" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Jenis Kelamin <sup class="text-danger">*</sup></label>
                <select name="jenis_kelamin" class="form-control" id="jenis_kelamin" required>
                    <option {{ @$profil->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option {{ @$profil->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Tempat Lahir <sup class="text-danger">*</sup></label>
                <input type="text" name="tempat_lahir" value="{{ @$profil->tempat_lahir }}" class="form-control"
                    id="tempat_lahir" placeholder="Tempat Lahir" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Tanggal Lahir <sup class="text-danger">*</sup></label>
                <input type="date" value="{{ @$profil->tanggal_lahir }}" name="tanggal_lahir" class="form-control"
                    id="tanggal_lahir" placeholder="Tanggal Lahir" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Alamat <sup class="text-danger">*</sup></label>
                <textarea name="alamat" class="form-control" id="alamat" cols="10" rows="10" placeholder="Alamat"
                    required>{{ @$profil->alamat }}</textarea>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Agama <sup class="text-danger">*</sup></label>
                <select name="agama" id="agama" class="form-control" required>
                    <option value="">--PILIH AGAMA--</option>
                    <option {{ @@$profil->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option {{ @@$profil->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option {{ @@$profil->agama == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                    <option {{ @@$profil->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option {{ @@$profil->agama == 'Budha' ? 'selected' : '' }}>Budha</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Status Pernikahan <sup class="text-danger">*</sup></label>
                <select name="status_kawin" id="status_kawin" class="form-control" required>
                    <option value="">--PILIH STATUS PERNIKAHAN--</option>
                    <option {{ @@$profil->status_kawin == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                    <option {{ @@$profil->status_kawin == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                    <option {{ @@$profil->status_kawin == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                    <option {{ @@$profil->status_kawin == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Gelar Depan </label>
                <input type="text" name="gelar_depan" value="{{ @@$profil->gelar_depan }}" class="form-control"
                    id="gelar_depan" placeholder="Gelar Depan">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Gelar Belakang</label>
                <input type="text" name="gelar_belakang" value="{{ @@$profil->gelar_belakang }}" class="form-control"
                    id="gelar_belakang" placeholder="Gelar Belakang">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Pendidikan Terakhir<sup class="text-danger">*</sup></label>
                <select name="tingkat_pendidikan" id="tingkat_pendidikan" class="form-control" required>
                    <option value="">--PILIH TINGKAT PENDIDIKAN--</option>
                    <option {{ @@$profil->tingkat_pendidikan == 'S-3/Doktor' ? 'selected' : '' }}>S-3/Doktor</option>
                    <option {{ @@$profil->tingkat_pendidikan == 'S-2' ? 'selected' : '' }}>S-2</option>
                    <option {{ @@$profil->tingkat_pendidikan == 'S-1/Sarjana' ? 'selected' : '' }}>S-1/Sarjana</option>
                    <option {{ @@$profil->tingkat_pendidikan == 'Diploma IV' ? 'selected' : '' }}>Diploma IV</option>
                    <option {{ @@$profil->tingkat_pendidikan == 'Diploma III/Sarjana Muda' ? 'selected' : '' }}>Diploma III/Sarjana Muda</option>
                    <option {{ @@$profil->tingkat_pendidikan == 'Diploma II' ? 'selected' : '' }}>Diploma II</option>
                    <option {{ @@$profil->tingkat_pendidikan == 'Diploma I' ? 'selected' : '' }}>Diploma I</option>
                    <option {{ @@$profil->tingkat_pendidikan == 'SLTA Kejuruan' ? 'selected' : '' }}>SLTA Kejuruan</option>
                    <option {{ @@$profil->tingkat_pendidikan == 'SLTA' ? 'selected' : '' }}>SLTA</option>
                    <option {{ @@$profil->tingkat_pendidikan == 'SLTP Kejuruan' ? 'selected' : '' }}>SLTP Kejuruan</option>
                    <option {{ @@$profil->tingkat_pendidikan == 'SLTP' ? 'selected' : '' }}>SLTP</option>
                    <option {{ @@$profil->tingkat_pendidikan == 'Sekolah Dasar' ? 'selected' : '' }}>Sekolah Dasar</option>
                </select>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Tahun Lulus<sup class="text-danger">*</sup></label>
                <input type="number" name="tahun_lulus" value="{{ @@$profil->tahun_lulus }}" class="form-control"
                    id="tahun_lulus" placeholder="Tahun Lulus">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Jurusan Pendidikan</label>
                <input type="text" name="jurusan_pendidikan" value="{{ @@$profil->jurusan_pendidikan }}" class="form-control"
                    id="jurusan_pendidikan" placeholder="Jurusan Pendidikan">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>NPWP <sup class="text-danger">*</sup></label>
                <input type="text" name="npwp" value="{{ @@$profil->npwp }}" class="form-control" id="npwp"
                    placeholder="NPWP">
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>BPJS <sup class="text-danger">*</sup></label>
                <input type="text" name="bpjs" value="{{ @@$profil->bpjs }}" class="form-control" id="bpjs"
                    placeholder="BPJS">
            </div>
        </div>
        @if (Auth::user()->role == 'Admin')
        <div class="col-lg-6">
            <div class="form-group">
                <label>Status Pegawai <sup class="text-danger">*</sup></label>
                <select readonly class="form-control" id="status_pegawai" required>
                    <option value="">--PILIH STATUS PEGAWAI--</option>
                    <option {{ @$profil->status_pegawai == 'PNS' ? 'selected' : '' }}>PNS</option>
                    <option {{ @$profil->status_pegawai == 'P3K' ? 'selected' : '' }}>P3K</option>
                    <option {{ @$profil->status_pegawai == 'P3K PW' ? 'selected' : '' }}>P3K PW</option>
                    <option value="Honorer" {{ @$profil->status_pegawai == 'Honorer' ? 'selected' : '' }}>Non ASN</option>
                </select>
            </div>
        </div>
        @endif
        <div class="col-lg-12">
            <button id="tombol_kirim" class="btn btn-primary" style="border-radius: 8px !important;">Submit</button>
        </div>
    </div>
</form>