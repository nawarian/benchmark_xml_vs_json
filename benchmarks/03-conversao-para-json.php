<?php

$dados = require_once __DIR__ . '/../resources/obter-dados.php';

/* FORMATO DA STRING JSON */
/* $string = "{ "chave": "valor" }" */

/* FORMATO DO GRUPO DE STRING JSON */
/* $grupo = { "entidades": [ { "chave": "valor" } ] } */

$um = json_encode( $dados[0] );

echo "Formato String JSON:\n";
echo "Tamanho de 1 registro: " . strlen( $um ) . " bytes, " . (strlen( $um ) / 1024) . " quilobytes ou " . (strlen( $um ) / (1024*1024)) . " megabytes\n";
$t0 = microtime();
$tamanhoComprimido = strlen( gzcompress( $um ) );
$tf = microtime();
$variacaoTempo = $tf - $t0;
echo "({$tamanhoComprimido} bytes comprimido com filtro gzip em {$variacaoTempo} segundos)\n\n";

// Realizando conversão dos 10 primeiros itens
$obj = new \stdClass();
$obj->entidades = array_slice( $dados, 0, 10 );

$dez = json_encode( $obj );

echo "Tamanho de 10 registros: " . strlen( $dez ) . " bytes, " . (strlen( $dez ) / 1024) . " quilobytes ou " . (strlen( $dez ) / (1024*1024)) . " megabytes\n";
$t0 = microtime();
$tamanhoComprimido = strlen( gzcompress( $dez ) );
$tf = microtime();
$variacaoTempo = $tf - $t0;
echo "({$tamanhoComprimido} bytes comprimido com filtro gzip em {$variacaoTempo} segundos)\n\n";

// Realizando conversão dos 1000 itens
$obj = new \stdClass();
$obj->entidades = array_slice( $dados, 0, 1000 );

$mil = json_encode( $obj );


echo "Tamanho de 1000 registros: " . strlen( $mil ) . " bytes, " . (strlen( $mil ) / 1024) . " quilobytes ou " . (strlen( $mil ) / (1024*1024)) . " megabytes\n";
$t0 = microtime();
$tamanhoComprimido = strlen( gzcompress( $mil ) );
$tf = microtime();
$variacaoTempo = $tf - $t0;
echo "({$tamanhoComprimido} bytes comprimido com filtro gzip em {$variacaoTempo} segundos)\n\n";