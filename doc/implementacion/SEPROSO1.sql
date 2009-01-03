-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 03-01-2009 a las 13:29:40
-- Versión del servidor: 5.1.30
-- Versión de PHP: 5.2.8
--
-- Versión 1.0
--

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `seproso`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--
-- Creación: 03-01-2009 a las 13:28:03
--

CREATE TABLE IF NOT EXISTS `actividad` (
  `idActividad` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Rol_idRol` int(10) unsigned NOT NULL,
  `Fase_idFase` int(10) unsigned NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` text,
  `inicio` date NOT NULL,
  `duracion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idActividad`),
  KEY `Actividad_FKIndex2` (`Fase_idFase`),
  KEY `Actividad_FKIndex3` (`Rol_idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `actividad`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artefacto`
--
-- Creación: 03-01-2009 a las 13:28:03
--

CREATE TABLE IF NOT EXISTS `artefacto` (
  `idArtefacto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`idArtefacto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `artefacto`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artefacto_has_actividad`
--
-- Creación: 03-01-2009 a las 13:28:03
--

CREATE TABLE IF NOT EXISTS `artefacto_has_actividad` (
  `Artefacto_idArtefacto` int(10) unsigned NOT NULL,
  `Actividad_idActividad` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Artefacto_idArtefacto`,`Actividad_idActividad`),
  KEY `Artefacto_has_Actividad_FKIndex1` (`Artefacto_idArtefacto`),
  KEY `Artefacto_has_Actividad_FKIndex2` (`Actividad_idActividad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `artefacto_has_actividad`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--
-- Creación: 03-01-2009 a las 13:04:45
--

CREATE TABLE IF NOT EXISTS `calendario` (
  `idCalendario` int(11) NOT NULL AUTO_INCREMENT,
  `Informe_idInforme` int(10) unsigned NOT NULL,
  `año` year(4) NOT NULL,
  `dias` int(31) unsigned NOT NULL,
  `marked` tinyint(1) NOT NULL,
  `mes` varchar(20) CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  PRIMARY KEY (`idCalendario`),
  KEY `Calendario_FKIndex1` (`Informe_idInforme`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `calendario`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--
-- Creación: 03-01-2009 a las 13:21:33
--

CREATE TABLE IF NOT EXISTS `configuracion` (
  `idConfiguracion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Usuario_idUsuario` int(10) unsigned NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `valor` varchar(20) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`idConfiguracion`),
  KEY `Configuracion_FKIndex1` (`Usuario_idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `configuracion`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fase`
--
-- Creación: 03-01-2009 a las 13:13:02
--

CREATE TABLE IF NOT EXISTS `fase` (
  `idFase` int(10) unsigned NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idFase`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `fase`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe`
--
-- Creación: 03-01-2009 a las 13:04:15
--

CREATE TABLE IF NOT EXISTS `informe` (
  `idInforme` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) NOT NULL,
  `fechaAct` date NOT NULL,
  `semInicio` int(10) unsigned NOT NULL,
  `semFinal` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idInforme`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `informe`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--
-- Creación: 03-01-2009 a las 13:05:30
--

CREATE TABLE IF NOT EXISTS `modelo` (
  `idModelo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Plantilla_idPlantilla` int(10) unsigned NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`idModelo`),
  KEY `Modelo_FKIndex2` (`Plantilla_idPlantilla`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `modelo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo_has_fase`
--
-- Creación: 03-01-2009 a las 13:15:17
--

CREATE TABLE IF NOT EXISTS `modelo_has_fase` (
  `Modelo_idModelo` int(10) unsigned NOT NULL,
  `Fase_idFase` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Modelo_idModelo`,`Fase_idFase`),
  KEY `Modelo_has_Fase_FKIndex1` (`Modelo_idModelo`),
  KEY `Modelo_has_Fase_FKIndex2` (`Fase_idFase`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `modelo_has_fase`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `participacion`
--
-- Creación: 03-01-2009 a las 13:17:45
--

CREATE TABLE IF NOT EXISTS `participacion` (
  `Proyecto_idProyecto` int(10) unsigned NOT NULL,
  `Rol_idRol` int(10) unsigned NOT NULL,
  `porc` int(11) NOT NULL,
  PRIMARY KEY (`Proyecto_idProyecto`),
  KEY `Participacion_FKIndex2` (`Proyecto_idProyecto`),
  KEY `Participacion_FKIndex3` (`Rol_idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `participacion`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodovacacional`
--
-- Creación: 03-01-2009 a las 13:28:03
--

CREATE TABLE IF NOT EXISTS `periodovacacional` (
  `idPeriodoVacacional` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Trabajador_Usuario_idUsuario` int(10) unsigned NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `duracion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idPeriodoVacacional`),
  KEY `PeriodoVacacional_FKIndex1` (`Trabajador_Usuario_idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `periodovacacional`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla`
--
-- Creación: 03-01-2009 a las 13:05:30
--

CREATE TABLE IF NOT EXISTS `plantilla` (
  `idPlantilla` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idPlantilla`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `plantilla`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto`
--
-- Creación: 03-01-2009 a las 13:05:30
--

CREATE TABLE IF NOT EXISTS `proyecto` (
  `idProyecto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Modelo_idModelo` int(10) unsigned NOT NULL,
  `Informe_idInforme` int(10) unsigned NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `año` year(4) NOT NULL,
  `presupuesto` double NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idProyecto`),
  KEY `Proyecto_FKIndex1` (`Informe_idInforme`),
  KEY `Proyecto_FKIndex2` (`Modelo_idModelo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `proyecto`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registrotrabajo`
--
-- Creación: 03-01-2009 a las 13:28:03
--

CREATE TABLE IF NOT EXISTS `registrotrabajo` (
  `idRegistroTrabajo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Trabajador_Usuario_idUsuario` int(10) unsigned NOT NULL,
  `Actividad_idActividad` int(10) unsigned NOT NULL,
  `inicio` date NOT NULL,
  `final` date NOT NULL,
  `esfuerzo` double NOT NULL,
  `fin` tinyint(1) NOT NULL,
  PRIMARY KEY (`idRegistroTrabajo`),
  KEY `RegistroTrabajo_FKIndex1` (`Actividad_idActividad`),
  KEY `RegistroTrabajo_FKIndex2` (`Trabajador_Usuario_idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `registrotrabajo`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--
-- Creación: 03-01-2009 a las 13:28:03
--

CREATE TABLE IF NOT EXISTS `rol` (
  `idRol` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) NOT NULL,
  `valor` int(11) NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `rol`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajador`
--
-- Creación: 03-01-2009 a las 13:28:03
--

CREATE TABLE IF NOT EXISTS `trabajador` (
  `Usuario_idUsuario` int(10) unsigned NOT NULL,
  `Rol_idRol` int(10) unsigned NOT NULL,
  `Actividad_idActividad` int(10) unsigned NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `edad` smallint(5) unsigned NOT NULL DEFAULT '18',
  `semVaca` date DEFAULT NULL,
  PRIMARY KEY (`Usuario_idUsuario`),
  KEY `Trabajador_FKIndex1` (`Usuario_idUsuario`),
  KEY `Trabajador_FKIndex2` (`Actividad_idActividad`),
  KEY `Trabajador_FKIndex3` (`Rol_idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcar la base de datos para la tabla `trabajador`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--
-- Creación: 03-01-2009 a las 13:17:45
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Participacion_Proyecto_idProyecto` int(10) unsigned NOT NULL,
  `nick` varchar(20) NOT NULL,
  `password_2` varchar(20) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  KEY `Usuario_FKIndex1` (`Participacion_Proyecto_idProyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `usuario`
--

