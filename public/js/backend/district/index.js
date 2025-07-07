
document.addEventListener('DOMContentLoaded', function () {
    getData()
})

function getData() {
    $("#myTable").DataTable({
        "ordering": true,
        ajax: '/data-district',
        processing: true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        columns: [{
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            data: "provinsi_name"
        },
        {
            data: "regensi_name"
        },
        {
            data: "name"
        },
        {
            data: "latitude"
        },
        {
            data: "longitude"
        },
            // {
            //     render: function (data, type, row, meta) {
            //         return `<a data-toggle="modal" data-target="#modal"
            //                             data-bs-id=` + (row.id) + ` href="javascript:void(0)">
            //                             <i style="font-size: 1.5rem;" class="text-success bi bi-grid"></i>
            //                         </a>`
            //     }
            // },
            // {
            //     render: function (data, type, row, meta) {
            //         return `<a href="javascript:void(0)" onclick="hapusData(` + (row
            //             .id) + `)">
            //                             <i style="font-size: 1.5rem;" class="text-danger bi bi-trash"></i>
            //                         </a>`
            //     }
            // },
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
        modal.find('#role').val(cokData[0].role)
        modal.find('#no_wa').val(cokData[0].no_wa)
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
