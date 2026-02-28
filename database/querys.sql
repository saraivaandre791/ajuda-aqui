create database formulario;
use formulario;

create table logins (
id int(3) not null auto_increment,
  nome_candidato varchar(80) default null,
  login varchar(80) default null,
  senha varchar(15) default null,
  primary key (id)
);
create table contato_candidato (
id_tel_can int auto_increment primary key,
telefone varchar(20),
email varchar(80),
candidato_id int,
foreign key(candidato_id) references logins(id)
);
select * from contato_candidato;

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

create table login_ong (
id int(3) not null auto_increment,
  nome_ong varchar(80) default null,
  cnpj varchar (14) not null,
  atuacao varchar (200),
  login varchar(80) default null,
  senha varchar(15) default null,
  primary key (id)
);


create table contato (
id_tel int auto_increment primary key,
telefone varchar (15),
email varchar(80),
ong_id int,
foreign key(ong_id) references login_ong(id)
);

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


select * from logins;
select * from login_ong;
select * from contato;
select * from endereco;
select * from contato_candidato;

INSERT INTO logins values (default, 'Andre Saraiva Batista', 'saraiva791', 'Cincity09!');

INSERT INTO logins values (default, 'Andre Saraiva Batista', 'saraiva791', '051944');

alter table logins
change plataforma nome_candidato varchar(80);

create user 'VitorDev'@'%' identified by '051944';
grant all privileges on formulario.* to 'DouglasDev'@'%';
flush privileges;