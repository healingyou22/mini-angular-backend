<?php

require_once 'database.php';

$unicode = $_GET['unicode'];

$query = "DELETE FROM submission WHERE unicode = '{$unicode}'";

if (mysqli_query($connect, $query)) {
    echo json_encode(['data' => 'success']);
} else {
    echo json_encode(['data' => 'failed']);
}
