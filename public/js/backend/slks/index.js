
document.addEventListener('DOMContentLoaded', function () {
    getData()
})

function getData() {

    const params = new URLSearchParams(window.location.search);
    const param = params.get('id');

    $("#myTable").DataTable({
        "ordering": true,
        ajax: '/data-slks?param=' + param,
        processing: true,
        scrollX: true,
        'language': {
            'loadingRecords': '&nbsp;',
            'processing': 'Loading...'
        },
        columnDefs: [{
            orderable: false,
            // targets: [5]
        } // Kolom ke-0 dan ke-2 tidak bisa di-sort
        ],
        columns: [{
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            render: function (data, type, row, meta) {
                if (row.masa_kerja == 10) {
                    return `<div class="text-center">
                    <img style="width: 80px; height: 100%;" src="/lencana/perunggu.png"></div>`
                } else if (row.masa_kerja == 20) {
                    return `<div class="text-center">
                    <img style="width: 80px; height: 100%;" src="/lencana/perak.png"></div>`
                } else if (row.masa_kerja == 30) {
                    return `<div class="text-center">
                    <img style="width: 80px; height: 100%;" src="/lencana/emas.png"></div>`
                }
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<b>Nama</b>: ${row.name} <br> 
                <b>NIP</b>: ${row.status_pegawai == `Honorer` ? `-` : row.nip ?? `-`} <br>
                <div class="mt-1 badge bg-info text-white" style="border-radius: 8px;">${row.masa_kerja == 10 ? `Perunggu` : row.masa_kerja == 20 ? `Perak` : `Emas`}</div> <br>
                `;
            }
        },
        {
            render: function (data, type, row, meta) {

                let dokumen = ""

                if (row.masa_kerja >= 30) {
                    dokumen = row.sertifikat_slks_30
                        ? `<a href="/sertifikat_slks/30_tahun/${row.sertifikat_slks_30}" target="_blank">
                            <i class="bi bi-cloud-arrow-down"></i> Sertifikat Lencana
                            </a>`
                        : `<span class="text-danger">Belum Ada Sertifikat Lencana</span>`;
                } else if (row.masa_kerja >= 20) {
                    dokumen = row.sertifikat_slks_20
                        ? `<a href="/sertifikat_slks/20_tahun/${row.sertifikat_slks_20}" target="_blank">
                            <i class="bi bi-cloud-arrow-down"></i> Sertifikat Lencana</a>`
                        : `<span class="text-danger">Belum Ada Sertifikat Lencana</span>`;
                } else if (row.masa_kerja >= 10) {
                    dokumen = row.sertifikat_slks_10
                        ? `<a href="/sertifikat_slks/10_tahun/${row.sertifikat_slks_10}" target="_blank">
                            <i class="bi bi-cloud-arrow-down"></i> Sertifikat Lencana</a>`
                        : `<span class="text-danger">Belum Ada Sertifikat Lencana</span>`;
                }

                return `
                <b>Lencana</b>: ${row.masa_kerja} Tahun<br>
                <b>TMT</b>: ${row.tmt_cpns}<br>
                ${dokumen}`;
            }
        },
        {
            render: function (data, type, row, meta) {
                return `<b>SKPD</b>: ${row.instansi_kerja} <br> 
                <b>Unit Kerja</b>: ${row.unit_kerja}`
            }
        },
        {
            render: function (data, type, row, meta) {
                let badge = "";
                let dokumen = "";

                if (row.masa_kerja >= 30) {
                    dokumen = row.tanda_jasa_30
                        ? `<a href="/tanda_jasa/30_tahun/${row.tanda_jasa_30}" target="_blank">
                            <i class="bi bi-cloud-arrow-down"></i> Dok. Persyaratan SLKS
                            </a>`
                        : `<span class="text-danger">Belum Ada Dokumen</span>`;
                } else if (row.masa_kerja >= 20) {
                    dokumen = row.tanda_jasa_20
                        ? `<a href="/tanda_jasa/20_tahun/${row.tanda_jasa_20}" target="_blank">
                            <i class="bi bi-cloud-arrow-down"></i> Dok. Persyaratan SLKS</a>`
                        : `<span class="text-danger">Belum Ada Dokumen</span>`;
                } else if (row.masa_kerja >= 10) {
                    dokumen = row.tanda_jasa_10
                        ? `<a href="/tanda_jasa/10_tahun/${row.tanda_jasa_10}" target="_blank">
                            <i class="bi bi-cloud-arrow-down"></i> Dok. Persyaratan SLKS</a>`
                        : `<span class="text-danger">Belum Ada Dokumen</span>`;
                } else {
                    dokumen = ``;
                }

                return `
                ${dokumen}`;
            }
        },
        {
            render: function (data, type, row, meta) {
                return `
                <div class="dropdown d-flex justify-content-center">
                    <i style="font-size: 1.5rem;" type="button" class="text-success bi bi-three-dots" data-toggle="dropdown"></i>
                    <div class="dropdown-menu">
                        <a href="javascript:void(0)" class="dropdown-item d-flex" 
                                data-nama="${row.name}"
                                data-nip="${row.nip}"
                                data-masa_kerja="${row.masa_kerja}"
                                data-id_profil="${row.id_profil}"
                                data-type="persyaratan"
                                data-toggle="modal" data-target="#modal">
                            Upload Dokumen Persyaratan
                        </a>
                        <a href="javascript:void(0)" class="dropdown-item" 
                                data-nama="${row.name}"
                                data-nip="${row.nip}"
                                data-masa_kerja="${row.masa_kerja}"
                                data-id_profil="${row.id_profil}"
                                data-type="sertifikat"
                                data-toggle="modal" data-target="#modal">
                            Upload Sertifikat Lencana
                        </a>
                    </div>
                </div>`;
            }
        }
        ]
    })
}

$('#modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var recipient = button.data('id_profil') // Extract info from data-* attributes
    var cok = $("#myTable").DataTable().rows().data().toArray()

    // map.invalidateSize();

    let cokData = cok.filter((dt) => {
        return dt.id == recipient;
    })

    document.getElementById("form").reset();
    $('.error').empty();

    if (recipient) {
        var modal = $(this)
        modal.find('#id_profil').val(button.data('id_profil'))
        modal.find('#nama').val(button.data('nama'))
        modal.find('#nip').val(button.data('nip'))
        modal.find('#type').val(button.data('type'))
        modal.find('#masa_kerja').val(button.data('masa_kerja') + ' Tahun')
    }
})


form.onsubmit = (e) => {

    let formData = new FormData(form);

    e.preventDefault();

    document.getElementById("tombol_kirim").disabled = true;

    axios({
        method: 'post',
        url: '/store-slks',
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

                location.reload('/slks')

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
