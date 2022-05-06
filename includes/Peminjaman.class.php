<?php

class Peminjaman extends DB
{
    function getPeminjaman($nim = "")
    {
        if ($nim == "") {
            $query = "SELECT * FROM peminjaman";
            return $this->execute($query);
        }
        $query = "SELECT * FROM peminjaman WHERE nim='$nim'";
        return $this->execute($query);
    }

    function add($data)
    {
        $id_buku = $data['id_buku'];
        $nim = $data['nim'];

        $query = "insert into peminjaman(tanggal_pinjam, id_buku, nim) values (now(), '$id_buku', '$nim')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM peminjaman WHERE id = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function returnPeminjaman($id){
        $query = "UPDATE peminjaman SET tanggal_kembali=now() WHERE id = $id";
        // Mengeksekusi query
        return $this->execute($query);
    }

}
