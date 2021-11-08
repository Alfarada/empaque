<?php

error_reporting(0);

header('Content-Type: application/json;charset=utf-8');

$id         = $_POST['id'];
$registry   = $_POST['registry'];
$ingress    = $_POST['ingress'];
$egrees     = $_POST['egrees'];
$stock      = $_POST['stock'];

$logo = '';

// var_dump($id,$registry,$ingress,$egrees,$stock);

/** Comprobando si la peticion post tiene un logo definido
 *  de lo contrario se asigna cero por defecto.
 * 
 * Esto aplica mas que todo cuando se deja de usar peticiones
 * asincronas con el objeto XMLHttpRequest.
 */

if (isset($_POST['logo'])) {
    $logo = $logo . $_POST['logo'];
} else {
    $logo = $logo . 0;
}

function validateData($id, $registry, $ingress, $egrees, $stock, $logo)
{
    if ($ingress == '' || is_int($ingress)) {
        return false;
    } elseif ($egrees == '' || is_int($ingress)) {
        return false;
    } elseif ($stock  == '' || is_int($ingress)) {
        return false;
    } elseif ($logo   == '' || is_int($ingress)) {
        return false;
    } elseif ($registry == '') {
        return false;
    } elseif ($id == '' || is_int($id)) {
        return false;
    }

    return true;
}

if (validateData($id, $registry, $ingress, $egrees, $stock, $logo)) {
    $conn = new mysqli('localhost', 'root', '', 'empaque');
    $conn->set_charset('utf8');

    if ($conn->connect_errno) {
        $response = ['error' => true];
    } else {

        $query =
            "UPDATE with_logo_table SET 
            `registry` = ?,
            `ingress`  = ?,
            `egrees`   = ?,
            `stock`    = ?,
            `logo`     = ?
            WHERE `id` = ?";
        
        $stmt = $conn->prepare($query);

        if ($stmt === false) {
            $response = [ "SQL Error: " . mysqli_error($conn)];
        } else {

            $stmt->bind_param('siiiii', $registry, $ingress, $egrees, $stock, $logo, $id);
            $res = $stmt->execute();

            if ($res === false) {
                $response = ["SQL Error: " . $stmt->error];
            }
        }

        $response = [
            'error' => false
        ];
    }
} else {
    $response = [
        'error'   => true,
        'message' => 'los datos introducidos son invalidos',
        'registry' => $registry,
        'ingress' => $ingress,
        'egrees'  => $egrees,
        'stock'   => $stock,
        'logo'    => $logo,
        'id'      => $id
    ];
}

echo json_encode($response);

exit();