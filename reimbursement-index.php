<?php

require_once 'database.php';

$query = "SELECT s.id, s.employee_id, s.submission_date, s.item_name, s.item_date, s.item_nominal, s.unicode, e.name FROM submission s 
JOIN employee e ON s.employee_id = e.id 
GROUP BY s.unicode 
ORDER BY s.id";

if ($data = mysqli_query($connect, $query)) {
    $index = 0;
    $results = [];

    while ($row = mysqli_fetch_assoc($data)) {
        $results[$index]['id'] = $row['id'];
        $results[$index]['employee_id'] = $row['employee_id'];
        $results[$index]['submission_date'] = $row['submission_date'];
        $results[$index]['item_name'] = $row['item_name'];
        $results[$index]['item_date'] = $row['item_date'];
        $results[$index]['item_nominal'] = $row['item_nominal'];
        $results[$index]['unicode'] = $row['unicode'];
        $results[$index]['name'] = $row['name'];

        $index++;
    }

    echo json_encode(['data' => $results]);
} else {
    http_response_code(404);
}
