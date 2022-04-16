
-- Criando o banco de dados
create database chat_cloud
default character set utf8
default collate utf8_general_ci;

use chat_cloud;

-- Criando a tabela pessoa
create table tb_pessoa (
id_pessoa int not null auto_increment,
nome varchar(100) not null,
usuario varchar(100) not null unique,
senha varchar(250) not null,
ativo int default 0,
foto_perfil text,
is_admin int default 0,
primary key(id_pessoa)
);
-- Criando a tabela amizade
create table tb_amizade (
id_amizade int not null auto_increment,
id_pessoa_origem int not null unique,
id_pessoa_destino int not null unique,
data_inicio_amizade datetime,
amizade_aceita int default 0,
primary key(id_amizade),
foreign key(id_pessoa_origem) references tb_pessoa(id_pessoa) ,
foreign key(id_pessoa_destino) references tb_pessoa(id_pessoa)
);
-- criando a tabela mensagem
create table tb_mensagem (
id_mensagem int not null auto_increment,
id_amizade int not null,
tipo enum('F', 'T'),
lido int default 0,
texto text,
file_caminho text,
primary key(id_mensagem),
foreign key (id_amizade) references tb_amizade(id_amizade)
);