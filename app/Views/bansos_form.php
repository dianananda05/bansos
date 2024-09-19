<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penerima Bantuan Sosial</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<div id="app" class="container mt-5">
    <h2>Form Pengajuan Bantuan Sosial</h2>

    <?php if (session()->has('errors')) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (session()->has('error')) : ?>
        <div class="alert alert-danger">
            <?= esc(session('error')) ?>
        </div>
    <?php endif; ?>

    <form action="/bansos/submit" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" class="form-control" value="<?= old('nama') ?>" required>
        </div>

        <div class="form-group">
            <label for="nik">NIK:</label>
            <input type="number" id="nik" name="nik" class="form-control" value="<?= old('nik') ?>" required>
        </div>

        <div class="form-group">
            <label for="no_kk">Nomor Kartu Keluarga:</label>
            <input type="number" id="no_kk" name="no_kk" class="form-control" value="<?= old('no_kk') ?>" required>
        </div>

        <div class="form-group">
            <label for="foto_ktp">Foto KTP:</label>
            <input type="file" id="foto_ktp" name="foto_ktp" class="form-control" accept="image/jpg,image/jpeg,image/png" required>
        </div>

        <div class="form-group">
            <label for="foto_kk">Foto Kartu Keluarga:</label>
            <input type="file" id="foto_kk" name="foto_kk" class="form-control" accept="image/jpg,image/jpeg,image/png" required>
        </div>

        <div class="form-group">
            <label for="umur">Umur:</label>
            <input type="number" id="umur" name="umur" class="form-control" value="<?= old('umur') ?>" min="21" required>
        </div>

        <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin:</label>
            <select id="jenis_kelamin" name="jenis_kelamin" class="form-control" required>
                <option value="Laki-laki" <?= old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="Perempuan" <?= old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="provinsi">Provinsi:</label>
            <select id="provinsi" name="provinsi" class="form-control" v-model="provinsi" @change="fetchKabupaten" required>
                <option value="">Pilih Provinsi</option>
                <option v-for="prov in provinsiList" :value="prov.id">{{ prov.name }}</option>
            </select>
            <input type="hidden" name="provinsi_nama" :value="getNamaProvinsi">
        </div>

        <div class="form-group">
            <label for="kabupaten">Kab/Kota:</label>
            <select id="kabupaten" name="kabupaten" class="form-control" v-model="kabupaten" @change="fetchKecamatan" required>
                <option value="">Pilih Kab/Kota</option>
                <option v-for="kab in kabupatenList" :value="kab.id">{{ kab.name }}</option>
            </select>
            <input type="hidden" name="kabupaten_nama" :value="getNamaKabupaten">
        </div>

        <div class="form-group">
            <label for="kecamatan">Kecamatan:</label>
            <select id="kecamatan" name="kecamatan" class="form-control" v-model="kecamatan" @change="fetchKelurahan" required>
                <option value="">Pilih Kecamatan</option>
                <option v-for="kec in kecamatanList" :value="kec.id">{{ kec.name }}</option>
            </select>
            <input type="hidden" name="kecamatan_nama" :value="getNamaKecamatan">
        </div>

        <div class="form-group">
            <label for="kelurahan">Kelurahan/Desa:</label>
            <select id="kelurahan" name="kelurahan" class="form-control" v-model="kelurahan" required>
                <option value="">Pilih Kelurahan</option>
                <option v-for="kel in kelurahanList" :value="kel.id">{{ kel.name }}</option>
            </select>
            <input type="hidden" name="kelurahan_nama" :value="getNamaKelurahan">
        </div>

        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" class="form-control" value="<?= old('alamat') ?>" maxlength="255" required>
        </div>

        <div class="form-group">
            <label for="rt">RT:</label>
            <input type="text" id="rt" name="rt" class="form-control" value="<?= old('rt') ?>" required>
        </div>

        <div class="form-group">
            <label for="rw">RW:</label>
            <input type="text" id="rw" name="rw" class="form-control" value="<?= old('rw') ?>" required>
        </div>

        <div class="form-group">
            <label for="penghasilan_sebelum">Penghasilan Sebelum Pandemi:</label>
            <input type="number" id="penghasilan_sebelum" name="penghasilan_sebelum" class="form-control" value="<?= old('penghasilan_sebelum') ?>" required>
        </div>

        <div class="form-group">
            <label for="penghasilan_setelah">Penghasilan Setelah Pandemi:</label>
            <input type="number" id="penghasilan_setelah" name="penghasilan_setelah" class="form-control" value="<?= old('penghasilan_setelah') ?>" required>
        </div>

        <div class="form-group">
            <label for="alasan">Alasan Membutuhkan Bantuan:</label>
            <select id="alasan" name="alasan" class="form-control" required>
                <option value="Kehilangan pekerjaan" <?= old('alasan') == 'Kehilangan pekerjaan' ? 'selected' : '' ?>>Kehilangan pekerjaan</option>
                <option value="Kepala keluarga terdampak atau korban Covid-19" <?= old('alasan') == 'Kepala keluarga terdampak atau korban Covid-19' ? 'selected' : '' ?>>Kepala keluarga terdampak atau korban Covid-19</option>
                <option value="Tergolong fakir/miskin semenjak sebelum Covid-19" <?= old('alasan') == 'Tergolong fakir/miskin semenjak sebelum Covid-19' ? 'selected' : '' ?>>Tergolong fakir/miskin semenjak sebelum Covid-19</option>
                <option value="Lainnya" <?= old('alasan') == 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
            </select>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" id="konfirmasi" name="konfirmasi" class="form-check-input" required>
            <label for="konfirmasi" class="form-check-label">
                Saya menyatakan bahwa data yang diisikan adalah benar dan siap mempertanggungjawabkan apabila ditemukan ketidaksesuaian dalam data tersebut.
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    new Vue({
        el: '#app',
        data() {
            return {
                provinsi: '<?= old('provinsi') ?>',
                kabupaten: '<?= old('kabupaten') ?>',
                kecamatan: '<?= old('kecamatan') ?>',
                kelurahan: '<?= old('kelurahan') ?>',
                provinsiList: [],
                kabupatenList: [],
                kecamatanList: [],
                kelurahanList: []
            }
        },
        computed: {
            getNamaProvinsi() {
                return this.provinsiList.find(p => p.id == this.provinsi)?.name || '';
            },
            getNamaKabupaten() {
                return this.kabupatenList.find(k => k.id == this.kabupaten)?.name || '';
            },
            getNamaKecamatan() {
                return this.kecamatanList.find(k => k.id == this.kecamatan)?.name || '';
            },
            getNamaKelurahan() {
                return this.kelurahanList.find(k => k.id == this.kelurahan)?.name || '';
            }
        },
        mounted() {
            this.fetchProvinsi();
        },
        methods: {
            fetchProvinsi() {
                axios.get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                    .then(response => {
                        this.provinsiList = response.data;
                        if (this.provinsi) {
                            this.fetchKabupaten();
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching provinces:", error);
                        alert("Gagal mengambil data provinsi. Coba lagi nanti.");
                    });
            },
            fetchKabupaten() {
                axios.get(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${this.provinsi}.json`)
                    .then(response => {
                        this.kabupatenList = response.data;
                        if (this.kabupaten) {
                            this.fetchKecamatan();
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching regencies:", error);
                        alert("Gagal mengambil data kabupaten. Coba lagi nanti.");
                    });
            },
            fetchKecamatan() {
                axios.get(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.kabupaten}.json`)
                    .then(response => {
                        this.kecamatanList = response.data;
                        if (this.kecamatan) {
                            this.fetchKelurahan();
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching districts:", error);
                        alert("Gagal mengambil data kecamatan. Coba lagi nanti.");
                    });
            },
            fetchKelurahan() {
                axios.get(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${this.kecamatan}.json`)
                    .then(response => {
                        this.kelurahanList = response.data;
                    })
                    .catch(error => {
                        console.error("Error fetching villages:", error);
                        alert("Gagal mengambil data kelurahan. Coba lagi nanti.");
                    });
            }
        }
    });
</script>
</body>
</html>