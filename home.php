<!-- Membuat koneksi ke database  -->

<?php
$localhost  = "localhost";  // Default
$username   = "root"; //Default
$password   = ""; //default
$database   = "db_mahasiswaFTI";
// ====================================

$connect = mysqli_connect($localhost, $username, $password, $database);
// Mengecek koneksi berhasil / tidak

if (!$connect) {
    echo "Koneksi Gagal";
} else {
    echo "";
}
//=====================================

// Mendeskripsikan Variable Nama DLL

$nama = "";
$nim  = "";
$email  = "";
$alamat  = "";
$ok = "";
$error = "";
$nomor = 1;
//=====================================

//Mengambil ID dan variable data yang di klik edit

if (isset($_GET['klik'])) {
    $klik = $_GET['klik'];
} else {
    $klik = "";
}

//Menghapus data melalui id terpilih
if($klik == 'hapus'){
    $id = $_GET['id'];
    $sql1 = "DELETE from mahasiswafti where id = '$id'";
    $q1   = mysqli_query($connect, $sql1);

    if($q1){
        $ok = "Data berhasil di hapus";
    }else{
        $error  = "Data Tidak terhapus";
    }
}

// Menampilkan Data/Id yang telah di Klik, edit
if ($klik == 'edit') {
    $id = $_GET['id'];
    // Mengambil semua data mahasiswa dari ID
    $sql1 = "SELECT * FROM mahasiswafti where id ='$id'";
    $q1 = mysqli_query($connect, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nama = $r1['nama'];
    $nim = $r1['nim'];
    $email = $r1['email'];
    $alamat = $r1['alamat'];
    if ($nim == "") {
        $error = "data tidak ditemukan";
    }
}



// ===========================


// Mengambil data yang sudah di Inputkan
if (isset($_POST['save'])) {
    $nama   = $_POST['nama'];
    $nim    = $_POST['nim'];
    $email  = $_POST['email'];
    $alamat = $_POST['alamat'];
    //=======================================
    //Cek Data Yang dimasukkan
    if ($nama && $nim && $email && $alamat) {

        // Memasukkan data yang telah di edit Untuk di update
        if ($klik == 'edit') {
            $sql1 = "UPDATE mahasiswafti set nama = '$nama', nim = '$nim', email = '$email', alamat = '$alamat' WHERE id = '$id'";
            $q1   = mysqli_query($connect, $sql1);
            if ($q1) {
                $ok = "Data Berhasil Diubah";
            } else {
                $error = "Data Gagal Diubah";
            }
        } else {
            //perintah input ke database
            $sql1 = "INSERT INTO mahasiswafti (nama,nim,email,alamat) VALUES ('$nama','$nim','$email', '$alamat')";
            //untuk membuat koneksi serta mengecek data yang telah di input
            $q1 = mysqli_query($connect, $sql1);
            if ($q1) {
                $ok = "Data Berhasil Dimasukkan";
            } else {
                $error = "Data Gagal Dimasukkan";
            }
        }
    } else {
        $error = "Masukkan Data Dengan Benar";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mahasiswa Fakultas Teknologi Informmasi</title>
    <!-- CSS only -->
    <!-- Untuk Mengkoneksi Boostrap dengan code  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<style>
    .mx-auto {
        max-width: 900px;

    }

    .card {
        margin-top: 30px;
    }
</style>

<body>
    <div class="mx-auto">
        <!-- Data Input -->
        <!-- Menggunakan Card Boostrap -->
        <div class="card">
            <div class="card-header" style="text-align: center ;">
                Masukkan Data Mahasiswa
            </div>
            <div class="card-body">
                <!-- Cek data yang diinput -->
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    //Untuk refresh Halaman ke halaman utama
                     header("refresh:1;url=home.php");
                }
                ?>
                <?php
                if ($ok) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $ok ?>
                    </div>
                <?php
                     header("refresh:1 ;url=home.php"); 
                }
                ?>
                <!-- Menggunakan Floating Label Boostrap -->
                <form class="form-floating" action="" method="POST">
                    <!-- Untuk Nama -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" value="<?php echo $nama ?>">
                        <label for="floatingInputValue">Nama Lengkap</label>
                    </div>

                    <!-- Untuk NIM -->
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" value="<?php echo $nim ?>">
                        <label for="floatingInputValue">Nomor Induk Mahasiswa</label>
                    </div>
                    <!-- Untuk email -->
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?php echo $email ?>">
                        <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    </div>
                    <!-- Untuk Alamat -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Masukkan NIM" value="<?php echo $alamat ?>">
                        <label for="floatingInputValue">Alamat</label>
                    </div>

                    <div>
                        <input type="submit" name="save" id="save" class="btn btn-primary" value="Masukkan Data">
                    </div>

                </form>
            </div>
        </div>

        <!-- Untuk Output Data  -->
        <div class="card">
            <div class="card-header text-light text-center bg-secondary">
                Daftar Nama Mahasiswa Fakultas Teknologi Informasi
            </div>
            <div class="card-body">
                <!-- Menampil;akn Inputan -->
                <table class="table">

                    <thead>
                        <tr>
                            <!-- Scope col untuk mengarahkan ke dalam kolom -->
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Nim</th>
                            <th scope="col">Email</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Mengambil data inputan -->
                        <?php
                        // desc agar tampilan menurun
                        $sql2 = "SELECT * FROM mahasiswafti order by id desc";
                        $q2   = mysqli_query($connect, $sql2);

                        // Melakukan perulangan dalam pengisian 
                        while ($r2   = mysqli_fetch_array($q2)) {
                            $id     = $r2['id'];
                            $nama     = $r2['nama'];
                            $nim     = $r2['nim'];
                            $email     = $r2['email'];
                            $alamat     = $r2['alamat'];

                        ?>


                            <tr>
                                <!-- Scope row agar mengarahkan ke dalam baris -->
                                <!-- Nomor ++ agar bisa bertambah 1 tiap data dimasukkan -->
                                <th scope="row"><?php echo $nomor++ ?></th>
                                <th scope="row"><?php echo $nama ?></th>
                                <th scope="row"><?php echo $nim ?></th>
                                <th scope="row"><?php echo $email ?></th>
                                <th scope="row"><?php echo $alamat ?></th>
                                <th scope="row">

                                    <!-- Untuk mengarahkan tombol edit kemana data yang akan di edit dengan memberi alamat ID-->
                                    <!-- dengan memberi alamat ID -->
                                    <a href="home.php?klik=edit&id=<?php echo $id ?>">
                                        <button type="button" class="btn btn-warning">Edit</button>
                                    </a>
                                    <a href="home.php?klik=hapus&id=<?php echo $id ?>">
                                        <button type="button" class="btn btn-danger">hapus</button>
                                    </a>

                                </th>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>


            </div>
        </div>

</body>

</html>