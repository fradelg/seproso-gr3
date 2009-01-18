--
-- BASE DE DATOS DE SEPROSO - GRUPO 3 - UVA
-- Base de datos: grupo03
--
-- Creación de la estructura de todas las tablas de la base de datos
-- e inserción de los datos predefinidos en las especificaciones del usuario
--

DROP TABLE IF EXISTS `Actividad`;
CREATE TABLE `Actividad` (
  `idActividad` int(10) unsigned NOT NULL auto_increment,
  `idFase` int(10) unsigned NOT NULL,
  `idTipo` int(10) unsigned NOT NULL,
  `idArtefacto` int(10) unsigned NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` text,
  `inicio` date NOT NULL,
  `tiempoEstimado` int(10) unsigned NOT NULL,
  `tiempoReal` int(10) unsigned NOT NULL,
  `fin` tinyint(1) NOT NULL,
  PRIMARY KEY (`idActividad`),
  FOREIGN KEY (`idFase`) REFERENCES `Fase` (`idFase`),
  FOREIGN KEY (`idTipo`) REFERENCES `TipoActividad` (`idTipoActividad`),
  FOREIGN KEY (`idArtefacto`) REFERENCES `Artefacto` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Artefacto`;
CREATE TABLE `Artefacto` (
  `nombre` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Configuracion`;
CREATE TABLE `Configuracion` (
  `parametro` varchar(20) NOT NULL,
  `valor` varchar(20) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`parametro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Fase`;
CREATE TABLE `Fase` (
  `idFase` int(10) unsigned NOT NULL auto_increment,
  `idModelo` int(10) unsigned NOT NULL,
  `idFasePadre` int(10) unsigned NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(45) default NULL,
  PRIMARY KEY (`idFase`),
  FOREIGN KEY (`idModelo`) REFERENCES `Modelo` (`idModelo`),
  FOREIGN KEY (`idFasePadre`) REFERENCES `Fase` (`idFase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `Fase` (`idFase`, `idModelo`, `idFasePadre`, `nombre`, `descripcion`) VALUES
(1, 1, NULL, 'Análisis', NULL),
(2, 1, NULL, 'Diseño', NULL),
(3, 1, NULL, 'Implementación', NULL),
(4, 1, NULL, 'Pruebas', NULL),
(5, 2, NULL, 'Inicio', NULL),
(6, 2, NULL, 'Elaboración', NULL),
(7, 2, NULL, 'Construcción', NULL),
(8, 2, NULL, 'Producción', NULL);

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Modelo`;
CREATE TABLE `Modelo` (
  `idModelo` int(10) unsigned NOT NULL auto_increment,
  `plantilla` int(10) unsigned NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` text default NULL,
  PRIMARY KEY (`idModelo`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `modelo` (`idModelo`, `plantilla`, `nombre`, `descripcion`) VALUES
(1, 'Proceso en cascada', 'Proceso en cascada', 'Todas las fases siguen un desarrollo secuencial.'),
(2, 'Proceso unificado', 'Proceso unificado', 'Es iterativo e incremental. En cada iteración se pueden desarrollar las disciplinas habituales de Ingeniería del Software (Análisis, Implementación, etc)');

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Participacion`;
CREATE TABLE `Participacion` (
  `idUsuario` varchar(50) NOT NULL,
  `idProyecto` varchar(45) NOT NULL,
  `idRol` int(10) unsigned NOT NULL,
  `porcentaje` int(11) NOT NULL,
  PRIMARY KEY (`idUsuario`,`idProyecto`),
  FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`nick`),
  FOREIGN KEY (`idProyecto`) REFERENCES `Proyecto` (`titulo`),
  FOREIGN KEY (`idRol`) REFERENCES `Rol` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `PeriodoVacacional`;
CREATE TABLE `PeriodoVacacional` (
  `fechaInicio` date NOT NULL,
  `idUsuario` varchar(50) NOT NULL,
  `duracion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`fechaInicio`, `idUsuario`),
  FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`nick`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Proyecto`;
CREATE TABLE `Proyecto` (
  `titulo` varchar(45) NOT NULL,
  `idJefe` int(10) unsigned NOT NULL,
  `idModelo` int(10) unsigned NOT NULL,
  `descripcion` text default NULL,
  `fecha` date NOT NULL,
  `presupuesto` double NOT NULL,
  `activo` tinyint(1) NOT NULL default '0',
  PRIMARY KEY (`titulo`),
  FOREIGN KEY (`idJefe`) REFERENCES `Usuario` (`nick`),
  FOREIGN KEY (`idModelo`) REFERENCES `Modelo` (`idModelo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;  

-- --------------------------------------------------------

DROP TABLE IF EXISTS `RegistroTrabajo`;
CREATE TABLE `RegistroTrabajo` (
  `idRegistroTrabajo` int(10) unsigned NOT NULL auto_increment,
  `idUsuario` varchar(50) NOT NULL,
  `idActividad` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `inicio` date NOT NULL,
  `final` date NOT NULL,
  `esfuerzo` double NOT NULL,
  `fin` tinyint(1) NOT NULL,
  `comentario` text,
  PRIMARY KEY (`idRegistroTrabajo`),
  FOREIGN KEY (`idActividad`) REFERENCES `Actividad` (`idActividad`),
  FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`nick`);  
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Rol`;
CREATE TABLE `Rol` (
  `tipo` varchar(45) NOT NULL,
  `valor` int(11) NOT NULL,
  PRIMARY KEY  (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Tipos de roles permitidos

INSERT INTO `rol` (`idRol`, `tipo`, `valor`) VALUES
(1, 'Jefe de proyecto', 1),
(2, 'Analista', 2),
(3, 'Diseñador', 3),
(4, 'Analista-programador', 3),
(5, 'Responsable equipo de pruebas', 3),
(6, 'Programador', 4),
(7, 'Probador', 4),
(8, 'Jefe de personal', 4);

-- --------------------------------------------------------

DROP TABLE IF EXISTS `TipoActividad`;
CREATE TABLE `TipoActividad` (
  `idTipoActividad` int(10) unsigned NOT NULL auto_increment,
  `tipo` varchar(255) default NULL,
  PRIMARY KEY (`idTipoActividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Tipos de actividad predefinidos

INSERT INTO `TipoActividad` (`idTipoActividad`, `tipo`) VALUES
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

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Trabajador`;
CREATE TABLE `Trabajador` (
  `idUsuario` varchar(50) NOT NULL,
  `idRol` int(10) unsigned NOT NULL,
  `idProyecto` varchar(45),
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `fnacimiento` date NOT NULL,
  FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`nick`),
  FOREIGN KEY (`idRol`) REFERENCES `Rol` (`tipo`),
  FOREIGN KEY (`idProyecto`) REFERENCES `Proyecto` (`titulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Trabajador_has_Actividad`;
CREATE TABLE `Trabajador_has_Actividad` (
  `idUsuario` varchar(50) NOT NULL,
  `idActividad` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idUsuario`,`idActividad`),
  FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`nick`) ON DELETE CASCADE,
  FOREIGN KEY (`idActividad`) REFERENCES `Actividad` (`idActividad`),
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Usuario`;
CREATE TABLE `Usuario` (
  `nick` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(255) default NULL,
  `tipo` varchar(50) default NULL,
  PRIMARY KEY (`nick`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Datos del administrador de SEPROSO

INSERT INTO `Usuario` (`nick`, `password`, `email`, `tipo`) VALUES 
('admin', 'admin', 'admin@seproso.es', 'admin');
