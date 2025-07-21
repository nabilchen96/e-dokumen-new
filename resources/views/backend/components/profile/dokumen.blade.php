<div class="table-responsive">
    <table id="myTable" class="table table-striped" style="width: 100%;">
        <thead class="bg-info text-white">
            <tr>
                <th width="5%">No</th>
                <th>Pemilik</th>
                <th>Jenis / Nomor Dokumen</th>
                <th>Tanggal Berlaku</th>
                <th>Unor Induk / Unor</th>
                <th>Tanggal Upload</th>
                <th>Status</th>
                <th width="5%">PDF</th>
            </tr>
        </thead>
        <tbody>
            @php
                $data = DB::table('dokumens')
                ->leftJoin('users', 'users.id', '=', 'dokumens.id_user')
                ->leftJoin('jenis_dokumens', 'jenis_dokumens.id', '=', 'dokumens.id_dokumen')
                ->leftJoin('skpds', 'skpds.id', '=', 'dokumens.id_skpd')
                ->leftJoin('unit_kerjas', 'unit_kerjas.id', '=', 'dokumens.id_unit_kerja')
                ->leftJoin('profils', 'profils.id_user', '=', 'users.id')
                ->select(
                    'dokumens.*',
                    'jenis_dokumens.jenis_dokumen',
                    'users.name',
                    'skpds.nama_skpd',
                    'unit_kerjas.unit_kerja', 
                    'profils.nip'
                );
                $data = $data->where('profils.id', Request('id'))->get();
            @endphp
            @foreach($data as $k => $d)
                <tr>
                    <td>{{ $k+1 }}</td>
                    <td>
                        {{ $d->name }}<br>
                        {{ $d->nip }}
                    </td>
                    <td>
                        {{ $d->jenis_dokumen}} <br>
                        <b>No. </b>{{ $d->nomor_dokumen ?? '-' }} <br>
                        {{ $d->jenis_dokumen_berkala ?? 'Lainnya'}}
                    </td>
                    <td>
                        <b>Tanggal Awal:</b><br> 
                        {{ $d->tanggal_dokumen}} <br> 
                        <b>Tanggal Akhir:</b><br> 
                        {{ $d->tanggal_akhir_dokumen ?? '-' }}
                    </td>
                    <td>
                        Unit Organisasi Induk: {{ $d->nama_skpd }} <br> 
                        Unit Organisasi: {{ $d->unit_kerja ?? '-' }}
                    </td>
                    <td>
                        {{ $d->created_at }}
                    </td>
                    <td>
                        {{ $d->status ?? 'Belum Diperiksa' }}
                    </td>
                    <td>
                        <a target="_blank" href="/convert-to-pdf/{{ $d->dokumen }}">
                            <i style="font-size: 1.5rem;" class="text-danger bi bi-file-earmark-pdf"></i>
                        </a>
                    </td>
                </tr>
            @endforeach 
        </tbody>
    </table>
</div>