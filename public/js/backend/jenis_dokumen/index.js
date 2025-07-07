
document.addEventListener('DOMContentLoaded', function () {
    getData()
})

function getData() {
    $("#myTable").DataTable({
        "ordering": true,
        ajax: '/data-jenis-dokumen',
        processing: true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        columnDefs: window.userRole === 'Admin' ? [
            { orderable: false, targets: [5, 6] }
        ] : [],
        columns: [{
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            data: "jenis_dokumen"
        },
        {
            data: "jenis_pegawai"
        },
        {
            render: function (data, type, row, meta) {
                if (row.punya_tgl_akhir == 'Ya') {
                    return `Aktif`
                } else {
                    return `Tidak Aktif`
                }
            }
        },
        {
            render: function (data, type, row, meta) {
                if (row.punya_nomor_dokumen == 'Ya') {
                    return `Aktif`
                } else {
                    return `Tidak Aktif`
                }
            }
        },
        {
            data: "status"
        },
        ...(window.userRole === 'Admin' ? [
            {
                render: function (data, type, row, meta) {
                    return `<a data-toggle="modal" data-target="#modal"
                                        data-bs-id=${row.id} href="javascript:void(0)">
                                        <i class="text-success bi bi-grid" style="font-size: 1.5rem;"></i>
                                    </a>`;
                }
            },
            {
                render: function (data, type, row, meta) {
                    return `<a href="javascript:void(0)" onclick="hapusData(${row.id})">
                                        <i class="text-danger bi bi-trash" style="font-size: 1.5rem;"></i>
                                    </a>`;
                }
            }
        ] : [])
        ]
    })
}

$('#modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('bs-id') // Extract info from data-* attributes
    var cok = $("#myTable").DataTable().rows().data().toArray()

    let cokData = cok.filter((dt) => {
        return dt.id == recipient;
    })

    document.getElementById("form").reset();
    document.getElementById('id').value = ''
    $('.error').empty();

    if (recipient) {
        var modal = $(this)
        modal.find('#id').val(cokData[0].id)
        modal.find('#jenis_dokumen').val(cokData[0].jenis_dokumen)
        modal.find('#status').val(cokData[0].status)
        modal.find('#jenis_pegawai').val(cokData[0].jenis_pegawai)
        modal.find('#punya_tgl_akhir').val(cokData[0].punya_tgl_akhir)
        modal.find('#punya_nomor_dokumen').val(cokData[0].punya_nomor_dokumen)
    }
})

form.onsubmit = (e) => {

    let formData = new FormData(form);

    e.preventDefault();

    document.getElementById("tombol_kirim").disabled = true;

    axios({
        method: 'post',
        url: formData.get('id') == '' ? '/store-jenis-dokumen' : '/update-jenis-dokumen',
        data: formData,
    })
        .then(function (res) {
            //handle success         
            if (res.data.responCode == 1) {

                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: res.data.respon,
                    timer: 3000,
                    showConfirmButton: false
                })

                location.reload('/jenis-dokumen')

            } else {

            }

            document.getElementById("tombol_kirim").disabled = false;
        })
        .catch(function (res) {
            document.getElementById("tombol_kirim").disabled = false;
            //handle error
            console.log(res);
        });
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
            axios.post('/delete-jenis-dokumen', {
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
