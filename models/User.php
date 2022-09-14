<?php

class User {
    public function getAll($db) {
        $query = $db->query('SELECT * FROM users');
        return $query;
    }

    public function find($db, $id) {
        $query = $db->query("SELECT * FROM users WHERE id = $id");
        return $query;
    }

    public function create($db, $columns, $values) {
        $query = $db->query("INSERT INTO users ($columns) VALUES ($values)");
        return $query;
    }

    public function update($db, $columns, $id) {
        $query = $db->query("UPDATE users SET $columns WHERE id = $id");
        return $query;
    }

    public function delete($db, $id) {
        $query = $db->query("DELETE FROM users WHERE id = $id");
        return $query;
    }
}
