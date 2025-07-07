
// Ambil elemen input
const tglTerhitungMulai = document.getElementById('tgl_terhitung_mulai');
const tglKenaikanBerikutnya = document.getElementById('tgl_kenaikan_berikutnya');

// Tambahkan event listener untuk perubahan tanggal
tglTerhitungMulai.addEventListener('input', function () {
    const startDate = new Date(tglTerhitungMulai.value);

    // Periksa apakah tanggal valid
    if (!isNaN(startDate)) {
        // Tambahkan 2 tahun ke tanggal terhitung mulai
        startDate.setFullYear(startDate.getFullYear() + 2);

        // Format tanggal menjadi YYYY-MM-DD
        const year = startDate.getFullYear();
        const month = String(startDate.getMonth() + 1).padStart(2, '0');
        const day = String(startDate.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;

        // Set nilai input kenaikan berikutnya
        tglKenaikanBerikutnya.value = formattedDate;
    }
});
form.onsubmit = (e) => {

    let formData = new FormData(form);

    e.preventDefault();

    document.getElementById("tombol_kirim").disabled = true;

    axios({
        method: 'post',
        url: '/update-kenaikan-gaji',
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
