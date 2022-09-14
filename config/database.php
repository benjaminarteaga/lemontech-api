<?php

class Database {
    private $host = "localhost";
    private $user = "root";
    private $db = "lemontech";
    private $pwd = "";
    private $conn = NULL;

    public function connect() {

        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pwd, $this->db);
            $this->conn->set_charset("utf8");
        } catch (\Throwable $th) {
            throw $th;
        }

        return $this->conn;
    }
}