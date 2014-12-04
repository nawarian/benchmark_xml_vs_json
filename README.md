benchmark_xml_vs_json
=====================

Um projeto para testar capacidades e diferenças entre as duas marcações.

----------
Configurando

Para que o projeto funcione, você deveria configurar corretamente
o arquivo `db.config.php` que se encontra na raiz do projeto.

É importante que exista um database com o nome **sakila**,
pois os scripts `sakila-schema.sql` e `sakila-data.sql`
(retirados daqui [http://dev.mysql.com/doc/sakila/en/sakila-installation.html])
se referem à este schema.

----------
Executando

Após configurado o ambiente, apenas execute
`$ php index.php`

O programa irá realizar uma consulta na tabela `film` que vem no sakila-schema,
que contém exatamente 1000 registros.
Assim que a consulta terminar, será emitido o resultado de um `var_dump`
com os dados organizados.

"Mais tarde a gente dá um jeito de apresentar isto mais bonitinho..."