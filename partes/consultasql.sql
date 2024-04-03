SELECT `T1`.`nom_alumno`, `T1`.`ape_alumno`,
                         `T1`.`grupo_alumno`, `T1`.`nom_incidencia`,
                         `T1`.`cod_parte`, 
                        `T1`.`fecha_parte`, `T1`.`puntos_parte`, 
                         `T1`.`ape_profesor`, `T1`.`nom_profesor` FROM(

SELECT `alumnos`.`nom_alumno`, `alumnos`.`ape_alumno`,
                         `alumnos`.`grupo_alumno`, `incidencias`.`nom_incidencia`,
                         `partes`.`cod_parte`, 
                         `partes`.`fecha_parte`, `partes`.`puntos_parte`, 
                         `profesores`.`ape_profesor`, `profesores`.`nom_profesor`
                        FROM `alumnos`     
                         LEFT JOIN `partes` ON `partes`.`cod_alumno` = `alumnos`.`cod_alumno`     
                         LEFT JOIN `incidencias` ON `partes`.`cod_incidencia` = `incidencias`.`cod_incidencia`     
                         LEFT JOIN `profesores` ON `partes`.`cod_profesor` = `profesores`.`cod_profesor`
                        WHERE `partes`.`fecha_parte` BETWEEN "2017-08-26" AND "2017-08-30" 
                       
UNION                        
	SELECT `alumnos`.`nom_alumno`, `alumnos`.`ape_alumno`,
                         `alumnos`.`grupo_alumno`, `incidencias`.`nom_incidencia`,
                          `partes_expulsion`.`cod_parte_expulsion`, 
                         `partes_expulsion`.`fecha_parte`, `partes_expulsion`.`puntos_parte`, 
                         `profesores`.`ape_profesor`, `profesores`.`nom_profesor`
                        FROM `alumnos`     
                         LEFT JOIN `partes_expulsion` ON `partes_expulsion`.`cod_alumno` = `alumnos`.`cod_alumno`     
                         LEFT JOIN `incidencias` ON `partes_expulsion`.`cod_incidencia` = `incidencias`.`cod_incidencia`     
                         LEFT JOIN `profesores` ON `partes_expulsion`.`cod_profesor` = `profesores`.`cod_profesor`
                        WHERE `partes_expulsion`.`fecha_parte` BETWEEN "2017-08-26" AND "2017-08-30" ) T1
ORDER BY `T1`.`grupo_alumno`, `T1`.`ape_alumno`  