benchmark_xml_vs_json
=====================

Um projeto para testar capacidades e diferenças entre as duas marcações.

----------
# Vagrant
O projeto contém um Vagrantfile que, através de provisionamento, já lhe prepara todo ambiente
necessário para rodar os benchmarks.
Na raiz do projeto basta digitar:
```
$ vagrant up && vagrant ssh -c "benchmark"
```

----------
# Configurando sem vagrant

Para que o projeto funcione, você deveria configurar corretamente
o arquivo `db.config.php` que se encontra na pasta **resources** do projeto.

É importante que exista um database com o nome **sakila**,
neste database execute os scripts `sakila-schema.sql` e `sakila-data.sql`
(retirados [daqui](http://dev.mysql.com/doc/sakila/en/sakila-installation.html))
encontrados na pasta **resources**.

----------
# Executando

Dentro da pasta benchmarks existem 3 arquivos, cada um realiza um benchmark diferente. Basta executá-los com o interpretador php normalmente:
```
$ php benchmarks/01-conversao-para-string.php
```
