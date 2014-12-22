<?php

$dados = require_once __DIR__ . '/../resources/obter-dados.php';

/* FORMATO DO XML */
/* <entidade><chave>valor</chave></entidade> */

/* FORMATO DO GRUPO DE XML */
/* <entidades><entidade><chave>valor</chave></entidade></entidades> */

$um = "";

$tmp = get_object_vars( $dados[0] );
$propriedades = array();

foreach( $tmp as $chave => $valor ) array_push( $propriedades, $chave );


$dd = new DOMDocument();
$entidade = $dd->createElement( 'entidade' );
foreach( $propriedades as $propriedade ) {
	$entidade->appendChild( $dd->createElement( $propriedade, $dados[0]->{$propriedade} ) );
}
$dd->appendChild( $entidade );
$um = $dd->saveXML();

echo "Formato XML:\n";
echo "Tamanho de 1 registro: " . strlen( $um ) . " bytes, " . (strlen( $um ) / 1024) . " quilobytes ou " . (strlen( $um ) / (1024*1024)) . " megabytes\n";
$t0 = microtime();
$tamanhoComprimido = strlen( gzcompress( $um ) );
$tf = microtime();
$variacaoTempo = $tf - $t0;
echo "({$tamanhoComprimido} bytes comprimido com filtro gzip em {$variacaoTempo} segundos)\n\n";

// Realizando conversão dos 10 primeiros itens
$dd = new DOMDocument();
$entidades = $dd->createElement( 'entidades' );

for( $i = 0; $i < 10; $i++ ) {
	$dado = $dados[ $i ];

	$entidade = $dd->createElement( 'entidade' );

	foreach( $propriedades as $propriedade ) {
		$entidade->appendChild( $dd->createElement( $propriedade, $dados[0]->{$propriedade} ) );
	}

	$entidades->appendChild( $entidade );
}
$dd->appendChild( $entidades );
$dez = $dd->saveXML();

echo "Tamanho de 10 registros: " . strlen( $dez ) . " bytes, " . (strlen( $dez ) / 1024) . " quilobytes ou " . (strlen( $dez ) / (1024*1024)) . " megabytes\n";
$t0 = microtime();
$tamanhoComprimido = strlen( gzcompress( $dez ) );
$tf = microtime();
$variacaoTempo = $tf - $t0;
echo "({$tamanhoComprimido} bytes comprimido com filtro gzip em {$variacaoTempo} segundos)\n\n";

// Realizando conversão dos 1000 itens
$dd = new DOMDocument();
$entidades = $dd->createElement( 'entidades' );

for( $i = 0; $i < 1000; $i++ ) {
	$dado = $dados[ $i ];

	$entidade = $dd->createElement( 'entidade' );

	foreach( $propriedades as $propriedade ) {
		$entidade->appendChild( $dd->createElement( $propriedade, $dados[0]->{$propriedade} ) );
	}

	$entidades->appendChild( $entidade );
}
$dd->appendChild( $entidades );
$mil = $dd->saveXML();

echo "Tamanho de 1000 registros: " . strlen( $mil ) . " bytes, " . (strlen( $mil ) / 1024) . " quilobytes ou " . (strlen( $mil ) / (1024*1024)) . " megabytes\n";
$t0 = microtime();
$tamanhoComprimido = strlen( gzcompress( $mil ) );
$tf = microtime();
$variacaoTempo = $tf - $t0;
echo "({$tamanhoComprimido} bytes comprimido com filtro gzip em {$variacaoTempo} segundos)\n\n";