<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Lê os itens da loja
$items = json_decode(file_get_contents('items.json'), true);

// Parâmetros GET: item_code e coins
$itemCode = $_GET['item_code'] ?? '';
$coins    = (int)($_GET['coins'] ?? 0);

if (!isset($items[$itemCode])) {
    echo json_encode(['error' => 'Item não encontrado.']);
    exit;
}

$item  = $items[$itemCode];
$price = (int)$item['price'];

if ($coins < $price) {
    echo json_encode(['error' => 'Moedas insuficientes.']);
    exit;
}

// Subtrai o valor e retorna o novo saldo
$newCoins = $coins - $price;

echo json_encode([
    'success'   => true,
    'item'      => $item['name'],
    'new_coins' => $newCoins
]);
?>
