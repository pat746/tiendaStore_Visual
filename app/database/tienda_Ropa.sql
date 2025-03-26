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

select* from productos;