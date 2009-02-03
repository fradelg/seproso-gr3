--
-- BASE DE DATOS DE SEPROSO - GRUPO 3 - UVA
-- Base de datos: grupo03

--
-- Borrado de las tablas de la base de datos atendiendo a las dependencias
--

DROP TABLE IF EXISTS `Actividad_Predecesora`;
DROP TABLE IF EXISTS `Trabajador_has_Actividad`;
DROP TABLE IF EXISTS `PeriodoVacacional`;
DROP TABLE IF EXISTS `Configuracion`;
DROP TABLE IF EXISTS `Participacion`;
DROP TABLE IF EXISTS `Trabajador`;
DROP TABLE IF EXISTS `RegistroTrabajo`;
DROP TABLE IF EXISTS `Proyecto`;
DROP TABLE IF EXISTS `Rol`;
DROP TABLE IF EXISTS `Actividad`;
DROP TABLE IF EXISTS `TipoActividad`;
DROP TABLE IF EXISTS `Usuario`;
DROP TABLE IF EXISTS `Fase`;
DROP TABLE IF EXISTS `Modelo`;
DROP TABLE IF EXISTS `Artefacto`;

--
-- Creación de la estructura de todas las tablas de la base de datos
-- e inserción de los datos predefinidos en las especificaciones del usuario
--

-- --------------------------------------------------------

