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
  
ALTER TABLE `Actividad_Predecesora`
  ADD FOREIGN KEY (`actividad`) REFERENCES `Actividad` (`idActividad`),
  ADD FOREIGN KEY (`predecesora`) REFERENCES `Actividad` (`idActividad`);

--
-- Adición de los datos predefinidos de algunas tablas
--

-- Modelos de proceso básicos

INSERT INTO `Modelo` (`idModelo`, `plantilla`, `nombre`, `descripcion`) VALUES
(1, 'Modelo en cascada', 'Proceso en cascada', 'Es el enfoque metodológico que ordena rigurosamente las etapas del ciclo de vida del software, de forma tal que el inicio de cada etapa debe esperar a la finalización de la inmediatamente anterior. 
	Fases del Modelo. Metodología de desarrollo en cascada:

   1. Análisis de requisitos.
   Se analizan las necesidades de los usuarios finales del software para determinar qué objetivos debe cubrir. De esta fase surge una memoria llamada SRD (documento de especificación de requisitos).
   
   2. Diseño del Sistema
   Se descompone y organiza el sistema en elementos que puedan elaborarse por separado, aprovechando las ventajas del desarrollo en equipo. Como resultado surge el SDD (Documento de Diseño del Software).
   
   3. Diseño del Programa
   Desarrollo de los algoritmos necesarios. Identificación de herramientas.
   
   4. Codificación
   Fase de programación.
   
   5. Pruebas
   Los elementos, ya programados, se ensamblan para componer el sistema y se comprueba que funciona correctamente antes de ser puesto en explotación.
   
   6. Implantación
   El software obtenido se pone en producción.
   
   7. Mantenimiento

'),
(2, 'Modelo en espiral', 'Proceso en espiral', 'Es iterativo e incremental. En cada iteración se pueden desarrollar las disciplinas habituales de Ingeniería del Software (Análisis, Implementación, etc).
	Las actividades no están fijadas a priori, sino que las siguientes se eligen en función del análisis de riesgo, comenzando por el bucle interior.
	En cada vuelta o iteración hay que tener en cuenta:
	Los Objetivos: Que necesidad debe cubrir el producto.
	Alternativas: Las diferentes formas de conseguir los objetivos de forma exitosa, desde diferentes puntos de vista como pueden ser:
		1. Características: experiencia del personal, requisitos a cumplir, etc.
		2. Formas de gestión del sistema.
		3. Riesgo asumido con cada alternativa.
	Desarrollar y Verificar: Programar y probar el software.
	
	Si el resultado no es el adecuado o se necesita implementar mejoras o funcionalidades.
	
	Se planificaran los siguientes pasos y se comienza un nuevo ciclo de la espiral. La espiral tiene una forma de caracola y se dice que mantiene dos dimensiones, la radial y la angular:
		1. Angular: Indica el avance del proyecto software dentro de un ciclo.
		2. Radial: Indica el aumento del coste del proyecto, ya que con cada nueva iteración se pasa más tiempo desarrollando.

	Este sistema es muy utilizado en proyectos grandes y complejos como puede ser, por ejemplo, la creación de un Sistema Operativo.
	
	');

INSERT INTO `Fase` (`idFase`, `idModelo`, `idFasePadre`, `nombre`, `descripcion`) VALUES
(1, 1, NULL, 'Definici&oacute;n de requisitos', NULL),
(2, 1, NULL, 'An&aacute;lisis y dise&ntilde;o', NULL),
(3, 1, NULL, 'Implementaci&oacute;n y test unitarios', NULL),
(4, 1, NULL, 'Integraci&oacute;n y test de sistema', NULL),
(5, 1, NULL, 'Operacici&oacute;n y mantenimiento', NULL),
(6, 1, NULL, 'Pruebas', NULL),
(7, 2, NULL, 'Planificaci&oacute;n', NULL),
(8, 2, NULL, 'An&aacute;lisis de riesgos', NULL),
(9, 2, NULL, 'Ingenier&iacute;a', NULL),
(10, 2, NULL, 'Construcci&oacute;n y entrega', NULL),
(11, 2, NULL, 'Evaluaci&oacute;n del cliente', NULL);

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

-- Datos de cada tipo de usuario de SEPROSO

INSERT INTO `Usuario` (`nick`, `password`, `email`, `tipo`) VALUES 
('admin', 'admin', 'admin@seproso.es', 'admin'),
('manager', 'manager', 'manager@seproso.es', 'manager'),
('developer', 'developer', 'developer@seproso.es', 'developer'),
('personal', 'personal', 'personal@seproso.es', 'personal');

-- Parámetros configurables

INSERT INTO `Configuracion` (`parametro`, `valor`, `descripcion`) VALUES 
('partipacion_max', 4, 'Maximo número de proyectos en que puede participar un trabajador.');
