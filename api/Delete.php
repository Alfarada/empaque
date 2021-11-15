<?php

error_reporting(0);

header('Content-Type: application/json;charset=utf-8');

$id   = $_POST['id'];

$logo = '';

if (isset($_POST['logo'])) {
    $logo = $logo . $_POST['logo'];
} else {
    $logo = $logo . 0;
}

function validateData($id, $logo)
{
    if ($id == '' || is_int($id)) {
        return false;
    }

    if ($logo == '' || is_int($logo)) {
        return false;
    }

    return true;
}

if (validateData($id, $logo)) {
    $conn = new mysqli('localhost', 'root', '', 'empaque');
    $conn->set_charset('utf8');

    if ($conn->connect_errno) {
        $response = ['error' => true];
    } else {

        if ($logo == 1) {
            $stmt = $conn->prepare("DELETE FROM with_logo_table WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();

            if ($conn->affected_rows <= 0) {
                $response = [
                    'error'   => true,
                    'message' => 'No se elimino ningun registro en la bbdd.'
                ];
            } else {

                $response = [
                    'error' => false,
                    'message' => 'operacion exitosa'
                ];
            }
        } else {
            $stmt = $conn->prepare("DELETE FROM with_out_logo_table WHERE id = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();

            if ($conn->affected_rows <= 0) {
                $response = [
                    'error'   => true,
                    'message' => 'No se elimino ningun registro en la bbdd.'
                ];
            } else {

                $response = [
                    'error' => false,
                    'message' => 'operacion exitosa'
                ];
            }
        }
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
