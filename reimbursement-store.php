<?php

require_once 'database.php';

$request = file_get_contents('php://input');

$request = json_decode($request);

$employee_id = $request->data->employee_id;
$submission_date = $request->data->submission_date;

$query = "SELECT balance from balance WHERE employee_id = '{$employee_id}'";

if ($balance = mysqli_query($connect, $query)) {
    while ($row = mysqli_fetch_assoc($balance)) {
        $balanceNow = $row['balance'];
    }
}

$unicode = uniqid();

foreach ($request->data->items as $item) {

    $item_name = $item->item_name;
    $item_date = $item->item_date;
    $item_nominal = $item->item_nominal;

    if ($balanceNow > 0 && $balanceNow >= $item_nominal) {
        $query = "INSERT INTO submission (id, employee_id, submission_date, item_name, item_date, item_nominal, unicode) VALUES (null, '{$employee_id}', '{$submission_date}', '{$item_name}', '{$item_date}', '{$item_nominal}', '{$unicode}')";

        if (mysqli_query($connect, $query)) {
            $query = "UPDATE balance SET balance = balance - '{$item_nominal}' WHERE employee_id = '{$employee_id}'";

            mysqli_query($connect, $query);

            echo json_encode("success!");
        } else {
            echo json_encode("failed!");
        }
    } else {
        echo json_encode("failed!");
    }
}
