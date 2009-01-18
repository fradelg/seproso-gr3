-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 16-01-2009 a las 23:27:44
-- Versión del servidor: 5.0.67
-- Versión de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `grupo03`
--

--
-- Volcar la base de datos para la tabla `actividad`
--


--
-- Volcar la base de datos para la tabla `artefacto`
--


--
-- Volcar la base de datos para la tabla `configuracion`
--


--
-- Volcar la base de datos para la tabla `fase`
--


--
-- Volcar la base de datos para la tabla `modelo`
--


--
-- Volcar la base de datos para la tabla `participacion`
--


--
-- Volcar la base de datos para la tabla `periodovacacional`
--


--
-- Volcar la base de datos para la tabla `plantilla`
--


--
-- Volcar la base de datos para la tabla `proyecto`
--


--
-- Volcar la base de datos para la tabla `registrotrabajo`
--


--
-- Volcar la base de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `tipo`, `valor`) VALUES
(1, 'Jefe de proyecto', 1),
(2, 'Analista', 2),
(3, 'Diseñador', 3),
(4, 'Analista-programador', 3),
(5, 'Responsable equipo de pruebas', 3),
(6, 'Programador', 4),
(7, 'Probador', 4);

--
-- Volcar la base de datos para la tabla `tipoactividad`
--

INSERT INTO `tipoactividad` (`idTipoActividad`, `tipo`) VALUES
(1, 'Trato con usuarios (llamadas, citas individuales, etc)'),
(2, 'Reuniones externas'),
(3, 'Reuniones internas'),
(4, 'Lectura de especificaciones y todo tipo de documentación'),
(5, 'Elaboración de documentación (informes, documentos, programas)'),
(6, 'Desarrollo de programas'),
(7, 'Revisión de informes, programas, etc.'),
(8, 'Verificación de programas'),
(9, 'Formación de usuarios'),
(10, 'Varios (sin clasificar)');

--
-- Volcar la base de datos para la tabla `trabajador`
--

INSERT INTO `trabajador` (`Usuario_idUsuario`, `Rol_idRol`, `Proyecto_idProyecto`, `nombre`, `apellidos`, `edad`, `email`) VALUES
(0, 1, NULL, 'Ruben', 'Ruben Ruben', 25, 'ruben@ruben');

--
-- Volcar la base de datos para la tabla `trabajador_has_actividad`
--


--
-- Volcar la base de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nick`, `password`, `tipo`) VALUES
(1, 'pepe', 'pepe', 'admin'),
(2, 'fran', 'fran', 'manager'),
(3, 'ruben', 'ruben', 'personal'),
(4, 'abel', 'abel', 'developer');
