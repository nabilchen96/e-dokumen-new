
document.addEventListener('DOMContentLoaded', function () {
    getData()
})

function getData() {
    $("#myTable").DataTable({
        "ordering": true,
        ajax: '/data-unit-kerja',
        processing: true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        columnDefs: window.userRole === 'Admin' ? [
            { orderable: false, targets: [3, 4] }
        ] : [],
        columns: [{
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.unit_kerja}`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.nama_skpd}`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.latitude ?? '-'}`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.longitude ?? '-'}`
            }
        },
        ...(window.userRole === 'Admin' ? [
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
        modal.find('#id_skpd').val(cokData[0].id_skpd)
        modal.find('#unit_kerja').val(cokData[0].unit_kerja)
    }
})

form.onsubmit = (e) => {

    let formData = new FormData(form);

    e.preventDefault();

    document.getElementById("tombol_kirim").disabled = true;

    axios({
        method: 'post',
        url: formData.get('id') == '' ? '/store-unit-kerja' : '/update-unit-kerja',
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
            axios.post('/delete-unit-kerja', {
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

document.getElementById('importForm').addEventListener('submit', function (event) {
    event.preventDefault();  // Mencegah reload halaman
    let formData = new FormData(this);  // Mengambil data form

    document.getElementById('responseMessage').innerText = ``

    axios.post('/import-excel-unit-kerja', formData, {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
        .then(response => {
            const data = response.data;
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: `Data Berhasil Diimport: ${data.success_count}, Data Gagal Diimport: ${data.fail_count}`,
                showConfirmButton: true
            })

            $("#modalimport").modal("hide");
            $('#myTable').DataTable().clear().destroy();
            getData()
        })
        .catch(error => {
            if (error.response) {
                document.getElementById('responseMessage').innerText =
                    'Terjadi kesalahan saat mengimpor data.';
            }
        });
});

