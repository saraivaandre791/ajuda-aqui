-- Cria o banco de dados principal
create database formulario;
use formulario;
/*
Tabela de candidatos 
Armazena nome, login e senha
*/
create table logins (
id int(3) not null auto_increment,
  nome_candidato varchar(80) default null,
  login varchar(80) default null,
  senha varchar(15) default null,
  primary key (id)
);

/*
tabela de candidatos armazena telefone, 
email e candidato_id como chave estrangera
*/
create table contato_candidato (
id_tel_can int auto_increment primary key,
telefone varchar(20),
email varchar(80),
candidato_id int,
foreign key(candidato_id) references logins(id)
);
select * from contato_candidato;

/*
tabela de candidato armazena endereço dos candidatos
rua, numero, cidade, estado, cep e candidato id para fazer 
conexão com a tebela login
*/
create table endereco_candidato (
id_end_can int auto_increment primary key,
rua varchar(100),
numero varchar (10),
cidade varchar (50),
estado varchar(50),
cep varchar(10),
candidato_id int,
foreign key(candidato_id) references logins(id)
);

/*
tabela de logins das ong
armazena nome, cnpj, tipo de atuação da ONG
senha para logar. 
*/
create table login_ong (
id int(3) not null auto_increment,
  nome_ong varchar(80) default null,
  cnpj varchar (14) not null,
  atuacao varchar (200),
  login varchar(80) default null,
  senha varchar(15) default null,
  primary key (id)
);

/*
tabela de contatos de ONGs armazena
telefone, email, id de ong para conectar
a tabela login_ong
*/
create table contato (
id_tel int auto_increment primary key,
telefone varchar (15),
email varchar(80),
ong_id int,
foreign key(ong_id) references login_ong(id)
);

/*
tabela de endereço das ONGs 
armazena rua, numero, cidade, estado, cep e candidato id para fazer 
conexão com a tebela login_ong
*/
create table endereco (
id int auto_increment primary key,
rua varchar (100),
numero varchar(10),
cidade varchar (50),
estado varchar(50),
cep varchar (10),
ong_id int,
foreign key(ong_id) references login_ong(id)
);

/*
comandos para visualizar as tabelas no woekbench
*/
select * from logins;
select * from login_ong;
select * from contato;
select * from endereco;
select * from contato_candidato;




/*
esse comando é um experimento pra tentar criar um usuario
que tambem use workbench.
*/
create user 'VitorDev'@'%' identified by '051944';
grant all privileges on formulario.* to 'DouglasDev'@'%';
flush privileges;