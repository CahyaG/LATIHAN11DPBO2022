<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Member.class.php");
include("includes/Author.class.php");

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();
$member->getMember();

$alert = null;

if (isset($_POST['add'])) {
    //memanggil add
    $member->add($_POST);
    header("location:member.php");
}

if(isset($_POST['nama'])){
    echo "nim =".  $_POST['nim'];
    $member->update($_POST);
    header("location:member.php");
}

if (!empty($_GET['id_hapus'])) {
    //memanggil add
    $id = $_GET['id_hapus'];

    $member->delete($id);
    header("location:member.php");
}

$dataForm = null;

if (isset($_POST['update'])) {
    //memanggil add
    $member->update($_POST);
    // header("location:../member.php");
    header("location:member.php");
}

if (!empty($_GET['id_edit'])) {
    //memanggil add
    $id = $_GET['id_edit'];

    $member->getMember($id);

    list($nim, $nama, $jurusan) = $member->getResult();


    $dataForm .= '<div class="form-row">
                    <div class="form-group col">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control" name="nim1" value="'. $nim .'" disabled />
                    <input type="hidden" class="form-control" name="nim" value="'. $nim .'" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" name="nama" value="'. $nama .'" required />
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col">
                    <label for="jurusan">Jurusan</label>
                    <input class="form-control" name="jurusan" value="'. $jurusan .'" required></input>
                    </div>
                </div>
                <button type="submit" name="update" class="btn btn-primary mt-3">Update</button>';

}else {
    $dataForm .= '<div class="form-row">
                        <div class="form-group col">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" name="nim" required />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama"  required />
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                        <label for="jurusan">Jurusan</label>
                        <input class="form-control" name="jurusan"  required></input>
                        </div>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary mt-3">Add</button>';
}
$data = null;
$dataAuthor = null;
$no = 1;
$member->getMember();

while (list($nim, $nama, $jurusan) = $member->getResult()) {
   
    $data .= "<tr>
        <td>" . $no++ . "</td>
        <td>" . $nim . "</td>
        <td>" . $nama . "</td>
        <td>" . $jurusan . "</td>
        <td>
        <a href='member.php?id_edit=" . $nim .  "' class='btn btn-warning' '>Edit</a>
        <a href='member.php?id_hapus=" . $nim . "' class='btn btn-danger' '>Hapus</a>
        </td>
        </tr>";
}

$member->close();
$tpl = new Template("templates/member.html");
$tpl->replace("DATA_FORM", $dataForm);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
