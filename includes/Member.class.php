<?php

class Member extends DB
{
    function getMember($nim = "")
    {
        if ($nim == "") {
            $query = "SELECT * FROM member";
            return $this->execute($query);
        }

        $query = "SELECT * FROM member WHERE nim='$nim'";
        return $this->execute($query);
    }

    function add($data)
    {
        $name = $data['nama'];
        $nim = $data['nim'];
        $jurusan = $data['jurusan'];

        $query = "insert into member values ('$nim', '$name', '$jurusan')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {

        $query = "delete FROM member WHERE nim = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function update($data){
        $name = $data['nama'];
        $nim = $data['nim'];
        $jurusan = $data['jurusan'];
        $query = "UPDATE member SET nama='$name', jurusan='$jurusan' WHERE nim = '$nim'";
        // Mengeksekusi query
        return $this->execute($query);
    }

}
