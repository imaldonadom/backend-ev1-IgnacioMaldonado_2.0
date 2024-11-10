<?php
$_esquema = $_SERVER['REQUEST_SCHEME']; 
$_ubicacion = $_SERVER['HTTP_HOST']; 
$_metodo = $_SERVER['REQUEST_METHOD']; 
$_path = $_SERVER['REQUEST_URI']; 
$_partes = explode('/', $_path);
$_version = $_ubicacion == 'localhost' && isset($_partes[2]) ? $_partes[2] : null;
$_mantenedor = $_ubicacion == 'localhost' && isset($_partes[3]) ? $_partes[3] : null;
$_parametros = isset($_partes[4]) ? $_partes[4] : null;

if ($_parametros && strpos($_parametros, '?') !== false) {
    $_parametros = explode('?', $_parametros)[1];
    $_parametros = explode('&', $_parametros);
} else {
    $_parametros = [];
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE");
header("Content-Type: application/json; charset=UTF-8");

// Authorization Bearer
try {
    $_headers = getallheaders();
    $_header = isset($_headers['Authorization']) ? $_headers['Authorization'] : null;
    if ($_header === null) {
        throw new Exception('No tiene autorización');
    }
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

// Tokens
$_token_get = 'Bearer get';
$_token_get_evaluacion = 'Bearer ciisa';
$_token_post = 'Bearer post';
$_token_put = 'Bearer put';
$_token_patch = 'Bearer patch';
$_token_delete = 'Bearer delete';