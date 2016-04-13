CREATE TABLE administrador (
	no_trabajador character varying(15) NOT NULL,
	nombre character varying(30) NOT NULL,
	apellido_paterno character varying(30) NOT NULL,
	apellido_materno character varying(30) NOT NULL,
	vigente bit DEFAULT B'1',
	PRIMARY KEY(no_trabajador)
);

CREATE TABLE alumno (
	no_cuenta numeric(11,0) NOT NULL,
	nombre character varying(90) NOT NULL,
	correo character varying(45),
	telefono bigint,
	fecha_nac character varying(11),
	avance_creditos numeric(5,2) NOT NULL,
	sem_registro numeric(5,0),
	promedio numeric(5,2) NOT NULL,
	servicio_social character varying(15) NOT NULL DEFAULT 'falta',
	comp_ingles bool DEFAULT false,
	maestria bool DEFAULT false,
	doctorado bool DEFAULT false,
	vigente bit DEFAULT B'1',
	carrera_clave bigint NOT NULL,
	profesor_no_trabajador numeric(11),
	PRIMARY KEY(no_cuenta)
);

CREATE TABLE alumno_ingles (
	id bigint NOT NULL,
	nombre character varying(30),
	archivo oid,
	tipo_mime character varying(25),
	anio_exp numeric(5),
	size bigint,
	alumno_no_cuenta numeric(11) NOT NULL,
	PRIMARY KEY(id)
);

CREATE SEQUENCE alumno_ingles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE alumno_ingles_id_seq OWNED BY alumno_ingles.id;

CREATE TABLE alumno_opcion_titulacion (
    id bigint NOT NULL,
    vigente bit(1) DEFAULT B'1',
    alumno_no_cuenta numeric(11,0) NOT NULL,
    opcion_titulacion_clave integer NOT NULL,
    comentario text,
    PRIMARY KEY(id)
);

CREATE SEQUENCE alumno_opcion_titulacion_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE alumno_opcion_titulacion_id_seq OWNED BY alumno_opcion_titulacion.id;

CREATE TABLE alumno_ss (
    id_ss integer NOT NULL,
    nombre character varying(30),
    archivo_ss oid,
    tipo_mime character varying(20),
    size bigint,
    alumno_no_cuenta numeric(11,0) NOT NULL,
    comentario text,
    PRIMARY KEY(id_ss)
);

CREATE SEQUENCE alumno_ss_id_ss_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE alumno_ss_id_ss_seq OWNED BY alumno_ss.id_ss;

CREATE TABLE cargo (
    id integer NOT NULL,
    nombre character varying(30),
    PRIMARY KEY(id)
);

CREATE SEQUENCE cargo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE cargo_id_seq OWNED BY cargo.id;

CREATE TABLE carrera (
    clave bigint NOT NULL,
    nombre character varying(40) NOT NULL,
    vigente bit(1) DEFAULT B'1',
    PRIMARY KEY(clave)
);

CREATE SEQUENCE carrera_clave_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE carrera_clave_seq OWNED BY carrera.clave;
CREATE TABLE categoria (
    id integer NOT NULL,
    categoria character varying(50),
    PRIMARY KEY(id)
);

CREATE SEQUENCE categoria_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE categoria_id_seq OWNED BY categoria.id;

CREATE TABLE departamento (
    clave_depto integer NOT NULL,
    nombre_depto character varying(40) NOT NULL,
    vigente bit(1) DEFAULT B'1',
    PRIMARY KEY(clave_depto)
);

CREATE SEQUENCE departamento_clave_depto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE departamento_clave_depto_seq OWNED BY departamento.clave_depto;

CREATE TABLE opcion_titulacion (
    clave integer NOT NULL,
    nombre character varying(50) NOT NULL,
    vigente bit(1) DEFAULT B'1',
    PRIMARY KEY(clave)
);

CREATE SEQUENCE opcion_titulacion_clave_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE opcion_titulacion_clave_seq OWNED BY opcion_titulacion.clave;

CREATE TABLE perfil (
    idperfil integer NOT NULL,
    nombre character varying(35) NOT NULL,
    vigente bit(1) DEFAULT B'1',
    PRIMARY KEY(idperfil)
);

CREATE SEQUENCE perfil_idperfil_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE perfil_idperfil_seq OWNED BY perfil.idperfil;

CREATE TABLE departamento_carrera (
	id integer NOT NULL,
	vigente bit(1) DEFAULT B'1',
	carrera_clave bigint NOT NULL,
	departamento_clave_depto integer NOT NULL,
	PRIMARY KEY(id)
);

CREATE SEQUENCE departamento_carrera_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE departamento_carrera_id_seq OWNED BY departamento_carrera.id;

CREATE TABLE profesor (
    no_trabajador numeric(11,0) NOT NULL,
    nombre character varying(30) NOT NULL,
    apellido_paterno character varying(30),
    apellido_materno character varying(30),
    vigente bit(1) DEFAULT B'1',
    ubicacion text,
    e_mail character varying(30),
    telefono character varying(40),
    pagina_personal character varying(30),
    departamento_clave_depto integer NOT NULL,
    categoria_id integer NOT NULL,
    cargo_id integer NOT NULL,
    PRIMARY KEY(no_trabajador)
);

