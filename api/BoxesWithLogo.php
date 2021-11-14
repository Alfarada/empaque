<?php

error_reporting(0);

header('Content-type: application/json;charset=utf-8');

$conn = new mysqli('localhost', 'root', '', 'empaque');

if ($conn->connect_errno) {
    $respuesta = [
        'error' => true
    ];
} else {

    // $defined = $_GET['pagina'];

    $page = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

    $postPerPage = 10;

    $start = ($page > 1) ? ($page * $postPerPage - $postPerPage) : 0;

    $conn->set_charset("utf8");

    $stmt = $conn->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM with_logo_table ORDER BY registry DESC LIMIT $start, $postPerPage");
    $stmt->execute();
    $result = $stmt->get_result();

    $response = [];

    // consulta de todos filas como nombre total
    $totalRecords = $conn->query('SELECT FOUND_ROWS() as total');

    $totalRecords = $totalRecords->fetch_assoc()['total'];

    $numberPages = ceil($totalRecords / $postPerPage);

    // Creando registro por cada arreglo
    while ($row = $result->fetch_assoc()) {

        $withoutHours = explode(" ", $row['registry']);

        $records = [
            'id'         => $row['id'],
            'registry'   => $withoutHours[0],
            // 'registry'   => $row['registry'],
            'ingress'    => $row['ingress'],
            'egrees'     => $row['egrees'],
            'stock'      => $row['stock'],
            'logo'       => $row['logo'],
            'page'        => $page,
            'numberpages' => $numberPages
        ];

        array_push($response, $records);
    }
}

echo json_encode($response);

exit();