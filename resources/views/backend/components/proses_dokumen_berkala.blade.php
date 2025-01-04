<div class="col-lg-6 mt-4">
    <div class="card shadow" style="border-radius: 8px; border: none;">
        <div class="card-body" style="border-radius: 8px; border: none;">
            <h3 style="line-height: 1.7rem;">
                [ <i class="bi bi-bell"></i> ]
                Proses Dokumen Berkala
            </h3>
            <span class="text-danger">
                Informasi Tentang Berapa Hari Lagi Dokumen Akan Berakhir
            </span>
            <div class="mb-4"></div>
            <div class="table-responsive" style="height: 290px;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama / NIP</th>
                            <th>Dok. Berkala</th>
                            <th>Tgl Akhir Dok.</th>
                            <th>Proses</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($kenaikan_gaji as $i)
                            <tr>
                                <td>
                                    {{ $i->name }} <br>
                                    <b>{{ $i->nip }}</b>
                                </td>
                                <td>
                                    {{ $i->jenis_dokumen_berkala ?? 'Lainnya' }} <br>
                                    {{ $i->status_dokumen ?? 'Belum Diproses' }}
                                </td>
                                <td>
                                    Tgl. {{ date('d-m-Y', strtotime($i->tanggal_akhir_dokumen)) }} <br>
                                    <i class="bi bi-exclamation-triangle"></i>
                                    {{ $i->total_hari }} hari lagi
                                </td>
                                <td>
                                    @if($i->jenis_dokumen_berkala == 'Kenaikan Gaji')
                                        @if ($i->id_kenaikan_gaji)
                                            <a href="{{ url('edit-kenaikan-gaji') }}?data={{ $i->id_kenaikan_gaji }}">
                                                <button style="border-radius: 8px !important;" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-fast-forward"></i>
                                                </button>
                                            </a>
                                        @else
                                            <form action="{{ url('store-kenaikan-gaji') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id_profil" id="id_profil" value="{{ $i->id_profil }}"
                                                    required>
                                                <input type="hidden" name="id_dokumen" id="id_dokumen" value="{{ $i->id }}"
                                                    required>
                                                <button style="border-radius: 8px !important;" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-fast-forward"></i>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <button style="border-radius: 8px !important;" data-toggle="modal" data-target="#modal"
                                            class="btn btn-sm btn-primary">
                                            <i class="bi bi-fast-forward"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    Belum Ada Data Untuk Ditampilkan!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>