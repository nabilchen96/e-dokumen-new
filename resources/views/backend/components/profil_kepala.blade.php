<div class="col-lg-6 mt-4">
    <div class="card shadow" style="border-radius: 8px; border: none;">
        <div class="card-body" style="border-radius: 8px; border: none;">
            <h3 style="line-height: 1.7rem;">
                [ <i class="bi bi-building"></i> ]
                Profil Kepala Instansi
            </h3>
            <span class="text-danger">
                Set Data Instansi di Menu Instansi
                <a href="{{ url('instansi') }}">
                    <i class="bi bi-box-arrow-up-right"></i>
                </a>
            </span>
            <div class="mb-4"></div>
            @php
                $data = DB::table('instansis')
                    ->join('profils', 'profils.id', '=', 'instansis.id_profil')
                    ->join('users', 'users.id', '=', 'profils.id_user')
                    ->select(
                        'users.name',
                        'profils.nip',
                        'profils.pangkat',
                        'profils.tempat_lahir',
                        'profils.tanggal_lahir',
                        'profils.jenis_kelamin'
                    )->where('instansis.status', 'Aktif')->first();
            @endphp
            <div class="table-responsive" style="height: 290px; overflow-y: auto;">
                <table class="table table-striped table-borderless"
                    style="border-radius: 8px !important; border: none !important;">
                    <tr>
                        <td width="1%">
                            <i class="bi bi-person-circle"></i>
                        </td>
                        <td>
                            Kepala Instansi
                        </td>

                        <td>: {{ @$data->name }}</td>
                    </tr>
                    <tr>
                        <td width="1%">
                            <i class="bi bi-postcard"></i>
                        </td>
                        <td>
                            NIP
                        </td>
                        <td>: {{ @$data->nip }}</td>
                    </tr>
                    <tr>
                        <td width="1%">
                            <i class="bi bi-boxes"></i>
                        </td>
                        <td>
                            Gol. / Pangkat
                        </td>
                        <td>: {{ @$data->pangkat }}</td>
                    </tr>
                    <tr>
                        <td width="1%">
                            <i class="bi bi-calendar3"></i>
                        </td>
                        <td>
                            Tempat / Tanggal Lahir
                        </td>
                        <td>: {{ @$data->tempat_lahir}}, {{ @$data->tanggal_lahir }}</td>
                    </tr>
                    <tr>
                        <td width="1%">
                            <i class="bi bi-person-square"></i>
                        </td>
                        <td>
                            Jenis Kelamin
                        </td>
                        <td>: {{ @$data->jenis_kelamin }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>