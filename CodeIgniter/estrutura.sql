create table sys_metodos {
  id int(10) not null auto_increment,
  classe varchar(45) not null,
  metodo varchar(45) not null,
  apelido varchar(255) not null,
  privado tinyint(1),
  primary key(id)
};

create table tb_usuarios {
  id int(10) not null auto_increment,
  cnpj bigint(14) not null,
  login varchar(150) not null,
  senha varchar(200) not null,
  nome varchar(30) not null,
  email varchar(50) not null,
  primary key (id)
};

create table sys_permissoes {
  id int(10) not null auto_increment,
  id_metodo int(10) not null,
  id_usuario int(10) not null,
  primary key (id),
  key `IDX_usuario` (id_usuario),
  key `IDX_metodo` (id_metodo),
  constraint `FK_usuario` foreign key (id_usuario)
    references usuario(id) on update cascade on delete restrict,
  constraint `FK_metodo` foreign key (id_metodo)
    references metodo(id) on update cascade on delete restrict
};