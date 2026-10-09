<div class="container my-4 bg-white p-4 shadow rounded" style="max-width: 800px;">
      
        <!-- nggo ngetung Angsuran -->
        <section class="card shadow-sm mb-4">
          <h4 class="card-header bg-dark text-white fw-bold text-center">Penghitungan Angsuran</h4>
            <div class="card-body">
                
                <!-- Notif -->
                <div id="notifAlert" class="alert alert-danger d-none mb-3" role="alert"></div>

                <form id="formKredit" onsubmit="hitungAngsuran(event)">
                    <div class="mb-3 row align-items-center">
                        <label for="harga_mobil" class="col-sm-3 col-form-label fw-semibold">Harga Mobil</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="harga_mobil" placeholder="Contoh: 100000000">
                        </div>
                    </div>

                    <div class="mb-3 row align-items-center">
                        <label for="dp" class="col-sm-3 col-form-label fw-semibold">DP</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="dp">
                                <option value="" disabled selected>Pilih DP</option>
                                <option value="10">10%</option>
                                <option value="20">20%</option>
                                <option value="30">30%</option>
                                <option value="40">40%</option>
                                <option value="50">50%</option>
                                <option value="60">60%</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label fw-semibold">Tenor</label>
                        <div class="col-sm-9 d-flex align-items-center gap-3 flex-wrap pt-2">
                            <div class="form-check">
                                <input class="form-check-input tenor-checkbox" type="checkbox" name="tenor" value="1" id="t1">
                                <label class="form-check-label" for="t1">1 Tahun</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input tenor-checkbox" type="checkbox" name="tenor" value="2" id="t2">
                                <label class="form-check-label" for="t2">2 Tahun</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input tenor-checkbox" type="checkbox" name="tenor" value="3" id="t3">
                                <label class="form-check-label" for="t3">3 Tahun</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input tenor-checkbox" type="checkbox" name="tenor" value="4" id="t4">
                                <label class="form-check-label" for="t4">4 Tahun</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input tenor-checkbox" type="checkbox" name="tenor" value="5" id="t5">
                                <label class="form-check-label" for="t5">5 Tahun</label>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-secondary px-5 text-white fw-bold">Hitung</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Hasille -->
        <section id="hasilSection" class="card shadow-sm mb-4 d-none">
            <div class="card-header bg-dark text-white fw-bold text-center">
                Hasil Penghitungan Angsuran
            </div>
            <div class="card-body p-4">
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="fw-semibold" width="40%">Harga Mobil</td>
                        <td id="resHarga">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">DP</td>
                        <td id="resDp">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Tenor</td>
                        <td id="resTenor">: -</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Bunga</td>
                        <td id="resBunga">: -</td>
                    </tr>
                    <tr class="border-top">
                        <td class="fw-semibold pt-3">Jumlah Angsuran</td>
                        <td class="fw-bold text-success pt-3" id="resAngsuran">: -</td>
                    </tr>
                </table>
            </div>
        </section>

</div>

<!-- BS & JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

    const checkboxes = document.querySelectorAll('.tenor-checkbox');
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            if(this.checked) {
                checkboxes.forEach(other => {
                    if(other !== this) other.checked = false;
                });
            }
        });
    });

    function formatRupiah(angka) {
        return 'Rp. ' + angka.toLocaleString('id-ID');
    }
// Bagian repopulate e
    function hitungAngsuran(event) {
        event.preventDefault();

        let hargaInput = document.getElementById('harga_mobil').value.trim();
        let dpSelect = document.getElementById('dp').value;
        let selectedTenor = document.querySelector('.tenor-checkbox:checked');
        let notifAlert = document.getElementById('notifAlert');

        // Notif
        notifAlert.classList.add('d-none');
        notifAlert.innerText = '';

        if (hargaInput === "") {
            notifAlert.innerText = "Peringatan: Harga mobil kosong! Silakan diisi terlebih dahulu.";
            notifAlert.classList.remove('d-none');
            document.getElementById('harga_mobil').focus();
            return;
        }

        if (dpSelect === "") {
            notifAlert.innerText = "Peringatan: DP belum dipilih! Silakan pilih persentase DP.";
            notifAlert.classList.remove('d-none');
            document.getElementById('dp').focus();
            return;
        }

        if (!selectedTenor) {
            notifAlert.innerText = "Peringatan: Tenor belum dipilih! Silakan centang salah satu tenor.";
            notifAlert.classList.remove('d-none');
            return;
        }

        let hargaMobil = parseFloat(hargaInput);
        let dpPersen = parseFloat(dpSelect);
        let tenorTahun = parseInt(selectedTenor.value);
        let jumlahBulan = tenorTahun * 12;

        let nominalDp = (dpPersen / 100) * hargaMobil;
        let bunga = 0.20 * hargaMobil;
        let jumlahAngsuran = ((hargaMobil + bunga) - nominalDp) / jumlahBulan;

        document.getElementById('resHarga').innerText = ': ' + formatRupiah(hargaMobil);
        document.getElementById('resDp').innerText = `: ${dpPersen}% (${formatRupiah(nominalDp)})`;
        document.getElementById('resTenor').innerText = `: ${tenorTahun} Tahun (${jumlahBulan} Bulan)`;
        document.getElementById('resBunga').innerText = ': 20% (' + formatRupiah(bunga) + ')';
        document.getElementById('resAngsuran').innerText = ': ' + formatRupiah(Math.round(jumlahAngsuran)) + ' / Bulan';

        document.getElementById('hasilSection').classList.remove('d-none');
        document.getElementById('hasilSection').scrollIntoView({ behavior: 'smooth' });
    }
</script>