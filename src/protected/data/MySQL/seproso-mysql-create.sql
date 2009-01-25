--
-- BASE DE DATOS DE SEPROSO - GRUPO 3 - UVA
-- Base de datos: grupo03
--
-- Creación de la estructura de todas las tablas de la base de datos
-- e inserción de los datos predefinidos en las especificaciones del usuario
--

-- --------------------------------------------------------

DROP TABLE IF EXISTS `TipoActividad`;
CREATE TABLE `TipoActividad` (
  `idTipoActividad` int(10) unsigned NOT NULL auto_increment,
  `tipo` varchar(255) not NULL,
  PRIMARY KEY (`idTipoActividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Rol`;
CREATE TABLE `Rol` (
  `tipo` varchar(45) NOT NULL,
  `valor` int(11) NOT NULL,
  PRIMARY KEY  (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Trabajador_has_Actividad`;
CREATE TABLE `Trabajador_has_Actividad` (
  `idUsuario` varchar(50) NOT NULL,
  `idActividad` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idUsuario`,`idActividad`),
  INDEX (`idUsuario`),
  INDEX (`idActividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Actividad`;
CREATE TABLE `Actividad` (
  `idActividad` int(10) unsigned NOT NULL auto_increment,
  `idFase` int(10) unsigned NOT NULL,
  `idTipo` int(10) unsigned NOT NULL,
  `idArtefacto` varchar(45) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` text,
  `inicioEstimado` date NOT NULL,
  `inicioReal` date,
  `tiempoEstimado` int(10) unsigned NOT NULL,
  `tiempoReal` int(10) unsigned,
  `estado` int(2) NOT NULL,
  PRIMARY KEY (`idActividad`),
  INDEX (`idFase`),
  INDEX (`idTipo`),
  INDEX (`idArtefacto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

CREATE TABLE `Actividad_Predecesora` (
  `actividad` int(10) unsigned NOT NULL,
  `predecesora` int(10) unsigned NOT NULL,
  PRIMARY KEY (`actividad`, `predecesora`),
  INDEX (`actividad`),
  INDEX (`predecesora`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Artefacto`;
CREATE TABLE `Artefacto` (
  `nombre` varchar(45) NOT NULL,
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
  `idFasePadre` int(10) unsigned,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text default NULL,
  PRIMARY KEY (`idFase`),
  INDEX (`idModelo`),
  INDEX (`idFasePadre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Modelo`;
CREATE TABLE `Modelo` (
  `idModelo` int(10) unsigned NOT NULL auto_increment,
  `plantilla` varchar(45) default NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` text default NULL,
  PRIMARY KEY (`idModelo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Participacion`;
CREATE TABLE `Participacion` (
  `idUsuario` varchar(50) NOT NULL,
  `idProyecto` varchar(45) NOT NULL,
  `idRol` varchar(45) NOT NULL,
  `porcentaje` int(11) unsigned NOT NULL,
  PRIMARY KEY (`idUsuario`,`idProyecto`),
  INDEX (`idUsuario`),
  INDEX (`idProyecto`),
  INDEX (`idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `PeriodoVacacional`;
CREATE TABLE `PeriodoVacacional` (
  `idUsuario` varchar(50) NOT NULL,
  `fechaInicio` date NOT NULL,
  `duracion` int(10) unsigned NOT NULL,
  `razon` text default NULL,
  PRIMARY KEY (`fechaInicio`, `idUsuario`),
  INDEX (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Proyecto`;
CREATE TABLE `Proyecto` (
  `titulo` varchar(45) NOT NULL,
  `idJefe` varchar(50) NOT NULL,
  `idModelo` int(10) unsigned NOT NULL,
  `descripcion` text default NULL,
  `fecha` date NOT NULL,
  `presupuesto` double NOT NULL,
  `activo` tinyint(1) NOT NULL default '0',
  PRIMARY KEY (`titulo`),
  INDEX (`idJefe`),
  INDEX (`idModelo`)
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
  `estado` int(2) NOT NULL,
  `comentario` text,
  PRIMARY KEY (`idRegistroTrabajo`),
  INDEX (`idActividad`),
  INDEX (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Usuario`;
CREATE TABLE `Usuario` (
  `nick` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`nick`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `Trabajador`;
CREATE TABLE `Trabajador` (
  `idUsuario` varchar(50) NOT NULL,
  `idRol` varchar(45) NOT NULL,
  `idProyecto` varchar(45),
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `fnacimiento` date NOT NULL,
  INDEX (`idUsuario`),
  INDEX (`idRol`),
  INDEX (`idProyecto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Adición de claves foráneas y referencias en las tablas
--

ALTER TABLE `PeriodoVacacional`
  ADD FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`nick`);

ALTER TABLE `RegistroTrabajo`
  ADD FOREIGN KEY (`idActividad`) REFERENCES `Actividad` (`idActividad`),
  ADD FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`nick`);

ALTER TABLE `Proyecto`
  ADD FOREIGN KEY (`idJefe`) REFERENCES `Usuario` (`nick`),
  ADD FOREIGN KEY (`idModelo`) REFERENCES `Modelo` (`idModelo`);

ALTER TABLE `Trabajador`
  ADD FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`nick`) ON DELETE CASCADE,
  ADD FOREIGN KEY (`idRol`) REFERENCES `Rol` (`tipo`),
  ADD FOREIGN KEY (`idProyecto`) REFERENCES `Proyecto` (`titulo`);

ALTER TABLE `Trabajador_has_Actividad`
  ADD FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`nick`),
  ADD FOREIGN KEY (`idActividad`) REFERENCES `Actividad` (`idActividad`);

ALTER TABLE `Participacion`
  ADD FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`nick`),
  ADD FOREIGN KEY (`idProyecto`) REFERENCES `Proyecto` (`titulo`),
  ADD FOREIGN KEY (`idRol`) REFERENCES `Rol` (`tipo`);

ALTER TABLE `Fase`
  ADD FOREIGN KEY (`idModelo`) REFERENCES `Modelo` (`idModelo`);

ALTER TABLE `Actividad`
  ADD FOREIGN KEY (`idFase`) REFERENCES `Fase` (`idFase`),
  ADD FOREIGN KEY (`idTipo`) REFERENCES `TipoActividad` (`idTipoActividad`),
  ADD FOREIGN KEY (`idArtefacto`) REFERENCES `Artefacto` (`nombre`);
  
ALTER TABLE `Actividad_predecesora`
  ADD FOREIGN KEY (`actividad`) REFERENCES `Actividad` (`idActividad`),
  ADD FOREIGN KEY (`predecesora`) REFERENCES `Actividad` (`idActividad`);

--
-- Adición de los datos predefinidos de algunas tablas
--

-- Modelos de proceso básicos

INSERT INTO `Modelo` (`idModelo`, `plantilla`, `nombre`, `descripcion`) VALUES
(1, 'Proceso en cascada', 'Proceso en cascada', 'Todas las fases siguen un desarrollo secuencial.'),
(2, 'Proceso unificado', 'Proceso unificado', 'Es iterativo e incremental. En cada iteración se pueden desarrollar las disciplinas habituales de Ingeniería del Software (Análisis, Implementación, etc)');

INSERT INTO `Fase` (`idFase`, `idModelo`, `idFasePadre`, `nombre`, `descripcion`) VALUES
(1, 1, NULL, 'Análisis', NULL),
(2, 1, NULL, 'Diseño', NULL),
(3, 1, NULL, 'Implementación', NULL),
(4, 1, NULL, 'Pruebas', NULL),
(5, 2, NULL, 'Inicio', NULL),
(6, 2, NULL, 'Elaboración', NULL),
(7, 2, NULL, 'Construcción', NULL),
(8, 2, NULL, 'Producción', NULL);

-- Tipos de roles permitidos

INSERT INTO `Rol` (`tipo`, `valor`) VALUES
('Jefe de proyecto', 1),
('Analista', 2),
('Dise&ntilde;ador', 3),
('Analista-programador', 3),
('Responsable equipo de pruebas', 3),
('Programador', 4),
('Probador', 4);

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

-- Datos del administrador de SEPROSO

INSERT INTO `Usuario` (`nick`, `password`, `email`, `tipo`) VALUES 
('admin', 'admin', 'admin@seproso.es', 'admin');

-- Parámetros configurables

INSERT INTO `Configuracion` (`parametro`, `valor`, `descripcion`) VALUES 
('partipacion_max', 4, 'Maximo número de proyectos en que puede participar un trabajador.');
