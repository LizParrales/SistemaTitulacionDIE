INSERT INTO cargo (id, nombre) VALUES (1, 'Jefe de Division');
INSERT INTO cargo (id, nombre) VALUES (2, 'Jefe de Departamento');
INSERT INTO cargo (id, nombre) VALUES (3, 'Coordinador de carrera');

INSERT INTO carrera (clave, nombre, vigente) VALUES (39, 'Ingenieria Electrica-Electronica', B'1');
INSERT INTO carrera (clave, nombre, vigente) VALUES (33, 'Ingenieria en Telecomunicaciones', B'1');
INSERT INTO carrera (clave, nombre, vigente) VALUES (32, 'Ingenieria en Computacion', B'1');

INSERT INTO categoria (id, categoria) VALUES (1, 'Profesor Titular de Tiempo Completo A');
INSERT INTO categoria (id, categoria) VALUES (2, 'Profesor Titular de Tiempo Completo B');
INSERT INTO categoria (id, categoria) VALUES (3, 'Profesor Titular de Tiempo Completo C');
INSERT INTO categoria (id, categoria) VALUES (4, 'Tecnico Academico Asociado de Tiempo Completo A');
INSERT INTO categoria (id, categoria) VALUES (5, 'Tecnico Academico Asociado de Tiempo Completo B');
INSERT INTO categoria (id, categoria) VALUES (6, 'Tecnico Academico Asociado de Tiempo Completo C');
INSERT INTO categoria (id, categoria) VALUES (7, 'Profesor Asociado de Tiempo Completo A');
INSERT INTO categoria (id, categoria) VALUES (8, 'Profesor Asociado de Tiempo Completo B');
INSERT INTO categoria (id, categoria) VALUES (9, 'Profesor Asociado de Tiempo Completo C');
INSERT INTO categoria (id, categoria) VALUES (10, 'Tecnico Academico Titular A');
INSERT INTO categoria (id, categoria) VALUES (11, 'Tecnico Academico Titular B');
INSERT INTO categoria (id, categoria) VALUES (12, 'Tecnico Academico Titular C');

INSERT INTO departamento (clave_depto, nombre_depto, vigente) VALUES (5, 'Sistemas energeticos', B'1');
INSERT INTO departamento (clave_depto, nombre_depto, vigente) VALUES (1, 'Ingenieria en computacion', B'1');
INSERT INTO departamento (clave_depto, nombre_depto, vigente) VALUES (3, 'Ingenieria electronica', B'1');
INSERT INTO departamento (clave_depto, nombre_depto, vigente) VALUES (2, 'Ingenieria en telecomunicaciones', B'1');
INSERT INTO departamento (clave_depto, nombre_depto, vigente) VALUES (4, 'Ingenieria electrica de potencia', B'1');
INSERT INTO departamento (clave_depto, nombre_depto, vigente) VALUES (6, 'Ingenieria de control', B'1');
INSERT INTO departamento (clave_depto, nombre_depto, vigente) VALUES (7, 'Procesamiento de señales', B'1');

INSERT INTO departamento_carrera (id, vigente, carrera_clave, departamento_clave_depto) VALUES (1, B'1', 39, 5);
INSERT INTO departamento_carrera (id, vigente, carrera_clave, departamento_clave_depto) VALUES (2, B'1', 39, 6);
INSERT INTO departamento_carrera (id, vigente, carrera_clave, departamento_clave_depto) VALUES (5, B'1', 39, 7);
INSERT INTO departamento_carrera (id, vigente, carrera_clave, departamento_clave_depto) VALUES (7, B'1', 39, 4);
INSERT INTO departamento_carrera (id, vigente, carrera_clave, departamento_clave_depto) VALUES (8, B'1', 32, 1);
INSERT INTO departamento_carrera (id, vigente, carrera_clave, departamento_clave_depto) VALUES (9, B'1', 33, 2);
INSERT INTO departamento_carrera (id, vigente, carrera_clave, departamento_clave_depto) VALUES (10, B'1', 39, 3);

INSERT INTO opcion_titulacion (clave, nombre, vigente) VALUES (1, 'Tesis o tesina y examen profesional', B'1');
INSERT INTO opcion_titulacion (clave, nombre, vigente) VALUES (2, 'Actividad de investigacion', B'1');
INSERT INTO opcion_titulacion (clave, nombre, vigente) VALUES (3, 'Seminario de tesis o tesina', B'1');
INSERT INTO opcion_titulacion (clave, nombre, vigente) VALUES (4, 'Examen general de conocimientos', B'1');
INSERT INTO opcion_titulacion (clave, nombre, vigente) VALUES (5, 'Totalidad de creditos y alto nivel academico', B'1');
INSERT INTO opcion_titulacion (clave, nombre, vigente) VALUES (6, 'Trabajo profesional', B'1');
INSERT INTO opcion_titulacion (clave, nombre, vigente) VALUES (7, 'Estudios de posgrado', B'1');
INSERT INTO opcion_titulacion (clave, nombre, vigente) VALUES (8, 'Ampliacion y profundizacion de conocimientos', B'1');
INSERT INTO opcion_titulacion (clave, nombre, vigente) VALUES (9, 'Servicio social', B'1');
INSERT INTO opcion_titulacion (clave, nombre, vigente) VALUES (10, 'Actividad de apoyo a la docencia', B'1');

INSERT INTO perfil (idperfil, nombre, vigente) VALUES (1, 'Administrador', B'1');
INSERT INTO perfil (idperfil, nombre, vigente) VALUES (2, 'Alumno', B'1');
INSERT INTO perfil (idperfil, nombre, vigente) VALUES (3, 'Profesor', B'1');

INSERT INTO administrador (no_trabajador, nombre, apellido_paterno, apellido_materno, vigente) VALUES ('DIE.titulacion', 'Titulacion', 'DIE', 'FI', B'1');
INSERT INTO usuario (nombre_usuario, contrasena, perfil_idperfil) VALUES ('DIE.titulacion', 'DIE.titulacion', 1);
