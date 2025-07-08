
document.addEventListener('DOMContentLoaded', function () {
    getData()
})

function getData() {
    $("#myTable").DataTable({
        "ordering": true,
        ajax: '/data-lapor-masalah',
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
            render: function (data, type, row, meta) {
                return `
                <a target="_blank" href="/lapor_masalah/${row.gambar}">
                <div style="
                    background-image: url('/lapor_masalah/${row.gambar}');
                    background-size: cover;
                    width: 250px;
                    height: 160px;
                "></div></a>`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<b>Pelapor</b><br>${row.name}<br><br><b>No. WA</b><br>${row.no_wa}`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<b>Dibuat Tanggal</b><br>${row.created_at} <br><br> <b>Status</b><br>${row.status ? row.status : 'Proses'}`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<b>Masalah</b><br>${row.masalah} <br><br> <b>Tanggapan</b><br>${row.jawaban ?? '-'}`
            }
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
        ] : []),
        {
            render: function (data, type, row, meta) {
                return `<a href="javascript:void(0)" onclick="hapusData(${row.id})">
                    <i class="text-danger bi bi-trash" style="font-size: 1.5rem;"></i>
                </a>`;
            }
        }
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
        modal.find('#masalah').val(cokData[0].masalah)
        modal.find('#status').val(cokData[0].status)
        modal.find('#jawaban').val(cokData[0].jawaban)
    }
})

form.onsubmit = (e) => {

    let formData = new FormData(form);

    e.preventDefault();

    document.getElementById("tombol_kirim").disabled = true;

    axios({
        method: 'post',
        url: formData.get('id') == '' ? '/store-lapor-masalah' : '/update-lapor-masalah',
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

                location.reload('/lapor-masalah')

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
            axios.post('/delete-lapor-masalah', {
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
