<?php

error_reporting(0);

header('Content-Type: application/json;charset=utf-8');

$id = $_POST['id'];

function validateData($id)
{
    if ($id == '' || is_int($id)) {
        return false;
    } 

    return true;
}

if (validateData($id)) {
    $conn = new mysqli('localhost', 'root', '', 'empaque');
    $conn->set_charset('utf8');

    if ($conn->connect_errno) {
        $response = ['error' => true];
    } else {
        $stmt = $conn->prepare("DELETE FROM with_logo_table WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();

        if ($conn->affected_rows <= 0) {
            $response = [
                'error'   => true,
                'message' => 'No se elimino ningun registro en la bbdd.'
            ];
        }

        $response = [
            'error' => false,
            'message' => 'operacion exitosa'
        ];
    }
} else {
    $response = [
        'error' => true,
        'message' => 'los datos introducidos son invalidos',
        'id' => $id
    ];
}

echo json_encode($response);

exit();
