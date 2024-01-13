<?php
session_start();
// membuat koneksi ke database
$conn = mysqli_connect("localhost","root","","stockbarang");

// menambah barang baru
if(isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $kode = $_POST['kode_barang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $satuan = $_POST['satuan'];

    $addtotable = mysqli_query($conn, "insert into stock (namabarang, kode_barang, deskripsi, stock, satuan) values('$namabarang', '$kode' ,'$deskripsi', '$stock', '$satuan')");
    if($addtotable) {
        header('Location:tambahbarang.php');
    } else {
        echo "Gagal menambah barang";
        header('Location:tambahbarang.php');
        }
};


// menambah barang masuk
if(isset($_POST['barangmasuk'])) {
$barangnya = $_POST['barangnya'];
$penerima = $_POST['penerima'];
$qty = $_POST['qty'];

$cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
$ambildatanya = mysqli_fetch_array($cekstocksekarang);

$stocksekarang = $ambildatanya['stock'];
$tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;

$addtomasuk = mysqli_query($conn, "insert into masuk (idbarang, keterangan, qty) values('$barangnya', '$penerima', '$qty')");
$updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
if($addtomasuk&&$updatestockmasuk) {
    header('Location:masuk.php');
} else {
    echo "Gagal menambah barang";
    header('Location:masuk.php');
    }
}

// menambah barang keluar
if(isset($_POST['addbarangkeluar'])) {
$barangnya = $_POST['barangnya'];
$penerima = $_POST['penerima'];
$qty = $_POST['qty'];

$cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
$ambildatanya = mysqli_fetch_array($cekstocksekarang);

$stocksekarang = $ambildatanya['stock'];

if($stocksekarang >= $qty) {
    // kalau stock barangnya cukup
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtokeluar = mysqli_query($conn, "insert into keluar (idbarang, penerima, qty) values('$barangnya', '$penerima', '$qty')");
    $updatestockmasuk = mysqli_query($conn,"update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtokeluar&&$updatestockmasuk) {
        header('Location:keluar.php');
    } else {
        echo "Gagal menambah barang";
        header('Location:keluar.php');
    }   
} else {
    // kalau stock barangnya tidak cukup
    echo '
    <script>
        alert("Stock saat ini tidak mencukupi");
        window.location.href="keluar.php";
    </script>
    ';
}
}


// Mengubah data barang tambah
if(isset($_POST ['updatebarang'])) {
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];

    $update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang='$idb'");
    if($update) {
        header('Location:tambahbarang.php');
} else {
    echo "Gagal update barang";
    header('Location:tambahbarang.php');
    }
}

// menghapus barang dari tambah
if(isset($_POST['hapusbarang'])) {
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn,"delete from stock where idbarang='$idb'");
    if($hapus) {
        header('Location:tambahbarang.php');
} else {
    echo "Gagal hapus barang";
    header('Location:tambahbarang.php');
    }
}

// Mengubah data barang Masuk 
if(isset($_POST['updatebarangmasuk'])) {
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];
    
    $qtyskrg = mysqli_query($conn,"select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg) {
        $selisih = $qty-$qtyskrg;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
            if($kurangistocknya&&$updatenya){
                header('Location:masuk.php');
                } else {
                    echo "Gagal";
                    header('Location:masuk.php');
            }
    } else{
        $selisih = $qtyskrg-$qty;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
            if($kurangistocknya&&$updatenya){
                header('Location:masuk.php');
                } else {
                    echo "Gagal";
                    header('Location:masuk.php');
                }
    }
}

// Menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata){
        header('Location:masuk.php');
    }else {
        header('Location:masuk.php');
    }
}

// Mengubah data barang keluar
if(isset($_POST['updatebarangkeluar'])) {
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];
    
    $qtyskrg = mysqli_query($conn,"select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg) {
        $selisih = $qty-$qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
            if($kurangistocknya&&$updatenya){
                header('Location:keluar.php');
                } else {
                    echo "Gagal";
                    header('Location:keluar.php');
            }
    } else{
        $selisih = $qtyskrg-$qty;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn,"update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn,"update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
            if($kurangistocknya&&$updatenya){
                header('Location:keluar.php');
                } else {
                    echo "Gagal";
                    header('Location:keluar.php');
                }
    }
}

// Menghapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn,"select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok+$qty;

    $update = mysqli_query($conn,"update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn,"delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdata){
        header('Location:keluar.php');
    }else {
        header('Location:keluar.php');
    }
}


// menambah admin baru
if(isset($_POST['addadmin'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $queryinsert = mysqli_query($conn,"insert into login (email,password) values ('$email','$password')");

    if($queryinsert){
        // if berhasil
        header("location:user.php");
    } else {
        // kalau gagal insert ke db
        echo "Gagal Menambahkan";
        header("location=user.php");
    }
}

// edit data admin
if(isset($_POST["updateadmin"])){
    $emailbaru = $_POST["emailadmin"];
    $passwordbaru = $_POST["passwordbaru"];
    $idnya = $_POST["id"];

    $queryupdate = mysqli_query($conn,"update login set email='$emailbaru', password='$passwordbaru' where iduser='$idnya'");

    if($queryupdate){
        header("location:user.php");
    } else {
        echo "Gagal Update";
        header("location=user.php");
    }
}

// hapus admin
if(isset($_POST["hapusadmin"])){
    $id = $_POST["id"];

    $querydelete = mysqli_query($conn,"delete from login where iduser='$id'");
    
    if($querydelete){
        header("location:user.php");
    } else {
        echo "Gagal Delete";
        header("location=user.php");
    }
}


?>