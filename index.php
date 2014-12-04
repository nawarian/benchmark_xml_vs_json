<?php

require_once('Benchmark.php');

$dbConfig = require('./db.config.php');

try {
    $pdo = new PDO( $dbConfig['dsn'], $dbConfig['username'], $dbConfig['password'] );
} catch (\PDOException $e) {
    die( 'Erro ao conectar ao BD: ' . $e->getMessage() );
}

// Limpando o DB
$createDatabase = file_get_contents( './sakila-schema.sql' );
$pdo->exec( $createDatabase );

// Adicionando dados padrão
$inserts = file_get_contents( './sakila-data.sql' );
$pdo->beginTransaction();

$pdo->exec( $inserts );

$pdo->commit();

// Rodando testes

// Benchmark na tabela film
$resultados = (new Benchmark())->resultados( $pdo->query( 'SELECT * FROM film' )->fetchAll( PDO::FETCH_OBJ ) );

// Apresentar os dados...
var_dump( $resultados );