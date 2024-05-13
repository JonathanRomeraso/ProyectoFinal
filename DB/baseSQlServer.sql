create table usuario (
    id_usuario int identity,
    nombre varchar(100) not null,
    primer_apellido varchar(100),
    segundo_apellido varchar(100),
    password varchar(32) not null,
    correo varchar(100) not null unique,
    constraint checkPassword check (len(password) <= 32),
    constraint checkCorreo check (correo like '%_@__%.__%'),
    constraint usuarioPK primary key (id_usuario)
);

create table movimiento (
    id_movimiento smallint identity,
    movimiento varchar(50) not null,
    constraint movimientoPK primary key (id_movimiento)
);

create table institucion (
    id_institucion smallint identity,
    institucion varchar(50) not null,
    constraint institucionPK primary key (id_institucion)
);

create table metodo_pago(
    id_metodo_pago smallint identity,
    metodo_pago varchar(120),
    constraint metodo_pagoPK primary key (id_metodo_pago)
);
create table categoria (
    id_usuario int,
    id_categoria int,
    categoria varchar(50) not null,
    descripcion text,
    constraint categoriaFK1 foreign key (id_usuario) references usuario(id_usuario),
    constraint categoriaPK primary key (id_usuario, id_categoria)
);

create table transaccion (
    id_usuario int,
    id_transaccion int,
    fecha date not null,
    descripcion text,
    monto decimal(10, 2) not null,
    id_metodo_pago smallint not null,
    id_categoria int not null,
    id_movimiento smallint not null,
    id_institucion smallint,
    constraint transaccionFK1 foreign key (id_usuario) references usuario(id_usuario),
    constraint transaccionFK2 foreign key (id_usuario, id_categoria) references categoria(id_usuario, id_categoria),
    constraint transaccionFK3 foreign key (id_metodo_pago) references metodo_pago(id_metodo_pago),
    constraint transaccionFK4 foreign key (id_institucion) references institucion(id_institucion),
    constraint transaccionFK5 foreign key (id_movimiento) references movimiento(id_movimiento),
    constraint transaccionPK PRIMARY KEY (id_usuario, id_transaccion)
);





CREATE OR ALTER TRIGGER consecutivo_transaccion ON transaccion INSTEAD OF INSERT AS
BEGIN
    DECLARE @nuevo INT;
    SELECT @nuevo = ISNULL(MAX(id_transaccion), 0) + 1
    FROM transaccion
    WHERE id_usuario = (SELECT id_usuario FROM INSERTED)

    INSERT INTO transaccion (id_usuario, id_transaccion, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento, id_institucion)
    SELECT id_usuario, @nuevo, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento, id_institucion
    FROM INSERTED;
END;


CREATE OR ALTER TRIGGER consecutivo_categoria ON categoria INSTEAD OF INSERT AS
BEGIN
    DECLARE @nuevo INT;

    SELECT @nuevo = ISNULL(MAX(id_categoria), 0) + 1
    FROM categoria
    WHERE id_usuario = (SELECT id_usuario FROM INSERTED)

    INSERT INTO categoria (id_usuario, id_categoria, categoria, descripcion)
    SELECT id_usuario, @nuevo, categoria, descripcion
    FROM INSERTED;
END;

insert into usuario (nombre, primer_apellido, segundo_apellido, password, correo) values ('Jon', 'J', 'R', '123', '11d1@dd.co')
insert into usuario (nombre, primer_apellido, segundo_apellido, password, correo) values ('Jon', 'J', 'R', '123', '11d1@dd.caaa')
insert into usuario (nombre, primer_apellido, segundo_apellido, password, correo) values ('Jon', 'J', 'R', '123', '11d1@dd.coma')

insert into movimiento (movimiento) values ('ingreso');
insert into movimiento (movimiento) values ('egreso');

insert into institucion (institucion) values ('Azteca')
insert into institucion (institucion) values ('Banamex')

insert into metodo_pago( metodo_pago) VALUES ( 'Efectivo')
insert into metodo_pago( metodo_pago) VALUES ( 'Credito')
insert into metodo_pago( metodo_pago) VALUES ('Debito')

insert into categoria (id_usuario, categoria, descripcion) VALUES (1,'Entretenimiento', 'NAada');
insert into categoria (id_usuario, categoria, descripcion) VALUES (4,'Entretenimiento', 'NAada');
insert into categoria (id_usuario, categoria, descripcion) VALUES (1,'General', 'NAada');
insert into categoria (id_usuario, categoria, descripcion) VALUES (1,'General', 'NAada');



insert into transaccion (id_usuario, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento) VALUES (1,'2007-01-30','FFF',500,1,1,1);
    insert into transaccion (id_usuario, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento) VALUES (1,'2007-01-02','FFF',500,1,1,1);
    insert into transaccion (id_usuario, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento) VALUES (1,'2007-01-3','FFF',500,1,1,1);
    insert into transaccion (id_usuario, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento) VALUES (1,'2007-01-29','FFF',500,1,1,1);
    insert into transaccion (id_usuario, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento) VALUES (1,'2007-01-15','FFF',500,1,1,1);
insert into transaccion (id_usuario, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento) VALUES (4,'2007-01-30','FFF',500,1,1,1);
    insert into transaccion (id_usuario, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento) VALUES (4,'2007-01-02','FFF',500,1,1,1);
    insert into transaccion (id_usuario, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento) VALUES (4,'2007-01-3','FFF',500,1,1,1);
    insert into transaccion (id_usuario, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento) VALUES (4,'2007-01-29','FFF',500,1,1,1);
    insert into transaccion (id_usuario, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento) VALUES (4,'2007-01-15','FFF',500,1,1,1);
insert into transaccion (id_usuario, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento) VALUES (1,'2007-01-29','FFF',500,1,1,1);
    insert into transaccion (id_usuario, fecha, descripcion, monto, id_metodo_pago, id_categoria, id_movimiento) VALUES (1,'2007-01-15','FFF',500,1,1,1);



