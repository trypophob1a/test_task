<?php

require_once '../vendor/autoload.php';

use classes\DBHandler;
use classes\RequestHandler;

try {
    $request = new RequestHandler();
    $data = $request->getData();
    $db = new DBHandler('../config/db.php');
    $db->writeData($data);
    echo json_encode(['code' => 201, 'msg' => "{$data['name']} Ваш коментарий записан", 'card' => $data]);
} catch (Exception $e) {
    echo json_encode(['code' => $e->getCode(), 'msg' => $e->getMessage()]);
}