<?php

error_reporting(0);

header('Content-Type: application/json;charset=utf-8');

$registry   = $_POST['registry'];
$ingress    = $_POST['ingress'];
$egrees     = $_POST['egrees'];
$stock      = $_POST['stock'];

$logo = '';

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

// add time
function addCurrentTime($registry)
{
    date_default_timezone_set('America/Guayaquil');
    $currentDate = date("Y-m-d H:i:s");
    $whitHoutDate = explode(" ", $currentDate);
    $registry = $registry . ' ' . $whitHoutDate[1];
    return $registry;
}

function validateData($registry, $ingress, $egrees, $stock, $logo)
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
    }

    return true;
}

if (validateData($registry, $ingress, $egrees, $stock, $logo)) {
    $conn = new mysqli('localhost', 'root', '', 'empaque');
    $conn->set_charset('utf8');

    if ($conn->connect_errno) {
        $response = ['error' => true];
    } else {
        $stmt = $conn->prepare("INSERT INTO with_logo_table (registry,ingress,egrees,stock,logo) VALUES (?,?,?,?,?)");
        $stmt->bind_param('siiii', addCurrentTime($registry), $ingress, $egrees, $stock, $logo);
        $stmt->execute();

        if ($conn->affected_rows <= 0) {
            $response = [
                'error'   => true,
                'message' => 'No se inserto ningun registro en la bbdd.'
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
        'registry' => $registry,
        'ingress' => $ingress,
        'egrees' => $egrees,
        'stock' => $stock,
        'logo' => $logo,
    ];
}

echo json_encode($response);

exit();