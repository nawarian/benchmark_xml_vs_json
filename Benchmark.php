<?php

/**
 * Este benchmark consiste em:
 * 1 - Transformar itens do repositório em XML e JSON
 * 2 - Calcular o tamanho entre eles
 * 3 - Calcular o tempo de compresão gzip de cada um
 * 4 - Calcular a diferença entre eles antes e depois da compressão
 */
class Benchmark {
    
    private $repositorio = array();
    
    /**
     * Transforma uma entidade (stdClass) em XML
     * @param stdClass $e
     * @param DOMDocument Documento para se fazer append de entidades
     * @return string XML String
     */
    private function entidadeParaXML( stdClass $e ) {
        $documento = new DOMDocument();

        $propriedades = get_object_vars( $e );
        foreach( $propriedades as $prop => $valor ) {
            $node = $documento->createElement( $prop, $valor );
            
            $documento->appendChild( $node );
        }
        
        return $documento->saveXML();
    }
    
    /**
     * Transforma uma entidade (stdClass) em JSON
     * @param stdClass $e
     * @return string JSON String
     */
    private function entidadeParaJSON( stdClass $e ) {
        return json_encode( $e );
    }
    
    /**
     * Retorna um array com dados comparativos entre o XML e o JSON recebidos
     * @param xml $xml
     * @param string $json
     * @return array comparativo numérico
     */
    private function comparacao( $xml, $json ) {
        $retorno = array(
            'tamanho' => array(
                'xml' => array(
                    'comum' => 0,
                    'comprimido' => 0,
                    'pctComprimido' => 0
                ),
                'json'=> array(
                    'comum' => 0,
                    'comprimido' => 0,
                    'pctComprimido' => 0
                )
            ),
            'tempo_compressao' => array(
                'xml' => 0,
                'json' => 0
            )
        );
        
        // Tamanhos (normal) da entidade
        $retorno['tamanho']['xml']['comum'] = strlen( $xml );
        $retorno['tamanho']['json']['comum'] = strlen( $json );

        // Realizando compressão
        $inicioCompressaoXML = microtime(true);
        $xmlGzip = gzcompress( $xml );
        $fimCompressaoXML = microtime(true);
        
        $retorno['tamanho']['xml']['comprimido'] = strlen( $xmlGzip );
        $retorno['tamanho']['xml']['pctComprimido'] = 100 - ( ($retorno['tamanho']['xml']['comprimido'] * 100) / $retorno['tamanho']['xml']['comum'] );
        $retorno['tempo_compressao']['xml'] = $fimCompressaoXML - $inicioCompressaoXML;
        
        $inicioCompressaoJSON = microtime(true);
        $jsonGzip = gzcompress( $json );
        $fimCompressaoJSON = microtime(true);
        
        $retorno['tamanho']['json']['comprimido'] = strlen( $jsonGzip );
        $retorno['tamanho']['json']['pctComprimido'] = 100 - ( ($retorno['tamanho']['json']['comprimido'] * 100) / $retorno['tamanho']['json']['comum'] );
        $retorno['tempo_compressao']['json'] = $fimCompressaoJSON - $inicioCompressaoJSON;
                
        return $retorno;
    }
    
    /**
     * Inicia o processo de benchmark
     * @param array Repositorio com dados (stdClass) a serem transformados
     * @return array
     */
    function resultados( array $repositorio ) {
        $this->repositorio = $repositorio;
        
        $xmlUm = $this->entidadeParaXML( $this->repositorio[0] );
        $jsonUm = $this->entidadeParaJSON( $this->repositorio[0] );
        
        $xmlTodos = function() use ( $repositorio ) {
            $documentoTodosXml = new DOMDocument();
            $colecao = $documentoTodosXml->createElement( 'colecao' );

            foreach( $repositorio as $item ) {
                $noAtual = $documentoTodosXml->createElement( 'item' );

                $propriedadesDoItem = get_object_vars( $item );
                foreach( $propriedadesDoItem as $prop => $valor ) {
                    $noPropriedade = $documentoTodosXml->createElement( $prop, $valor );
                    $noAtual->appendChild( $noPropriedade );
                }

                $colecao->appendChild( $noAtual );
            }

            $documentoTodosXml->appendChild( $colecao );
            return $documentoTodosXml->saveXML();
        };
        
        $jsonTodos = function() use ( $repositorio ) {
            // Adicionando chave colecao para não ficar "injusto"
            // mas na MINHA opinião, deveria ser sem. Afinal: problema do XML
            return json_encode( array( 'colecao' => $repositorio ) );
        };
        
        return array(
            'unidade' => $this->comparacao( $xmlUm, $jsonUm ),
            'todos' => $this->comparacao( $xmlTodos() , $jsonTodos() )
        );        
    }
    
}
