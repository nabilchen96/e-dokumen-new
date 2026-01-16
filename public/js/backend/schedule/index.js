
document.addEventListener('DOMContentLoaded', function () {
    getData()
})

var table = null;
let id_user, id_shift, idUserSearch

//SEARCHING DATA
$("#btnCari").click(function () {
    table.ajax.reload();

    // Ambil nilai filter
    const user = $("#idUserSearch option:selected").text();
    const idUser = $("#idUserSearch").val();
    const tglDari = $("#tanggalDari").val();
    const tglSampai = $("#tanggalSampai").val();

    // Buat teks filter
    // let info = [];

    // if (idUser) info.push("User: " + user);
    // if (tglDari) info.push("Tanggal Dari: " + tglDari);
    // if (tglSampai) info.push("Tanggal Sampai: " + tglSampai);

    // Tampilkan info filter jika ada filter
    // if (info.length > 0) {
    //     $("#textFilter").text(info.join(" | "));
    //     $("#infoFilter").removeClass("d-none");
    // }

    $("#modalCari").modal("hide");
});

function getData() {
    table = $("#myTable").DataTable({
        "ordering": true,
        ajax: {
            url: '/data-schedule',
            data: function (d) {
                d.keyword = $("#searchInput").val();
                d.id_user = $("#idUserSearch").val();
                d.tanggal_dari = $("#tanggalDari").val();
                d.tanggal_sampai = $("#tanggalSampai").val();
            }
        },
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
                return `${row.tanggal}`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.user_name}`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.shift_name}`
            }
        },
        {
            data: "jam_masuk"
        },
        {
            data: "jam_pulang"
        },
        {
            render: function (data, type, row, meta) {
                return `...`
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
        modal.find('#informasi').val(cokData[0].informasi)
        modal.find('#status').val(cokData[0].status)
    }
})

