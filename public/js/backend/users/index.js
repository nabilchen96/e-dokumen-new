document.getElementById('importForm').addEventListener('submit', function (event) {
    event.preventDefault();  // Mencegah reload halaman
    let formData = new FormData(this);  // Mengambil data form

    axios.post('/import-excel-user', formData, {
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

let select = ''
let select2 = ''
let currentFilter = 'PNS'; // default
let table;

document.addEventListener('DOMContentLoaded', function () {
    getData()
    select = new TomSelect('#id_unit_kerja');
    select2 = new TomSelect('#id_skpd');
})

document.getElementById('role').addEventListener('change', function () {
    const role = this.value;
    const statusPegawaiGroup = document.getElementById('status_pegawai_group');
    const id_skpd = document.getElementById('id_skpd_group');
    const id_unit_kerja = document.getElementById('id_opd_group');

    if (role === 'Pegawai') {
        statusPegawaiGroup.style.display = 'block';
    } else {
        statusPegawaiGroup.style.display = 'none';
    }

    if (role === 'SKPD') {
        id_skpd.style.display = 'block';
    } else {
        id_skpd.style.display = 'none';
    }

    if (role === 'OPD') {
        id_unit_kerja.style.display = 'block';
    } else {
        id_unit_kerja.style.display = 'none';
    }
});

$(document).on('click', '.filter-btn', function () {
    $('.filter-btn').removeClass('active btn-warning').addClass('btn-info');

    $(this)
        .removeClass('btn-info')
        .addClass('btn-warning active');

    currentFilter = $(this).data('filter');

    table.ajax.reload();
});

function getData() {
    table = $("#myTable").DataTable({
        processing: true,
        serverSide: true,
        ordering: true,
        ajax: {
            url: '/data-user',
            data: function (d) {
                d.filter = currentFilter; // kirim ke backend
            }
        },

        language: {
            loadingRecords: '&nbsp;',
            processing: 'Loading...'
        },

        columnDefs: [
            { orderable: false, targets: [6, 7] }
        ],

        columns: [
            {
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: "name",
                name: 'users.name'
            },
            {
                render: function (data, type, row, meta) {
                    return `${row.email} <br> WA: ${row.no_wa}`
                }
            },
            {
                render: function (data, type, row, meta) {
                    return `${row.role == 'OPD' ? 'Unit Kerja' : row.role} <br> ${row.nama_skpd ?? ''} ${row.unit_kerja ?? ''}`
                }
            },
            {
                data: 'status_pegawai',
                name: 'profils.status_pegawai',
                searchable: false
            },
            {
                data: "created_at",
                name: 'users.created_at',
                searchable: false
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
                    return `<a href="javascript:void(0)" onclick="hapusData(` + (row.id) + `)">
                                    <i style="font-size: 1.5rem;" class="text-danger bi bi-trash"></i>
                                </a>`
                }
            },
        ]
    });
}

$('#modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipient = button.data('bs-id'); // Extract info from data-* attributes
    var cok = $("#myTable").DataTable().rows().data().toArray();

    let cokData = cok.filter((dt) => {
        return dt.id == recipient;
    });

    const statusPegawaiGroup = document.getElementById('status_pegawai_group');
    const id_skpd = document.getElementById('id_skpd_group');
    const id_unit_kerja = document.getElementById('id_opd_group');

    document.getElementById("form").reset();
    document.getElementById('id').value = '';
    select.setValue('');
    select2.setValue('');
    $('.error').empty();

    // console.log(cokData[0].role);


    if (recipient) {
        // Edit Mode
        var modal = $(this);
        modal.find('#id').val(cokData[0].id);
        modal.find('#email').val(cokData[0].email);
        modal.find('#name').val(cokData[0].name);
        modal.find('#role').val(cokData[0].role);
        modal.find('#no_wa').val(cokData[0].no_wa);
        modal.find('#status_pegawai').val(cokData[0].status_pegawai);
        // modal.find('#id_skpd').val(cokData[0].id_skpd);
        // modal.find('#id_unit_kerja').val(cokData[0].id_unit_kerja);
        select.setValue(cokData[0].id_unit_kerja);
        select2.setValue(cokData[0].id_skpd);

        // Tampilkan Status Pegawai jika role adalah Pegawai
        if (cokData[0].role == 'Pegawai') {
            statusPegawaiGroup.style.display = 'block';
        } else {
            statusPegawaiGroup.style.display = 'none';
        }

        if (cokData[0].role === 'SKPD') {
            id_skpd.style.display = 'block';
        } else {
            id_skpd.style.display = 'none';
        }

        if (cokData[0].role === 'OPD') {
            id_unit_kerja.style.display = 'block';
        } else {
            id_unit_kerja.style.display = 'none';
        }
    } else {
        // Tambah Mode
        statusPegawaiGroup.style.display = 'none'; // Sembunyikan Status Pegawai
        id_skpd.style.display = 'none'; // Sembunyikan Status Pegawai
        id_unit_kerja.style.display = 'none'; // Sembunyikan Status Pegawai
    }
});



form.onsubmit = (e) => {

    let formData = new FormData(form);

    document.getElementById('respon_error').innerHTML = ``

    e.preventDefault();

    document.getElementById("tombol_kirim").disabled = true;

    axios({
        method: 'post',
        url: formData.get('id') == '' ? '/store-user' : '/update-user',
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

                $("#modal").modal("hide");
                $('#myTable').DataTable().clear().destroy();
                getData()

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
            axios.post('/delete-user', {
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