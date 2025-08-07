<?php

class DatabaseConfig {

    public function integrate() {

        try {
            $serverName = "localhost";
            $userName = "root";
            $password = "";
            $database = "docs_gall";

            $fuse = new PDO("mysql:host=$serverName;dbname=$database", $userName, $password);
            $fuse->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $fuse;
            //echo "Database Connection Succeeded!";
        } catch (PDOException $e) {
            echo "Database Connection Failed: ".$e->getMessage();
        }

    }
}

// Usuage
$dbConnect = new DatabaseConfig();
$dbConnect->integrate();