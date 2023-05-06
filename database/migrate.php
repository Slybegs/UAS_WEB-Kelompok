<?php

require 'config/database.php';

$mysqli = new mysqli(...$connection);

if ($mysqli->connect_error){
    echo "Failed to connect database : (".$mysqli->connect_error.")";
}

foreach (glob("database/*.sql") as $filename) {
    $query = file_get_contents($filename);
    $stmt = $mysqli->prepare($query);

    if ($stmt->execute())
        echo "Migrate $filename Success\n";
    else
        echo "Migrate $filename Failed\n";
}