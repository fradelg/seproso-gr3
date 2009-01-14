
DROP TABLE IF EXISTS `actividad`;
CREATE TABLE IF NOT EXISTS `actividad` (
  `idActividad` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TipoActividad_idTipoActividad` int(10) unsigned NOT NULL,
  `Fase_idFase` int(10) unsigned NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` text,
  `inicio` date NOT NULL,
  `duracion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idActividad`),
  KEY `Actividad_FKIndex2` (`Fase_idFase`),
  KEY `Actividad_FKIndex3` (`TipoActividad_idTipoActividad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `artefacto`;
CREATE TABLE IF NOT EXISTS `artefacto` (
  `idArtefacto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`idArtefacto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `artefacto_has_actividad`;
CREATE TABLE IF NOT EXISTS `artefacto_has_actividad` (
  `Artefacto_idArtefacto` int(10) unsigned NOT NULL,
  `Actividad_idActividad` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Artefacto_idArtefacto`,`Actividad_idActividad`),
  KEY `Artefacto_has_Actividad_FKIndex1` (`Artefacto_idArtefacto`),
  KEY `Artefacto_has_Actividad_FKIndex2` (`Actividad_idActividad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `configuracion`;
CREATE TABLE IF NOT EXISTS `configuracion` (
  `idConfiguracion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Usuario_idUsuario` int(10) unsigned NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `valor` varchar(20) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`idConfiguracion`),
  KEY `Configuracion_FKIndex1` (`Usuario_idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `fase`;
CREATE TABLE IF NOT EXISTS `fase` (
  `idFase` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idFase`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `modelo`;
CREATE TABLE IF NOT EXISTS `modelo` (
  `idModelo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Plantilla_idPlantilla` int(10) unsigned NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`idModelo`),
  KEY `Modelo_FKIndex2` (`Plantilla_idPlantilla`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `modelo_has_fase`;
CREATE TABLE IF NOT EXISTS `modelo_has_fase` (
  `Modelo_idModelo` int(10) unsigned NOT NULL,
  `Fase_idFase` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Modelo_idModelo`,`Fase_idFase`),
  KEY `Modelo_has_Fase_FKIndex1` (`Modelo_idModelo`),
  KEY `Modelo_has_Fase_FKIndex2` (`Fase_idFase`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `participacion`;
CREATE TABLE IF NOT EXISTS `participacion` (
  `Proyecto_idProyecto` int(10) unsigned NOT NULL,
  `Usuario_idUsuario` int(10) unsigned NOT NULL,
  `Rol_idRol` int(10) unsigned NOT NULL,
  `porc` int(11) NOT NULL,
  PRIMARY KEY (`Proyecto_idProyecto`,`Usuario_idUsuario`),
  KEY `Participacion_FKIndex2` (`Proyecto_idProyecto`),
  KEY `Participacion_FKIndex3` (`Rol_idRol`),
  KEY `Participacion_FKIndex4` (`Usuario_idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `periodovacacional`;
CREATE TABLE IF NOT EXISTS `periodovacacional` (
  `idPeriodoVacacional` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Trabajador_Usuario_idUsuario` int(10) unsigned NOT NULL,
  `fecha_ini` date NOT NULL,
  `duracion` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idPeriodoVacacional`),
  KEY `PeriodoVacacional_FKIndex1` (`Trabajador_Usuario_idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `plantilla`;
CREATE TABLE IF NOT EXISTS `plantilla` (
  `idPlantilla` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idPlantilla`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `proyecto`;
CREATE TABLE IF NOT EXISTS `proyecto` (
  `idProyecto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Modelo_idModelo` int(10) unsigned NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `año` year(4) NOT NULL,
  `presupuesto` double NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idProyecto`),
  KEY `Proyecto_FKIndex2` (`Modelo_idModelo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `registrotrabajo`;
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


DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `idRol` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) NOT NULL,
  `valor` int(11) NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `tipoactividad`;
CREATE TABLE IF NOT EXISTS `tipoactividad` (
  `idTipoActividad` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idTipoActividad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nick` varchar(20) NOT NULL,
  `password_2` varchar(20) NOT NULL,
  `tipoUsuario` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

DROP TABLE IF EXISTS `trabajador`;
CREATE TABLE IF NOT EXISTS `trabajador` (
  `Usuario_idUsuario` int(10) unsigned NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `edad` smallint(5) unsigned NOT NULL DEFAULT '18',
  `semVaca` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `maxRol` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`Usuario_idUsuario`),
  KEY `Trabajador_FKIndex1` (`Usuario_idUsuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `actividad`
  ADD CONSTRAINT `actividad_ibfk_1` FOREIGN KEY (`Fase_idFase`) REFERENCES `fase` (`idFase`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `actividad_ibfk_2` FOREIGN KEY (`TipoActividad_idTipoActividad`) REFERENCES `tipoactividad` (`idTipoActividad`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `artefacto_has_actividad`
  ADD CONSTRAINT `artefacto_has_actividad_ibfk_1` FOREIGN KEY (`Artefacto_idArtefacto`) REFERENCES `artefacto` (`idArtefacto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `artefacto_has_actividad_ibfk_2` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `configuracion`
  ADD CONSTRAINT `configuracion_ibfk_1` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `modelo`
  ADD CONSTRAINT `modelo_ibfk_1` FOREIGN KEY (`Plantilla_idPlantilla`) REFERENCES `plantilla` (`idPlantilla`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `modelo_has_fase`
  ADD CONSTRAINT `modelo_has_fase_ibfk_1` FOREIGN KEY (`Modelo_idModelo`) REFERENCES `modelo` (`idModelo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `modelo_has_fase_ibfk_2` FOREIGN KEY (`Fase_idFase`) REFERENCES `fase` (`idFase`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `participacion`
  ADD CONSTRAINT `participacion_ibfk_1` FOREIGN KEY (`Proyecto_idProyecto`) REFERENCES `proyecto` (`idProyecto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participacion_ibfk_2` FOREIGN KEY (`Rol_idRol`) REFERENCES `rol` (`idRol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `participacion_ibfk_3` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `periodovacacional`
  ADD CONSTRAINT `periodovacacional_ibfk_1` FOREIGN KEY (`Trabajador_Usuario_idUsuario`) REFERENCES `trabajador` (`Usuario_idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `proyecto`
  ADD CONSTRAINT `proyecto_ibfk_1` FOREIGN KEY (`Modelo_idModelo`) REFERENCES `modelo` (`idModelo`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `registrotrabajo`
  ADD CONSTRAINT `registrotrabajo_ibfk_1` FOREIGN KEY (`Actividad_idActividad`) REFERENCES `actividad` (`idActividad`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registrotrabajo_ibfk_2` FOREIGN KEY (`Trabajador_Usuario_idUsuario`) REFERENCES `trabajador` (`Usuario_idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `trabajador`
  ADD CONSTRAINT `trabajador_ibfk_1` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;

INSERT INTO `usuario` (`idUsuario`, `nick`, `password_2`, `tipoUsuario`) VALUES
(1, 'pepe', 'pepe', 'admin'),
(2, 'ruben', 'ruben', 'trabajador'),
(3, 'fran', 'fran', 'trabajador');


INSERT INTO `trabajador` (`Usuario_idUsuario`, `nombre`, `apellidos`, `edad`, `semVaca`, `email`, `maxRol`) VALUES
(1, 'pepe', 'pepe', 18, NULL, NULL, NULL),
(2, 'ruben', 'ruben ruben', 18, NULL, NULL, NULL),
(3, 'fran', 'fran', 18, NULL, NULL, NULL);