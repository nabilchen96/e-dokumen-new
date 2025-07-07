document.addEventListener('DOMContentLoaded', function () {
    getData()
})

function getData() {
    $("#myTable").DataTable({
        "ordering": true,
        ajax: '/data-instansi',
        processing: true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        columnDefs: [
            { orderable: false, targets: [6, 7] } // Kolom ke-0 dan ke-2 tidak bisa di-sort
        ],
        columns: [{
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<img src="/logo/${row.logo}" style="height: 100px !important; width: 80px; border-radius: 0;">`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.name} <br> <b>${row.nip}</b>`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<b><i class="bi bi-envelope"></i> Email</b>: ${row.email} <br> 
                                <b><i class="bi bi-globe"></i> Website</b>: ${row.website} <br>`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<b><i class="bi bi-telephone"></i> Telp/Fax</b>: ${row.telp_fax} <br>
                                <b><i class="bi bi-envelope"></i> Kode Pos</b>: ${row.kode_pos}`
            }
        },
        {
            data: "status"
        },
        {
            render: function (data, type, row, meta) {
                return `<a data-toggle="modal" data-target="#modal"
                            data-bs-id=` + (row.id) + ` href="javascript:void(0)">
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
        },
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
        modal.find('#id_profil').val(cokData[0].id_profil)
        modal.find('#status').val(cokData[0].status)
        modal.find('#kode_pos').val(cokData[0].kode_pos)
        modal.find('#email').val(cokData[0].email)
        modal.find('#website').val(cokData[0].website)
        modal.find('#telp_fax').val(cokData[0].telp_fax)
    }
})

form.onsubmit = (e) => {

    let formData = new FormData(form);

    e.preventDefault();

    document.getElementById("tombol_kirim").disabled = true;

    axios({
        method: 'post',
        url: formData.get('id') == '' ? '/store-instansi' : '/update-instansi',
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

                location.reload('/instansi')

            } else {

                //respon 
                let respon_error = ``
                Object.entries(res.data.respon).forEach(([field, messages]) => {
                    messages.forEach(message => {
                        respon_error += `<li>${message}</li>`;
                    });
                });

                document.getElementById('respon_error').innerHTML = respon_error
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
            axios.post('/delete-instansi', {
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
