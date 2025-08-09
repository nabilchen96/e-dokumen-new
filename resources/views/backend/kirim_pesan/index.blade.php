@extends('backend.app')
@section('content')
    <div class="row" style="margin-top: -200px;">
        <div class="col-md-12 text-white">
            <div class="row">
                <div class="col-12 col-xl-8 mb-xl-0">
                    <h3 class="font-weight-bold">Kirim Pesan</h3>
                    <h4>{{ $skpd ? 'Unor '.$skpd->nama_skpd : '' }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-2">
            <!-- Wrapper untuk membuat scroll khusus tabel -->

            <form action="{{ url('store-kirim-pesan') }}" id="myForm" method="POST">
                @csrf
                <input type="hidden" name="selected_ids" id="selected_ids">
                <div class="card">
                    <div class="card-body" style="max-height: 55vh; overflow-y: auto;">
                        <ul class="nav nav-tabs mb-4">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ url('kirim-pesan') }}/?id_skpd={{ @$skpd->id }}">
                                    Kirim Pesan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('history-kirim-pesan') }}/?id_skpd={{ @$skpd->id }}">
                                    History Pesan
                                </a>
                            </li>
                        </ul>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <table id="myTable" class="table table-striped" style="width: 100%;">
                            <thead class="bg-info text-white">
                                <tr>
                                    <th width="5%">
                                        <input type="checkbox" id="select-all">
                                    </th>
                                    <th width="20%">Nama</th>
                                    <th width="20%">NIP</th>
                                    <th width="20%">No. Whatsapp</th>
                                    <th width="20%">Unit Kerja</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td><input type="checkbox" class="row-checkbox" data-id="{{ $item->id }}"></td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->no_wa }}</td>
                                        <td>{{ $item->satuan_kerja }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sticky bar di bawah -->
                <div class="sticky-bottom-bar bg-white border-top shadow-sm p-3"
                    style="position: sticky; bottom: 0; z-index: 1000;">
                    <textarea class="form-control mb-3" rows="3" name="pesan" placeholder="Tulis pesan di sini..."></textarea>
                    <div class="text-end">
                        <button class="btn btn-success btn-sm" style="border-radius: 8px !important;">
                            <i class="bi bi-whatsapp"></i> &nbsp; Kirim Pesan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script')
<script>
let selectedIds = new Set();

// Inisialisasi DataTable
var table = $('#myTable').DataTable({
    // Tambahkan ini supaya "Select All" bisa ambil semua yang difilter
    deferRender: true,
    paging: true
});

// Select All
$('#select-all').on('click', function () {
    // Ambil semua row yang sedang ada di hasil pencarian, bukan cuma halaman aktif
    var allRows = table.rows({ search: 'applied' }).nodes();

    $('input[type="checkbox"].row-checkbox', allRows).prop('checked', this.checked);

    // Update Set untuk semua yang di hasil pencarian
    $('input[type="checkbox"].row-checkbox', allRows).each(function () {
        const id = $(this).data('id');
        if ($('#select-all').is(':checked')) {
            selectedIds.add(id);
        } else {
            selectedIds.delete(id);
        }
    });
});

// Event checkbox baris (akan dipanggil setiap pindah halaman juga)
$('#myTable').on('change', '.row-checkbox', function () {
    const id = $(this).data('id');
    if ($(this).is(':checked')) {
        selectedIds.add(id);
    } else {
        selectedIds.delete(id);
    }
});

// Saat pindah halaman, centang kembali yang sudah dipilih sebelumnya
table.on('draw', function () {
    table.rows().nodes().each(function (row) {
        const checkbox = $(row).find('.row-checkbox');
        const id = checkbox.data('id');
        checkbox.prop('checked', selectedIds.has(id));
    });
});

// Saat submit form, masukkan semua selectedIds ke hidden input
$('#myForm').on('submit', function () {
    $('#selected_ids').val(Array.from(selectedIds).join(','));
});
</script>
@endpush

