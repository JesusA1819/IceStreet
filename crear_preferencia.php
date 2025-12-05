<?php
session_start();

// --- PON TU ACCESS TOKEN DE MERCADO PAGO AQUÍ ---
$access_token = "TEST-530660412323814-120422-4e6759199ca886f85f0fb2125c5be448-1290334783"; 
// ------------------------------------------------

// 1. Recibimos los datos del carrito desde Javascript
$json = file_get_contents('php://input');
$datos = json_decode($json, true);

if (!$datos) {
    echo json_encode(['error' => 'No hay datos']);
    exit;
}

// 2. Preparamos la lista de productos para Mercado Pago
$items = [];
foreach ($datos['items'] as $producto) {
    $items[] = [
        "title" => $producto['nombre'],
        "quantity" => 1,
        "unit_price" => (float)$producto['precio'],
        "currency_id" => "MXN"
    ];
}

// 3. Datos del comprador (opcional, pero recomendado)
$payer = [
    "name" => $_SESSION['nombre'] ?? "Cliente",
    "email" => "cliente@email.com" // Idealmente pedir el email real
];

// 4. Estructura de la petición
$preferencia = [
    "items" => $items,
    "payer" => $payer,
    "back_urls" => [
        "success" => "http://localhost/ice-street/index.php?status=approved",
        "failure" => "http://localhost/ice-street/carrito.php?status=failure",
        "pending" => "http://localhost/ice-street/carrito.php?status=pending"
    ],
    "auto_return" => "approved"
];

// 5. Conexión directa a Mercado Pago (usando cURL)
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.mercadopago.com/checkout/preferences",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($preferencia),
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer " . $access_token,
        "Content-Type: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo json_encode(['error' => 'Error cURL: ' . $err]);
} else {
    // Devolvemos la respuesta de Mercado Pago al Javascript
    echo $response;
}
?>