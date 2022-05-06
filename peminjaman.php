<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Buku.class.php");
include("includes/Peminjaman.class.php");
include("includes/Member.class.php");

$buku = new Buku($db_host, $db_user, $db_pass, $db_name);
$buku->open();
$buku->getBuku();

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();
$member->getMember();

$peminjaman = new Peminjaman($db_host, $db_user, $db_pass, $db_name);
$peminjaman->open();
$peminjaman->getPeminjaman();

$status = false;
$alert = null;

if (isset($_POST['add'])) {
    echo "Getin";
    //memanggil add
    $peminjaman->add($_POST);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_delete'])) {
    //memanggil add
    $id = $_GET['id_delete'];

    $peminjaman->delete($id);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_return'])) {
    //memanggil add
    $id = $_GET['id_return'];

    $peminjaman->returnPeminjaman($id);
    header("location:peminjaman.php");
}

$data = null;
$dataBuku = null;
$dataMember = null;
$no = 1;

while (list($id, $judul) = $buku->getResult()) {
    $dataBuku .= "<option value='".$id."'>".$judul."</option>
                ";
}

while (list($nim, $nama) = $member->getResult()) {
    $dataMember .= "<option value='".$nim."'>".$nama."</option>
                ";
}

while (list($id, $tanggal_pinjam, $tanggal_kembali, $id_buku, $nim) = $peminjaman->getResult()) {
    $member->getMember($nim);
    list($res_nim, $res_nama) = $member->getResult();
    $buku->getBuku($id_buku);
    list($res_id_buku, $res_judul) = $buku->getResult();
    if ($tanggal_kembali) {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $res_nama . "</td>
            <td>" . $res_judul . "</td>
            <td>" . $tanggal_pinjam. "</td>
            <td>" . $tanggal_kembali. "</td>
            <td>" . "Dikembalikan" . "</td>
            <td>
            <a href='peminjaman.php?id_delete=" . $id .  "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
    else {
            $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $res_nama . "</td>
            <td>" . $res_judul . "</td>
            <td>" . $tanggal_pinjam. "</td>
            <td>" . "Belum Dikembalikan". "</td>
            <td>" . "Dalam Peminjaman" . "</td>
            <td>
            <a href='peminjaman.php?id_return=" . $id .  "' class='btn btn-success' '>Kembalikan</a>
            </td>
            </tr>";
    }
}



$member->close();
$buku->close();
$tpl = new Template("templates/peminjaman.html");
$tpl->replace("OPTION_PEMINJAM", $dataMember);
$tpl->replace("OPTION_BUKU", $dataBuku);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
