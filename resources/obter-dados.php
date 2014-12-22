<?php

$dbConfig = require __DIR__ . '/db.config.php';

try {
    $pdo = new PDO( $dbConfig['dsn'], $dbConfig['username'], $dbConfig['password'] );
} catch (\PDOException $e) {
    die( 'Erro ao conectar ao BD: ' . $e->getMessage() );
}

return $pdo->query( 'SELECT * FROM film' )->fetchAll( PDO::FETCH_OBJ );