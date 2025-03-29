create database tienda;

use tienda; 

create table productos
(
    id           int auto_increment primary key,
   tipo      enum('Falda' ,'Pantalon','Camisa','Polo','Short') not null ,
   genero        enum('F','M','U')not null default 'F' comment 'F= DAMA, M=HOMBRE , U= UNISEX',
   talla         Varchar(12) not null,
   precio        decimal(10,2) not null 

)ENGINE=INNODB;

INSERT INTO productos (tipo, genero, talla, precio)
VALUES 
('Falda', 'F', 'S', '25.99'),
('Pantalon', 'M', 'M', '45.50'),
('Camisa', 'F', 'L', '30.00'),
('Polo', 'M', 'XL', '20.00'),
('Short', 'U', 'M', '15.75');

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    NomUsuario VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    apellidoP VARCHAR(100) NOT NULL,
    apellidoM VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NOT NULL UNIQUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (NomUsuario, nombre, apellidoP, apellidoM, email, contrasena, telefono) VALUES
('jlopez23', 'Juan', 'López', 'Martínez', 'juan.lopez@example.com', 'claveSegura123', '987654321'),
('mgarcia89', 'María', 'García', 'Fernández', 'maria.garcia@example.com', 'pass1234', '987654322'),
('cperez77', 'Carlos', 'Pérez', 'Rodríguez', 'carlos.perez@example.com', 'secreto456', '987654323'),
('arojas56', 'Ana', 'Rojas', 'Sánchez', 'ana.rojas@example.com', 'miClave789', '987654324'),
('dfernandez12', 'Diego', 'Fernández', 'Gómez', 'diego.fernandez@example.com', '12345678', '987654325');



select* from productos;
select*from usuarios;