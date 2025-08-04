

document.addEventListener('DOMContentLoaded', function () {
    getData()
})

function getData() {
    $("#myTable").DataTable({
        "ordering": true,
        ajax: '/data-rekap-unor',
        processing: true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        columnDefs: [
            { orderable: false, targets: [5] }, // Kolom ke-0 dan ke-2 tidak bisa di-sort
            {
                targets: [0, 2, 3, 4, 5], // Kolom selain instansi_kerja (kolom 1)
                className: 'text-center'
            }
        ],
        columns: [{
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            data: "instansi_kerja"
        },
        {
            render: function (data, type, row, meta) {
                return `<span style="border-radius: 8px; font-size: 12px;" class="badge text-white bg-primary"><i class="bi bi-person"></i> ${row.jumlah_pns}</span>`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<span style="border-radius: 8px; font-size: 12px;" class="badge text-white bg-primary"><i class="bi bi-person"></i> ${row.jumlah_p3k}</span>`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<span style="border-radius: 8px; font-size: 12px;" class="badge text-white bg-primary"><i class="bi bi-person"></i> ${row.total_pegawai}</span>`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<a href="/kirim-pesan/?id_skpd=${row.id_skpd}">
                    <i style="font-size: 1.5rem; text-align: center;" class="text-center text-success bi bi-whatsapp"></i>
                </a>`
            }
        },
        ]
    })
}
