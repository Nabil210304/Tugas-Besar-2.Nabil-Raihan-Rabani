<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">

    <script>
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        document.addEventListener('DOMContentLoaded', function () {
            var hargaInput = document.getElementById('harga');
            hargaInput.addEventListener('keyup', function () {
                hargaInput.value = formatRupiah(this.value, 'Rp. ');
            });

            // Format initial value of the input if it already has a value
            if (hargaInput.value) {
                hargaInput.value = formatRupiah(hargaInput.value, 'Rp. ');
            }
        });
    </script>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard Penjualan</h2>
        <ul>
            <li><a href="{{ url('halaman') }}">Home</a></li>
            <li><a href="{{ url('produk') }}">Produk</a></li>
            <li><a href="#">Penjualan</a></li>
            <li><a href="#">Laporan</a></li>
            <li><a href="#">Pengaturan</a></li>
        </ul>
    </div>

    <div class="main-content">
        <!-- Header -->
        <header style="display: flex; justify-content: space-between">
            <div>
                <h1>Daftar Produk</h1>
                <p>Temukan produk terbaik untuk kebutuhan Anda</p>
            </div>
        </header>

        <div>
            <div class="container">
                <h1>Edit</h1>
                <!-- Form to edit a produk -->
                <form action="{{ url('produk/edit/' . $produk->kode_produk) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required value="{{ $produk->nama_produk }}">
                    </div>

                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control" required value="{{ $produk->deskripsi }}">
                    </div>

                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="text" name="harga" id="harga" class="form-control" required value="{{ $produk->harga }}">
                    </div>

                    <div class="form-group">
                        <label for="jumlah_produk">Jumlah Produk</label>
                        <input type="number" name="jumlah_produk" class="form-control" required value="{{ $produk->jumlah_produk }}">
                    </div>

                    <div class="form-group">
                        <label for="image">Gambar</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Produk</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