CREATE TABLE `TipoActividad` (
  `idTipoActividad` int(10) unsigned NOT NULL auto_increment,
  `tipo` varchar(255) not NULL,
  PRIMARY KEY (`idTipoActividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

CREATE TABLE `Rol` (
  `tipo` varchar(45) NOT NULL,
  `valor` int(11) NOT NULL
  PRIMARY KEY  (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE `Trabajador_has_Actividad` (
  `idUsuario` varchar(50) NOT NULL,
  `idActividad` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idUsuario`,`idActividad`),
  INDEX (`idUsuario`),
  INDEX (`idActividad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE `Actividad` (
  `idActividad` int(10) unsigned NOT NULL auto_increment,
  `idFase` int(10) unsigned NOT NULL,
  `idTipo` int(10) unsigned NOT NULL,
  `idArtefacto` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` text,
  `inicioEstimado` date NOT NULL,
  `inicioReal` date,
  `tiempoEstimado` float unsigned NOT NULL,
  `tiempoReal` float unsigned,
  `estado` int(2) NOT NULL default '0',
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

CREATE TABLE `Artefacto` (
  `nombre` varchar(45) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE `Configuracion` (
  `parametro` varchar(20) NOT NULL,
  `valor` varchar(20) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`parametro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

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

CREATE TABLE `Modelo` (
  `idModelo` int(10) unsigned NOT NULL auto_increment,
  `plantilla` varchar(45) default NULL,
  `nombre` varchar(45) NOT NULL,
  `descripcion` text default NULL,
  PRIMARY KEY (`idModelo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

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

CREATE TABLE `PeriodoVacacional` (
  `idUsuario` varchar(50) NOT NULL,
  `fechaInicio` date NOT NULL,
  `duracion` int(10) unsigned NOT NULL,
  `razon` text default NULL,
  PRIMARY KEY (`fechaInicio`, `idUsuario`),
  INDEX (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

CREATE TABLE `Proyecto` (
  `titulo` varchar(45) NOT NULL,
  `idJefe` varchar(50) NOT NULL,
  `idModelo` int(10) unsigned NOT NULL,
  `descripcion` text default NULL,
  `fecha` date NOT NULL,
  `presupuesto` float NOT NULL,
  `estado` int(2) NOT NULL default '0',
  PRIMARY KEY (`titulo`),
  INDEX (`idJefe`),
  INDEX (`idModelo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;  

-- --------------------------------------------------------

CREATE TABLE `RegistroTrabajo` (
  `idRegistroTrabajo` int(10) unsigned NOT NULL auto_increment,
  `idUsuario` varchar(50) NOT NULL,
  `idActividad` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `inicio` date NOT NULL,
  `final` date NOT NULL,
  `esfuerzo` float NOT NULL,
  `estado` int(2) NOT NULL default '0',
  `comentario` text,
  PRIMARY KEY (`idRegistroTrabajo`),
  INDEX (`idActividad`),
  INDEX (`idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

CREATE TABLE `Usuario` (
  `nick` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  PRIMARY KEY (`nick`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

CREATE TABLE `Trabajador` (
  `idUsuario` varchar(50) NOT NULL,
  `idRol` varchar(45) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `fnacimiento` date NOT NULL,
  INDEX (`idUsuario`),
  INDEX (`idRol`)
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
  ADD FOREIGN KEY (`idRol`) REFERENCES `Rol` (`tipo`);

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
  
ALTER TABLE `Actividad_Predecesora`
  ADD FOREIGN KEY (`actividad`) REFERENCES `Actividad` (`idActividad`),
  ADD FOREIGN KEY (`predecesora`) REFERENCES `Actividad` (`idActividad`);

--
-- Adición de los datos predefinidos de algunas tablas
--

-- Modelos de proceso básicos

INSERT INTO `Modelo` (`idModelo`, `plantilla`, `nombre`, `descripcion`) VALUES
(1, NULL, 'Sin modelo de proceso', 'Modelo por defecto asignado a un proyecto al ser creado.'),
(2, 'Modelo en cascada', 'Proceso en cascada', 'Todas las fases siguen un desarrollo secuencial.'),
(3, 'Modelo en espiral', 'Proceso en espiral', 'Es iterativo e incremental. En cada iteración se pueden desarrollar las disciplinas habituales de Ingeniería del Software (Análisis, Implementación, etc)');


INSERT INTO `Fase` (`idFase`, `idModelo`, `idFasePadre`, `nombre`, `descripcion`) VALUES
(1, 2, NULL, 'Definici&oacute;n de requisitos', 'Se analizan las necesidades de los usuarios finales del software para determinar que objetivos debe cubrir. De esta fase surge una memoria llamada SRD (documento de especificaci&oacute;n de requisitos).'),
(2, 2, NULL, 'An&aacute;lisis y dise&ntilde;o', 'Se descompone y organiza el sistema en elementos que puedan elaborarse por separado, aprovechando las ventajas del desarrollo en equipo. Como resultado surge el SDD (Documento de Dise&ntilde;o del Software). Desarrollo de los algoritmos necesarios. Identificaci&oacute;n de herramientas.'),
(3, 2, NULL, 'Implementaci&oacute;n y test unitarios', 'Desarrollo de los algoritmos necesarios. Identificaci&oacute;n de herramientas.Codificaci&oacute;n.'),
(4, 2, NULL, 'Integraci&oacute;n y test de sistema', 'Los elementos, ya programados, se ensamblan para componer el sistema y se comprueba que funciona correctamente antes de ser puesto en explotaci&oacute;n.'),
(5, 2, NULL, 'Operacici&oacute;n y mantenimiento', 'El software obtenido se pone en producci&oacute;n.'),
(6, 2, NULL, 'Pruebas', 'Los elementos, ya testeados se preparan para la integraci&oacute;n final y su puesta en funcionamiento.'),
(7, 3, NULL, 'Planificaci&oacute;n', 'Determinaci&oacute;n de objetivos. Fijar restricciones y fijar tambi&eacute;n los productos definidos a obtener: requerimientos, especificaci&oacute;n, manual de usuario.'),
(8, 3, NULL, 'An&aacute;lisis de riesgos', 'Identificaci&oacute;n de riesgos del proyecto y estrategias alternativas para evitarlos. Se estudian todos los riesgos potenciales y se seleccionan una o varias alternativas propuestas para reducir o eliminar los riesgos.'),
(9, 3, NULL, 'Ingenier&iacute;a', 'Tareas de la actividad propia y de prueba.'),
(10, 3, NULL, 'Construcci&oacute;n y entrega', 'Desarrollo de la parte proporcional de la iteraci&oacute;n y entrega del producto obtenido al usuario final-'),
(11, 3, NULL, 'Evaluaci&oacute;n del cliente', 'Reevaluar la iteracci&oacute;n actual por parte del usuario final y determinaci&oacute;n de nuevos artefactos para la siguiente iteraci&oacute;n');

-- Tipos de roles permitidos

INSERT INTO `Rol` (`tipo`, `valor`, `usuario`) VALUES
('Administrador', 0),
('Jefe de personal', 0),
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
(4, 'Lectura de especificaciones y todo tipo de documentaci&oacute;n'),
(5, 'Elaboraci&oacute;n de documentaci&oacute;n (informes, documentos, programas)'),
(6, 'Desarrollo de programas'),
(7, 'Revisi&oacute;n de informes, programas, etc.'),
(8, 'Verificaci&oacute;n de programas'),
(9, 'Formaci&oacute;n de usuarios'),
(10, 'Varios (sin clasificar)');

-- Datos de cada tipo de usuario de SEPROSO

INSERT INTO `Usuario` (`nick`, `password`, `email`, `tipo`) VALUES 
('admin', 'admin', 'admin@seproso.es', 'admin'),
('manager', 'manager', 'manager@seproso.es', 'manager'),
('developer', 'developer', 'developer@seproso.es', 'developer'),
('personal', 'personal', 'personal@seproso.es', 'personal');

-- Parámetros configurables

INSERT INTO `Configuracion` (`parametro`, `valor`, `descripcion`) VALUES 
('partipacion_max', 4, 'M&aacute;ximo n&uacute;mero de proyectos en que puede participar un trabajador.');