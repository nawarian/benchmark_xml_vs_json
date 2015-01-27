<?php

$dados = require_once __DIR__ . '/../resources/obter-dados.php';

/* FORMATO DA STRING */
/* $string = "prop1: valor1, prop2: valor2" */

/* FORMATO DO GRUPO DE STRING */
/* $grupo = "1: $string, 2: $string2, 3: $string3" */

$um = "";

$tmp = get_object_vars( $dados[0] );
$propriedades = array();

foreach( $tmp as $chave => $valor ) array_push( $propriedades, $chave );

// Realizando conversão do primeiro item:
$um = '';
foreach( $propriedades as $propriedade ) {
	$um .= "{$propriedade}: {$dados[0]->{$propriedade}}, ";
}
$um = rtrim( $um, ', ' ); // Removendo ultimo espaço e vírgula

echo "Formato String:\n";
echo "Tamanho de 1 registro: " . strlen( $um ) . " bytes, " . (strlen( $um ) / 1024) . " quilobytes ou " . (strlen( $um ) / (1024*1024)) . " megabytes\n";
$t0 = microtime();
$tamanhoComprimido = strlen( gzcompress( $um ) );
$tf = microtime();
$variacaoTempo = round( $tf - $t0, 4 );
echo "({$tamanhoComprimido} bytes comprimido com filtro gzip em {$variacaoTempo} segundos)\n\n";

// Realizando conversão dos 10 primeiros itens
$dez = '';
for( $i = 0; $i < 10; $i++ ) {
	$dado = $dados[ $i ];

	$dez .= "{$i}: ";

	foreach( $propriedades as $propriedade ) {
		$dez .= "{$propriedade}: {$dados[$i]->{$propriedade}}, ";
	}
}
$dez = rtrim( $dez, ', ' );


echo "Tamanho de 10 registros: " . strlen( $dez ) . " bytes, " . (strlen( $dez ) / 1024) . " quilobytes ou " . (strlen( $dez ) / (1024*1024)) . " megabytes\n";
$t0 = microtime();
$tamanhoComprimido = strlen( gzcompress( $dez ) );
$tf = microtime();
$variacaoTempo = round( $tf - $t0, 4 );
echo "({$tamanhoComprimido} bytes comprimido com filtro gzip em {$variacaoTempo} segundos)\n\n";

// Realizando conversão dos 1000 itens
$mil = '';
for( $i = 0; $i < 1000; $i++ ) {
	$dado = $dados[ $i ];

	$mil .= "{$i}: ";

	foreach( $propriedades as $propriedade ) {
		$mil .= "{$propriedade}: {$dados[$i]->{$propriedade}}, ";
	}
}
$mil = rtrim( $mil, ', ' );


echo "Tamanho de 1000 registros: " . strlen( $mil ) . " bytes, " . (strlen( $mil ) / 1024) . " quilobytes ou " . (strlen( $mil ) / (1024*1024)) . " megabytes\n";
$t0 = microtime();
$tamanhoComprimido = strlen( gzcompress( $mil ) );
$tf = microtime();
$variacaoTempo = round( $tf - $t0, 4 );
echo "({$tamanhoComprimido} bytes comprimido com filtro gzip em {$variacaoTempo} segundos)\n\n";