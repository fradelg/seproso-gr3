DROP TABLE IF EXISTS `Actividad`;
CREATE TABLE `Actividad` (
  `idActividad` int(10) unsigned NOT NULL auto_increment,
  `TipoActividad_idTipoActividad` int(10) unsigned NOT NULL,
  `Rol_idRol` int(10) unsigned NOT NULL,
  `Fase_idFase` int(10) unsigned NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` text,
  `inicio` date NOT NULL,
  `duracion` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`idActividad`),
  KEY `Actividad_FKIndex2` (`Fase_idFase`),
  KEY `Actividad_FKIndex3` (`Rol_idRol`),
  KEY `Actividad_FKIndex4` (`TipoActividad_idTipoActividad`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `Artefacto`;
CREATE TABLE `Artefacto` (
  `idArtefacto` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY  (`idArtefacto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `Artefacto_has_Actividad`;
CREATE TABLE `Artefacto_has_Actividad` (
  `Artefacto_idArtefacto` int(10) unsigned NOT NULL,
  `Actividad_idActividad` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`Artefacto_idArtefacto`,`Actividad_idActividad`),
  KEY `Artefacto_has_Actividad_FKIndex1` (`Artefacto_idArtefacto`),
  KEY `Artefacto_has_Actividad_FKIndex2` (`Actividad_idActividad`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `Configuracion`;
CREATE TABLE `Configuracion` (
  `idConfiguracion` int(10) unsigned NOT NULL auto_increment,
  `Usuario_idUsuario` int(10) unsigned NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `valor` varchar(20) NOT NULL,
  `descripcion` text,
  PRIMARY KEY  (`idConfiguracion`),
  KEY `Configuracion_FKIndex1` (`Usuario_idUsuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `Fase`;
CREATE TABLE `Fase` (
  `idFase` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(20) NOT NULL,
  `descripcion` varchar(45) default NULL,
  PRIMARY KEY  (`idFase`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `Modelo`;
CREATE TABLE `Modelo` (
  `idModelo` int(10) unsigned NOT NULL auto_increment,
  `Plantilla_idPlantilla` int(10) unsigned NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY  (`idModelo`),
  KEY `Modelo_FKIndex2` (`Plantilla_idPlantilla`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `Modelo_has_Fase`;
CREATE TABLE `Modelo_has_Fase` (
  `Modelo_idModelo` int(10) unsigned NOT NULL,
  `Fase_idFase` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`Modelo_idModelo`,`Fase_idFase`),
  KEY `Modelo_has_Fase_FKIndex1` (`Modelo_idModelo`),
  KEY `Modelo_has_Fase_FKIndex2` (`Fase_idFase`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Participacion`;
CREATE TABLE `Participacion` (
  `Proyecto_idProyecto` int(10) unsigned NOT NULL,
  `Usuario_idUsuario` int(10) unsigned NOT NULL,
  `Rol_idRol` int(10) unsigned NOT NULL,
  `porc` int(11) NOT NULL,
  PRIMARY KEY  (`Proyecto_idProyecto`,`Usuario_idUsuario`),
  KEY `Participacion_FKIndex2` (`Proyecto_idProyecto`),
  KEY `Participacion_FKIndex3` (`Rol_idRol`),
  KEY `Participacion_FKIndex4` (`Usuario_idUsuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `PeriodoVacacional`;
CREATE TABLE `PeriodoVacacional` (
  `idPeriodoVacacional` int(10) unsigned NOT NULL auto_increment,
  `Trabajador_Usuario_idUsuario` int(10) unsigned NOT NULL,
  `fecha_ini` date NOT NULL,
  `duracion` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`idPeriodoVacacional`),
  KEY `PeriodoVacacional_FKIndex1` (`Trabajador_Usuario_idUsuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `Plantilla`;
CREATE TABLE `Plantilla` (
  `idPlantilla` int(10) unsigned NOT NULL auto_increment,
  `nombre` varchar(20) default NULL,
  PRIMARY KEY  (`idPlantilla`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `Proyecto`;
CREATE TABLE `Proyecto` (
  `idProyecto` int(10) unsigned NOT NULL auto_increment,
  `Modelo_idModelo` int(10) unsigned NOT NULL,
  `titulo` varchar(45) NOT NULL,
  `año` year(4) NOT NULL,
  `presupuesto` double NOT NULL,
  `activo` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`idProyecto`),
  KEY `Proyecto_FKIndex2` (`Modelo_idModelo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `RegistroTrabajo`;
CREATE TABLE `RegistroTrabajo` (
  `idRegistroTrabajo` int(10) unsigned NOT NULL auto_increment,
  `Trabajador_Usuario_idUsuario` int(10) unsigned NOT NULL,
  `Actividad_idActividad` int(10) unsigned NOT NULL,
  `inicio` date NOT NULL,
  `final` date NOT NULL,
  `esfuerzo` double NOT NULL,
  `fin` tinyint(1) NOT NULL,
  PRIMARY KEY  (`idRegistroTrabajo`),
  KEY `RegistroTrabajo_FKIndex1` (`Actividad_idActividad`),
  KEY `RegistroTrabajo_FKIndex2` (`Trabajador_Usuario_idUsuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `Rol`;
CREATE TABLE `Rol` (
  `idRol` int(10) unsigned NOT NULL auto_increment,
  `tipo` varchar(45) NOT NULL,
  `valor` int(11) NOT NULL,
  PRIMARY KEY  (`idRol`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;


DROP TABLE IF EXISTS `TipoActividad`;
CREATE TABLE `TipoActividad` (
  `idTipoActividad` int(10) unsigned NOT NULL auto_increment,
  `tipo` varchar(255) default NULL,
  PRIMARY KEY  (`idTipoActividad`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `Trabajador`;
CREATE TABLE `Trabajador` (
  `Usuario_idUsuario` int(10) unsigned NOT NULL,
  `Rol_idRol` int(10) unsigned NOT NULL,
  `Actividad_idActividad` int(10) unsigned default NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(45) NOT NULL,
  `edad` smallint(5) unsigned NOT NULL default '18',
  `semVaca` date default NULL,
  `email` varchar(255) default NULL,
  PRIMARY KEY  (`Usuario_idUsuario`),
  KEY `Trabajador_FKIndex1` (`Usuario_idUsuario`),
  KEY `Trabajador_FKIndex2` (`Actividad_idActividad`),
  KEY `Trabajador_FKIndex3` (`Rol_idRol`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `Usuario`;
CREATE TABLE `Usuario` (
  `idUsuario` int(10) unsigned NOT NULL auto_increment,
  `nick` varchar(20) NOT NULL,
  `password_2` varchar(20) NOT NULL,
  `tipoUsuario` varchar(45) default NULL,
  PRIMARY KEY  (`idUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;


INSERT DELAYED INTO `Usuario` (`idUsuario`, `nick`, `password_2`, `tipoUsuario`) VALUES (1, 'pepe', 'pepe', 'admin'),
(2, 'fran', 'fran', 'admin'),
(3, 'ruben', 'ruben', 'trabajador');

INSERT DELAYED INTO `Trabajador` (`Usuario_idUsuario`, `Rol_idRol`, `Actividad_idActividad`, `nombre`, `apellidos`, `edad`, `semVaca`, `email`) VALUES (0, 1, NULL, 'Ruben', 'Ruben Ruben', 25, NULL, NULL);
