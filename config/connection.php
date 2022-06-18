<?php
DEFINE("SERVER", "localhost");
DEFINE("DATABASE", "hvac");
DEFINE("USERNAME", "root");
DEFINE("PASSWORD", "");
try{
    $connection = new PDO("mysql:host=".SERVER.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $exception){
    echo "Connection error: ".$exception->getMessage();
}
?>