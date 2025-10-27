
function formatRupiah(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(amount);
}

function formatTanggal(date) {
    var d = new Date(date);
    var day = d.getDate().toString().padStart(2, '0'); // Menambahkan leading zero jika perlu
    var month = (d.getMonth() + 1).toString().padStart(2, '0'); // Bulan dimulai dari 0, jadi tambah 1
    var year = d.getFullYear();

    return `${day}-${month}-${year}`;
}

document.addEventListener('DOMContentLoaded', function () {
    getData()
    new TomSelect('#id_profil');
})

function getData() {
    $("#myTable").DataTable({
        "ordering": true,
        ajax: '/data-kenaikan-gaji',
        processing: true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        columnDefs: [
            { orderable: true, } // Kolom ke-0 dan ke-2 tidak bisa di-sort
        ],
        columns: [{
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.name} <br> <b>${row.nip}</b>`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.no_dokumen ?? `-`} <br> Status: ${row.status}`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.gaji_pokok_lama ? `<b>Gaji Lama</b>: ${formatRupiah(row.gaji_pokok_lama)}` : '-'} 
                                <br> ${row.tgl_berlaku_gaji ? `<b>Tgl Berlaku</b>: ${formatTanggal(row.tgl_berlaku_gaji)}` : '-'}`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.gaji_pokok_baru ? `<b>Gaji Baru</b>: ${formatRupiah(row.gaji_pokok_baru)}` : `-`} 
                                <br> ${row.tgl_terhitung_mulai ? `<b>Tgl Berlaku</b>: ${formatTanggal(row.tgl_terhitung_mulai)}` : `-`}`
            }
        },

        {
            render: function (data, type, row, meta) {
                if (row.status != 'Draft') {
                    return `<a href="/export-kenaikan-gaji?data=${row.id}">
                                        <i style="font-size: 1.5rem;" class="text-danger bi bi-file-earmark-pdf"></i>
                                    </a>`
                } else {
                    return ``
                }
            }
        },

        {
            render: function (data, type, row, meta) {
                return `<a href="/edit-kenaikan-gaji?data=${row.id}">
                    <i style="font-size: 1.5rem;" class="text-success bi bi-grid"></i>
                </a>`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<a href="javascript:void(0)" onclick="hapusData(` + (row
                    .id) + `)">
                    <i style="font-size: 1.5rem;" class="text-danger bi bi-trash"></i>
                </a>`
            }
        }
        ]
    })
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
            axios.post('/delete-kenaikan-gaji', {
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