CREATE TABLE usuario (
    nombre_usuario character varying(15) NOT NULL,
    contrasena character varying(15) NOT NULL,
    vigente bit(1) DEFAULT B'1',
    primer_acceso bit(1) DEFAULT B'1',
    perfil_idperfil integer NOT NULL,
    PRIMARY KEY(nombre_usuario)
);

ALTER TABLE ONLY alumno_ingles ALTER COLUMN id SET DEFAULT nextval('alumno_ingles_id_seq'::regclass);

ALTER TABLE ONLY alumno_opcion_titulacion ALTER COLUMN id SET DEFAULT nextval('alumno_opcion_titulacion_id_seq'::regclass);

ALTER TABLE ONLY alumno_ss ALTER COLUMN id_ss SET DEFAULT nextval('alumno_ss_id_ss_seq'::regclass);

ALTER TABLE ONLY cargo ALTER COLUMN id SET DEFAULT nextval('cargo_id_seq'::regclass);

ALTER TABLE ONLY carrera ALTER COLUMN clave SET DEFAULT nextval('carrera_clave_seq'::regclass);

ALTER TABLE ONLY categoria ALTER COLUMN id SET DEFAULT nextval('categoria_id_seq'::regclass);

ALTER TABLE ONLY departamento ALTER COLUMN clave_depto SET DEFAULT nextval('departamento_clave_depto_seq'::regclass);

ALTER TABLE ONLY opcion_titulacion ALTER COLUMN clave SET DEFAULT nextval('opcion_titulacion_clave_seq'::regclass);

ALTER TABLE ONLY perfil ALTER COLUMN idperfil SET DEFAULT nextval('perfil_idperfil_seq'::regclass);

ALTER TABLE ONLY departamento_carrera ALTER COLUMN id SET DEFAULT nextval('departamento_carrera_id_seq'::regclass);

ALTER TABLE alumno_opcion_titulacion ADD CONSTRAINT Ref_alumno_opcion_titulacion_to_alumno FOREIGN KEY (alumno_no_cuenta)
	REFERENCES alumno(no_cuenta)
	MATCH SIMPLE
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
	NOT DEFERRABLE;

ALTER TABLE alumno_opcion_titulacion ADD CONSTRAINT Ref_alumno_opcion_titulacion_to_opcion_titulacion FOREIGN KEY (opcion_titulacion_clave)
	REFERENCES opcion_titulacion(clave)
	MATCH SIMPLE
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
	NOT DEFERRABLE;

ALTER TABLE departamento_carrera ADD CONSTRAINT Ref_departamento_carrera_to_departamento FOREIGN KEY (departamento_clave_depto)
	REFERENCES departamento(clave_depto)
	MATCH SIMPLE
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
	NOT DEFERRABLE;

ALTER TABLE departamento_carrera ADD CONSTRAINT Ref_departamento_carrera_to_carrera FOREIGN KEY (carrera_clave)
	REFERENCES carrera(clave)
	MATCH SIMPLE
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
	NOT DEFERRABLE;

ALTER TABLE alumno ADD CONSTRAINT Ref_alumno_to_carrera FOREIGN KEY (carrera_clave)
	REFERENCES carrera(clave)
	MATCH SIMPLE
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
	NOT DEFERRABLE;

ALTER TABLE alumno ADD CONSTRAINT Ref_alumno_to_profesor FOREIGN KEY (profesor_no_trabajador)
	REFERENCES profesor(no_trabajador)
	MATCH SIMPLE
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
	NOT DEFERRABLE;

ALTER TABLE profesor ADD CONSTRAINT Ref_profesor_to_departamento FOREIGN KEY (departamento_clave_depto)
	REFERENCES departamento(clave_depto)
	MATCH SIMPLE
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
	NOT DEFERRABLE;

ALTER TABLE profesor ADD CONSTRAINT Ref_profesor_to_categoria FOREIGN KEY (categoria_id)
	REFERENCES categoria(id)
	MATCH SIMPLE
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
	NOT DEFERRABLE;

ALTER TABLE profesor ADD CONSTRAINT Ref_profesor_to_cargo FOREIGN KEY (cargo_id)
	REFERENCES cargo(id)
	MATCH SIMPLE
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
	NOT DEFERRABLE;

ALTER TABLE usuario ADD CONSTRAINT Ref_usuario_to_perfil FOREIGN KEY (perfil_idperfil)
	REFERENCES perfil(idperfil)
	MATCH SIMPLE
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
	NOT DEFERRABLE;

ALTER TABLE alumno_ingles ADD CONSTRAINT Ref_alumno_ingles_to_alumno FOREIGN KEY (alumno_no_cuenta)
	REFERENCES alumno(no_cuenta)
	MATCH SIMPLE
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
	NOT DEFERRABLE;

ALTER TABLE alumno_ss ADD CONSTRAINT Ref_alumno_ss_to_alumno FOREIGN KEY (alumno_no_cuenta)
	REFERENCES alumno(no_cuenta)
	MATCH SIMPLE
	ON DELETE NO ACTION
	ON UPDATE NO ACTION
	NOT DEFERRABLE;
