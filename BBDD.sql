/* 1. CREAR LA BASE DE DATOS (SI NO EXISTE) */
CREATE DATABASE IF NOT EXISTS competicion
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

/* 2. USAR LA BASE DE DATOS CREADA */
USE competicion;

/* 3. BORRAR TABLAS ANTERIORES (SI EXISTEN) PARA EMPEZAR LIMPIO */
DROP TABLE IF EXISTS partidos;
DROP TABLE IF EXISTS equipos;

/* 4. CREAR LA TABLA 'equipos' */
CREATE TABLE equipos (
                         id_equipo INT AUTO_INCREMENT PRIMARY KEY,
                         nombre VARCHAR(100) NOT NULL UNIQUE,
                         estadio VARCHAR(100)
);

/* 5. CREAR LA TABLA 'partidos' */
CREATE TABLE partidos (
                          id_partido INT AUTO_INCREMENT PRIMARY KEY,
                          id_equipo_local INT NOT NULL,
                          id_equipo_visitante INT NOT NULL,
                          resultado CHAR(1),
                          estadio VARCHAR(100),
                          jornada INT NOT NULL,

    -- (Creamos las relaciones entre tablas)
                          FOREIGN KEY (id_equipo_local) REFERENCES equipos(id_equipo),
                          FOREIGN KEY (id_equipo_visitante) REFERENCES equipos(id_equipo),

    -- (La validación del enunciado para que no jueguen dos veces)
                          UNIQUE KEY (id_equipo_local, id_equipo_visitante)
);