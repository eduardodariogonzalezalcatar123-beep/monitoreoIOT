CREATE DATABASE IF NOT EXISTS monitoreo;
USE monitoreo;



CREATE TABLE esp32_master (

    id_master INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    direccion_ip VARCHAR(45),
    ultima_conexion DATETIME,
    estado ENUM('activo','inactivo','mantenimiento')

);



CREATE TABLE esp32_esclavo (

    id_esclavo INT AUTO_INCREMENT PRIMARY KEY,
    id_master INT,
    nombre VARCHAR(50),
    ubicacion VARCHAR(100),
    ultima_conexion DATETIME,
    estado ENUM('activo','inactivo','mantenimiento'),

    FOREIGN KEY (id_master)
        REFERENCES esp32_master(id_master)
        ON DELETE CASCADE
);



CREATE TABLE sensores (

    id_sensor INT AUTO_INCREMENT PRIMARY KEY,
    id_esclavo INT,

    tipo VARCHAR(50),
    nombre VARCHAR(50),

    limite_min DECIMAL(10,2),
    limite_max DECIMAL(10,2),

    estado_actual ENUM(
        'normal',
        'preventivo_bajo',
        'preventivo_alto',
        'critico_bajo',
        'critico_alto'
    ),

    ultima_lectura DECIMAL(10,2),
    ultima_fecha DATETIME,

    FOREIGN KEY (id_esclavo)
        REFERENCES esp32_esclavo(id_esclavo)
        ON DELETE CASCADE
);



CREATE TABLE registros (

    id_registro BIGINT AUTO_INCREMENT PRIMARY KEY,

    id_sensor INT,
    valor DECIMAL(10,2),
    fecha DATETIME,

    estado_calculado ENUM(
        'normal',
        'preventivo_bajo',
        'preventivo_alto',
        'critico_bajo',
        'critico_alto'
    ),

    desviacion DECIMAL(10,2),
    nivel_severidad TINYINT,

    FOREIGN KEY (id_sensor)
        REFERENCES sensores(id_sensor)
        ON DELETE CASCADE
);



CREATE TABLE alertas (

    id_alerta BIGINT AUTO_INCREMENT PRIMARY KEY,

    id_sensor INT,

    tipo_alerta ENUM(
        'preventivo_bajo',
        'preventivo_alto',
        'critico_bajo',
        'critico_alto'
    ),

    valor DECIMAL(10,2),
    fecha DATETIME,

    FOREIGN KEY (id_sensor)
        REFERENCES sensores(id_sensor)
        ON DELETE CASCADE
);