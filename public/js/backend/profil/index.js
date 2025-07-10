
document.addEventListener('DOMContentLoaded', function () {
    getData()
})

function getData() {
    $("#myTable").DataTable({
        "ordering": true,
        ajax: '/data-profil',
        processing: true,
        scrollX: true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        columnDefs: [{
            orderable: false,
            targets: [5]
        } // Kolom ke-0 dan ke-2 tidak bisa di-sort
        ],
        columns: [{
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<b>Name</b>: ${row.name} <br> 
                <b>Role</b>: ${row.role} <br>
                <b>Status</b>: ${row.status_pegawai == `Honorer` ? `Non ASN` : row.status_pegawai} <br>
                <b>Gol</b>: ${row.status_pegawai == `Honorer` ? `-` : row.pangkat ?? `-`}
                `;
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<b>NIP</b>: ${row.status_pegawai == `Honorer` ? `-` : row.nip ?? `-`} <br> 
                <b>NIK</b>: ${row.nik ?? `-`}<br> 
                <b>Email</b>: ${row.email} <br> 
                <b>Jabatan</b>: ${row.status_pegawai == `Honorer` ? `-` : row.jabatan ?? `-`}
                `;
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<b>SKPD</b>: ${row.instansi_kerja} <br> 
                <b>Unit Kerja</b>: ${row.satuan_kerja}`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<b>Jenis Kelamin</b>: ${row.jenis_kelamin} <br> 
                <b>Tempat lahir</b>: ${row.tempat_lahir} <br> 
                <b>Tanggal Lahir</b>: ${row.tanggal_lahir} <br>
                <b>Whatsapp</b>: ${row.no_wa} <br>`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<a data-toggle="modal" data-target="#modalpeta"
                        data-lat="${row.latitude}" 
                        data-lng="${row.longitude}" 
                        href="javascript:void(0)">
                        <i style="font-size: 1.5rem;" class="text-info bi bi-geo-alt"></i>
                </a>`;
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<a href="/detail-profil?id=${row.id}">
                    <i style="font-size: 1.5rem;" class="text-success bi bi-grid"></i>
                </a>`
            }
        },
        ]
    })
}

var map;
var marker;

const statusPegawai = document.getElementById('status_pegawai');
const pegawaiDetails = document.getElementById('pegawai-details');
const requiredFields = pegawaiDetails.querySelectorAll('[required]');

function togglePegawaiDetails() {
    if (statusPegawai.value === 'PNS' || statusPegawai.value === 'P3K') {
        pegawaiDetails.style.display = 'block';
    } else {
        pegawaiDetails.style.display = 'none';
    }
}

$('#modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('bs-id') // Extract info from data-* attributes
    var cok = $("#myTable").DataTable().rows().data().toArray()

    // map.invalidateSize();

    let cokData = cok.filter((dt) => {
        return dt.id == recipient;
    })

    document.getElementById("form").reset();
    document.getElementById('id').value = ''
    $('.error').empty();

    if (recipient) {
        var modal = $(this)
        modal.find('#id').val(cokData[0].id)
        modal.find('#id_user').val(cokData[0].id_user)
        modal.find('#email').val(cokData[0].email)
        modal.find('#name').val(cokData[0].name)
        modal.find('#jenis_kelamin').val(cokData[0].jenis_kelamin)
        modal.find('#tempat_lahir').val(cokData[0].tempat_lahir)
        modal.find('#tanggal_lahir').val(cokData[0].tanggal_lahir)
        modal.find('#nip').val(cokData[0].nip)
        // modal.find('#alamat').val(cokData[0].alamat)
        modal.find('#status_pegawai').val(cokData[0].status_pegawai)
        modal.find('#pangkat').val(cokData[0].pangkat)
        modal.find('#jabatan').val(cokData[0].jabatan)
        modal.find('#nik').val(cokData[0].nik)
        modal.find('#id_unit_kerja').val(cokData[0].id_unit_kerja)

        // modal.find('#district').val(cokData[0].district)
        // document.getElementById('district').innerHTML = cokData[0].district
        document.getElementById('skpd_unit_kerja').innerHTML = (cokData[0].nama_skpd ?? 'Belum Dipilih') +
            ' / ' + (cokData[0].unit_kerja ?? 'Belum Dipilih')

        togglePegawaiDetails()
    }
})

$('#modalpeta').on('shown.bs.modal', function (event) {
    const button = $(event.relatedTarget); // Tombol yang men-trigger modal
    const latitude = button.data('lat'); // Ambil latitude dari atribut data
    const longitude = button.data('lng'); // Ambil longitude dari atribut data


    if (!map) {
        map = L.map('map').setView([latitude, longitude], 13);

        // Tambahkan layer peta dasar (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Tambahkan marker pada peta
        L.marker([latitude, longitude]).addTo(map)
            .bindPopup(`<b>Lokasi:</b><br>Lat: ${latitude}, Lng: ${longitude}`)
            .openPopup();
    } else {
        // Memastikan peta diperbarui ukurannya saat modal dibuka
        setTimeout(() => {
            map.invalidateSize();
        }, 100);
    }
});

form.onsubmit = (e) => {

    let formData = new FormData(form);

    e.preventDefault();

    document.getElementById("tombol_kirim").disabled = true;

    axios({
        method: 'post',
        url: formData.get('id') == '' ? '/store-profil' : '/update-profil',
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

                location.reload('/profil')

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

$(document).ready(function () {
    $('#id_unit_kerja').select2({
        placeholder: 'Pilih SKPD dan Unit Kerja',
        allowClear: true
    })
    $('#select2-ajax').select2({
        ajax: {
            url: '/search-district',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term
                };
            },
            processResults: function (data) {
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.name + ', ' + item.regensi_name + ', ' + item
                            .provinsi_name
                    }))
                };
            }
        },
        placeholder: "Cari Data...",
        minimumInputLength: 2
    });
});
