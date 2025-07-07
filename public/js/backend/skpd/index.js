document.getElementById('importForm').addEventListener('submit', function (event) {
    event.preventDefault();  // Mencegah reload halaman
    let formData = new FormData(this);  // Mengambil data form

    document.getElementById('responseMessage').innerText = ``

    axios.post('/import-excel-skpd', formData, {
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


document.addEventListener('DOMContentLoaded', function () {
    getData()
})

var map;  // Variabel untuk menyimpan instansi peta
var marker;  // Variabel untuk menyimpan marker yang dapat dipindah-pindah

function getData() {
    $("#myTable").DataTable({
        "ordering": true,
        ajax: '/data-skpd',
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
            render: function (data, type, row, meta) {
                return `${row.nama_skpd}<br> <b>Email:</b> ${row.email}, <b>Telepon:</b> ${row.telepon}`
            }
        },
        {
            data: "latitude"
        },
        {
            data: "longitude"
        },
        {
            render: function (data, type, row, meta) {
                return `${row.alamat}`
            }
        },
        ...(window.userRole === 'Admin' ? [
            {
                render: function (data, type, row, meta) {
                    return `<a data-toggle="modal" data-target="#modalpeta"
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

$('#modalpeta').on('shown.bs.modal', function (event) {
    // Reset konten peta hanya jika peta belum ada
    if (!map) {
        // Inisialisasi peta hanya sekali
        map = L.map('map').setView([-2.548926, 118.014863], 5);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Event listener untuk klik peta
        map.on('click', function (e) {
            const { lat, lng } = e.latlng;

            // Menampilkan latitude dan longitude pada form
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);

            // Jika marker belum ada, buat satu marker
            if (!marker) {
                marker = L.marker([lat, lng]).addTo(map)
                    .bindPopup(`Latitude: ${lat.toFixed(6)}<br>Longitude: ${lng.toFixed(6)}`)
                    .openPopup();
            } else {
                // Jika marker sudah ada, pindahkan marker ke posisi baru
                marker.setLatLng([lat, lng])
                    .bindPopup(`Latitude: ${lat.toFixed(6)}<br>Longitude: ${lng.toFixed(6)}`)
                    .openPopup();
            }
        });
    } else {
        // Memastikan peta diperbarui ukurannya saat modal dibuka
        setTimeout(() => {
            map.invalidateSize();
        }, 100);
    }

    // Reset form jika modal dibuka untuk data baru
    var button = $(event.relatedTarget);
    var recipient = button.data('bs-id');
    var cok = $("#myTable").DataTable().rows().data().toArray();

    let cokData = cok.filter((dt) => {
        return dt.id == recipient;
    });

    document.getElementById("form").reset();
    document.getElementById('id').value = '';
    $('.error').empty();

    if (recipient) {
        var modal = $(this);
        modal.find('#id').val(cokData[0].id);
        modal.find('#nama_skpd').val(cokData[0].nama_skpd);
        modal.find('#telepon').val(cokData[0].telepon);
        modal.find('#email').val(cokData[0].email);
        modal.find('#alamat').val(cokData[0].alamat);
        modal.find('#latitude').val(cokData[0].latitude);
        modal.find('#longitude').val(cokData[0].longitude);

        // // Jika data koordinat ada, atur posisi peta
        if (cokData[0].latitude && cokData[0].longitude) {
            var lat = cokData[0].latitude;
            var lng = cokData[0].longitude;
            map.setView([lat, lng], 13); // Ubah posisi peta ke koordinat baru
            // Jika marker belum ada, tambahkan marker
            if (!marker) {
                marker = L.marker([lat, lng]).addTo(map)
                    .bindPopup(`Latitude: ${lat.toFixed(6)}<br>Longitude: ${lng.toFixed(6)}`)
                    .openPopup();
            } else {
                // Jika marker sudah ada, pindahkan marker ke posisi baru
                marker.setLatLng([lat, lng])
                    .bindPopup(`Latitude: ${lat.toFixed(6)}<br>Longitude: ${lng.toFixed(6)}`)
                    .openPopup();
            }
        }
    }
});


form.onsubmit = (e) => {

    let formData = new FormData(form);

    e.preventDefault();

    document.getElementById("tombol_kirim").disabled = true;

    axios({
        method: 'post',
        url: formData.get('id') == '' ? '/store-skpd' : '/update-skpd',
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

                location.reload('/skpd')

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
            axios.post('/delete-skpd', {
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
