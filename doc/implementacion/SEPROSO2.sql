CREATE TABLE Actividad (
  idActividad INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  TipoActividad_idTipoActividad INTEGER UNSIGNED NOT NULL,
  Rol_idRol INTEGER UNSIGNED NOT NULL,
  Fase_idFase INTEGER UNSIGNED NOT NULL,
  nombre VARCHAR(20) NOT NULL,
  descripcion TEXT NULL,
  inicio DATE NOT NULL,
  duracion INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idActividad),
  INDEX Actividad_FKIndex2(Fase_idFase),
  INDEX Actividad_FKIndex3(Rol_idRol),
  INDEX Actividad_FKIndex4(TipoActividad_idTipoActividad)
)
TYPE=InnoDB;

CREATE TABLE Artefacto (
  idArtefacto INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(20) NOT NULL,
  descripcion TEXT NOT NULL,
  PRIMARY KEY(idArtefacto)
)
TYPE=InnoDB;

CREATE TABLE Artefacto_has_Actividad (
  Artefacto_idArtefacto INTEGER UNSIGNED NOT NULL,
  Actividad_idActividad INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(Artefacto_idArtefacto, Actividad_idActividad),
  INDEX Artefacto_has_Actividad_FKIndex1(Artefacto_idArtefacto),
  INDEX Artefacto_has_Actividad_FKIndex2(Actividad_idActividad)
)
TYPE=InnoDB;

CREATE TABLE Fase (
  idFase INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(20) NOT NULL,
  descripcion VARCHAR(45) NULL,
  PRIMARY KEY(idFase)
)
TYPE=InnoDB;

CREATE TABLE Modelo (
  idModelo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Plantilla_idPlantilla INTEGER UNSIGNED NOT NULL,
  nombre VARCHAR(45) NOT NULL,
  PRIMARY KEY(idModelo),
  INDEX Modelo_FKIndex2(Plantilla_idPlantilla)
)
TYPE=InnoDB;

CREATE TABLE Modelo_has_Fase (
  Modelo_idModelo INTEGER UNSIGNED NOT NULL,
  Fase_idFase INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(Modelo_idModelo, Fase_idFase),
  INDEX Modelo_has_Fase_FKIndex1(Modelo_idModelo),
  INDEX Modelo_has_Fase_FKIndex2(Fase_idFase)
)
TYPE=InnoDB;

CREATE TABLE Participacion (
  Proyecto_idProyecto INTEGER UNSIGNED NOT NULL,
  Usuario_idUsuario INTEGER UNSIGNED NOT NULL,
  Rol_idRol INTEGER UNSIGNED NOT NULL,
  porc INTEGER NOT NULL,
  PRIMARY KEY(Proyecto_idProyecto, Usuario_idUsuario),
  INDEX Participacion_FKIndex2(Proyecto_idProyecto),
  INDEX Participacion_FKIndex3(Rol_idRol),
  INDEX Participacion_FKIndex4(Usuario_idUsuario)
)
TYPE=InnoDB;

CREATE TABLE Plantilla (
  idPlantilla INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(20) NULL,
  PRIMARY KEY(idPlantilla)
)
TYPE=InnoDB;

CREATE TABLE Proyecto (
  idProyecto INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Modelo_idModelo INTEGER UNSIGNED NOT NULL,
  titulo VARCHAR(45) NOT NULL,
  año YEAR NOT NULL,
  presupuesto REAL NOT NULL,
  activo BOOL NOT NULL DEFAULT false,
  PRIMARY KEY(idProyecto),
  INDEX Proyecto_FKIndex2(Modelo_idModelo)
)
TYPE=InnoDB;

CREATE TABLE Rol (
  idRol INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tipo VARCHAR(45) NOT NULL,
  valor INTEGER NOT NULL,
  PRIMARY KEY(idRol)
)
TYPE=InnoDB;

CREATE TABLE TipoActividad (
  idTipoActividad INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tipo VARCHAR(255) NULL,
  PRIMARY KEY(idTipoActividad)
)
TYPE=InnoDB;

CREATE TABLE Configuracion (
  idConfiguracion INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Usuario_idUsuario INTEGER UNSIGNED NOT NULL,
  nombre VARCHAR(20) NOT NULL,
  valor VARCHAR(20) NOT NULL,
  descripcion TEXT NULL,
  PRIMARY KEY(idConfiguracion),
  INDEX Configuracion_FKIndex1(Usuario_idUsuario)
)
TYPE=InnoDB;

CREATE TABLE PeriodoVacacional (
  idPeriodoVacacional INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Trabajador_Usuario_idUsuario INTEGER UNSIGNED NOT NULL,
  fecha_ini DATE NOT NULL,
  duracion INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(idPeriodoVacacional),
  INDEX PeriodoVacacional_FKIndex1(Trabajador_Usuario_idUsuario)
)
TYPE=InnoDB;

CREATE TABLE RegistroTrabajo (
  idRegistroTrabajo INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  Trabajador_Usuario_idUsuario INTEGER UNSIGNED NOT NULL,
  Actividad_idActividad INTEGER UNSIGNED NOT NULL,
  inicio DATE NOT NULL,
  final DATE NOT NULL,
  esfuerzo REAL NOT NULL,
  fin BOOL NOT NULL,
  PRIMARY KEY(idRegistroTrabajo),
  INDEX RegistroTrabajo_FKIndex1(Actividad_idActividad),
  INDEX RegistroTrabajo_FKIndex2(Trabajador_Usuario_idUsuario)
)
TYPE=InnoDB;

CREATE TABLE Trabajador (
  Usuario_idUsuario INTEGER UNSIGNED NOT NULL,
  Rol_idRol INTEGER UNSIGNED NOT NULL,
  Actividad_idActividad INTEGER UNSIGNED NOT NULL,
  nombre VARCHAR(20) NOT NULL,
  apellidos VARCHAR(45) NOT NULL,
  edad SMALLINT UNSIGNED NOT NULL DEFAULT 18,
  semVaca DATE NULL,
  email VARCHAR(255) NULL,
  PRIMARY KEY(Usuario_idUsuario),
  INDEX Trabajador_FKIndex1(Usuario_idUsuario),
  INDEX Trabajador_FKIndex2(Actividad_idActividad),
  INDEX Trabajador_FKIndex3(Rol_idRol)
)
TYPE=InnoDB;

CREATE TABLE Usuario (
  idUsuario INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nick VARCHAR(20) NOT NULL,
  password_2 VARCHAR(20) NOT NULL,
  tipoUsuario VARCHAR(45) NULL,
  PRIMARY KEY(idUsuario)
)
TYPE=InnoDB;
