#!/bin/bash

sudo -i

# Corrigindo repositórios da máquina

echo "deb http://ftp.br.debian.org/debian squeeze main contrib non-free" > /etc/apt/sources.list
echo "deb-src http://ftp.br.debian.org/debian squeeze main contrib non-free" >> /etc/apt/sources.list

apt-get update -qq > /dev/null

# senha mysql
debconf-set-selections <<< 'mysql-server mysql-server/root_password password 123456'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password 123456'

echo "Instalando mysql e php"

apt-get install php5-common php5-mysql mysql-server --yes --force-yes -qq > /dev/null

mysql -p123456 -u root < /vagrant/resources/sakila-schema.sql
mysql -p123456 -u root < /vagrant/resources/sakila-data.sql

# Criando script principal de testes
echo "php /vagrant/benchmarks/01-conversao-para-string.php && php /vagrant/benchmarks/02-conversao-para-xml.php && php /vagrant/benchmarks/03-conversao-para-json.php" > /usr/bin/benchmark
chmod 777 /usr/bin/benchmark

echo "Provisionamento completo, rode '$ vagrant ssh -c \"benchmark\"' para rodar os testes."