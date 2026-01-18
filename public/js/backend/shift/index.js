
document.addEventListener('DOMContentLoaded', function () {
    getData()
})

function getData() {
    $("#myTable").DataTable({
        "ordering": true,
        ajax: '/data-shift',
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
                return `${row.nama_shift}`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.jam_masuk}`
            }
        },
        {
            render: function (data, type, row, meta) {
                return `${row.jam_pulang}`
            }
        },
        {
            data: "mulai_scan_masuk"
        },
        {
            data: "akhir_scan_masuk"
        },
        {
            data: "mulai_scan_pulang"
        },
        {
            data: "akhir_scan_pulang"
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
        modal.find('#informasi').val(cokData[0].informasi)
        modal.find('#status').val(cokData[0].status)
    }
})

