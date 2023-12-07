<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "lomba";

$conn =  new mysqli($host, $user, $pass, $dbname);

if($conn -> connect_error) {
    die("Koneksi Gagal: ".$conn->connect_error);
}
$nomor_ktp = "";
$nama = "";
$umur = "";
$nomor_handphone = "";
$alamat = "";
$error = "";
$sukses = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

if($op == 'delete'){
    $nomor_ktp = $_GET['nomor_ktp'];
    $sql1 = "delete from peserta where nomor_ktp = '$nomor_ktp'";
    $q1 = mysqli_query($conn,$sql1);
    if($q1){
        $sukses ="Berhasil hapus data";
    }else{
        $error="Gagal hapus data";
    }
}

if($op == 'edit'){
    $nomor_ktp = $_GET['nomor_ktp'];
    $sql1 = "select * from peserta where nomor_ktp = '$nomor_ktp'";
    $q1 = mysqli_query($conn,$sql1);
    $r1 = mysqli_fetch_array($q1);
    $nomor_ktp = $r1['nomor_ktp'];
    $nama = $r1['nama'];
    $umur = $r1['umur'];
    $nomor_handphone = $r1['nomor_handphone'];
    $alamat = $r1['alamat'];

    if($nomor_ktp == ''){
        $error = "Data tidak ditemukan";
    }
}



if(isset($_POST['simpan'])){ //untuk create
    $nomor_ktp = $_POST['nomor_ktp'];
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $nomor_handphone = $_POST['nomor_handphone'];
    $alamat = $_POST['alamat'];

    if($nomor_ktp && $nama && $umur && $nomor_handphone && $alamat){
        if($op == 'edit'){ //untuk update
            $sql1 = "update peserta set nomor_ktp = '$nomor_ktp',nama='$nama',umur='$umur',nomor_handphone='$nomor_handphone',alamat='$alamat' where nomor_ktp = '$nomor_ktp'";
            $q1 = mysqli_query($conn,$sql1);
            if($q1){
                $sukses = "Data berhasil diupdate";
            }else{
                $error = "Data gagal diupdate";
            }
        }else{ //untuk insert
            $sql1 = "insert into peserta(nomor_ktp,nama,umur,nomor_handphone,alamat) values ('$nomor_ktp','$nama','$umur','$nomor_handphone','$alamat')";
            $q1 = mysqli_query($conn,$sql1);
            if($q1){
                $sukses = "Berhasil memasukkan data";
            }else{
                $error = "Gagal memasukkan data";
            }
        }
        
    }else{
        $error = "Semua field harus diisi";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {width: 800px;}
        .card {margin-top:  10px;}
        .card {color: blue}
        .card-header {
            background-color: red; /* Blue background color */
            color: #fff; /* White text color */
        }
    </style>
</head>
<body>
    <div class="mx-auto">
        <!--untuk memasukkan data-->
        <div class="card">
            <div class="card-header">
                Form Data Peserta Lomba
            </div>
            <div class="card-body">
                <?php
                if($error){
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php"); // 5 : detik
                }
                ?>
                <?php
                if($sukses){
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php"); // 5 : detik
                }
                ?>
                <form action="" method = "POST">
                    <div class="mb-3">
                        <label for="nomor_ktp" class="form-label">nomor_ktp</label>
                            <input type="text" class="form-control" id="nomor_ktp" name="nomor_ktp" value="<?php echo $nomor_ktp?>">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama?>">
                    </div>
                    <div class="mb-3">
                        <label for="umur" class="form-label">umur</label>
                        <input type="text" class="form-control" id="umur" name="umur" value="<?php echo $umur?>">
                    </div>
                    <div class="mb-3">
                        <label for="nomor_handphone" class="form-label">nomor_handphone</label>
                            <input type="text" class="form-control" id="nomor_handphone" name="nomor_handphone" value="<?php echo $nomor_handphone?>">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat?>">
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-blue">
                Data peserta
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">nomor_ktp</th>
                            <th scope="col">Nama</th>
                            <th scope="col">umur</th>
                            <th scope="col">nomor_handphone</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Aksi</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2 = "select * from peserta order by nomor_ktp desc";
                            $q2 = mysqli_query($conn,$sql2);
                            $urut = 1;
                            while($r2 = mysqli_fetch_array($q2)){
                                $nomor_ktp = $r2['nomor_ktp'];
                                $nama = $r2['nama'];
                                $umur = $r2['umur'];
                                $nomor_handphone = $r2['nomor_handphone'];
                                $alamat = $r2['alamat'];

                                ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++ ?></th>
                                    <td scope="row"><?php echo $nomor_ktp ?></td>
                                    <td scope="row"><?php echo $nama ?></td>
                                    <td scope="row"><?php echo $umur ?></td>
                                    <td scope="row"><?php echo $nomor_handphone ?></td>
                                    <td scope="row"><?php echo $alamat ?></td>
                                    <td scope="row">
                                        <a href="index.php?op=edit&nomor_ktp=<?php echo $nomor_ktp?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                        <a href="index.php?op=delete&nomor_ktp=<?php echo $nomor_ktp?>" onclick="return confirm('Hapus data?')"><button type="button" class="btn btn-danger">Delete</button></button></a>
                                        
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>
</html>