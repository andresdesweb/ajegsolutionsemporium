BEGIN
	DECLARE done INT DEFAULT FALSE;
	DECLARE idEmp VARCHAR(255) DEFAULT "";
	DECLARE idChec VARCHAR(255) DEFAULT "";
	DECLARE utilizables VARCHAR(255) DEFAULT "";
	DECLARE Inicio VARCHAR(255) DEFAULT "";
    DECLARE AniosAntiguedad VARCHAR(255) DEFAULT "";
	DECLARE cursorEmpleados CURSOR FOR SELECT year(NOW()) - year(ingreso) as AniosAntiguedad, idEmpleado, idChecador, ingreso, utilizables FROM emporiumbd.tc_empleados WHERE isActive = 1;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

	OPEN cursorEmpleados;

	read_loop: LOOP
		SET done = FALSE;
	FETCH cursorEmpleados INTO AniosAntiguedad, idEmp, idChec, Inicio, utilizables;
	IF done THEN
		LEAVE read_loop;
	END IF;
		IF DATE_FORMAT(Inicio, '%m-%d') = DATE_FORMAT(NOW(), '%m-%d') THEN
		IF (AniosAntiguedad  = 1) THEN
			BEGIN
                IF(SELECT COUNT(*) FROM tr_vacacionesPendientes WHERE idEmpleado = idEmp AND year(fechaActualizacion) = year(NOW())) = 0 THEN
				    BEGIN
                        INSERT INTO tr_vacacionesPendientes VALUES (null,idEmp,6,NOW(), idChec, 1);
                        UPDATE tr_vacacionesPendientes SET utilizables = 0 where idEmpleado = idEmp AND year(fechaActualizacion) = (year(NOW())-1);
                    END;
                END IF;
			END;
		ELSEIF (AniosAntiguedad  = 2) THEN
			BEGIN
                IF(SELECT COUNT(*) FROM tr_vacacionesPendientes WHERE idEmpleado = idEmp AND year(fechaActualizacion) = year(NOW())) = 0 THEN
				    BEGIN
                        INSERT INTO tr_vacacionesPendientes VALUES (null,idEmp,8,NOW(), idChec, 1);
                        UPDATE tr_vacacionesPendientes SET utilizables = 0 where idEmpleado = idEmp AND year(fechaActualizacion) = (year(NOW())-1);
                    END;
                END IF;
			END;
		ELSEIF (AniosAntiguedad  = 3) THEN
			BEGIN
                IF(SELECT COUNT(*) FROM tr_vacacionesPendientes WHERE idEmpleado = idEmp AND year(fechaActualizacion) = year(NOW())) = 0 THEN
				    BEGIN
                        INSERT INTO tr_vacacionesPendientes VALUES (null,idEmp,10,NOW(), idChec, 1);
                        UPDATE tr_vacacionesPendientes SET utilizables = 0 where idEmpleado = idEmp AND year(fechaActualizacion) = (year(NOW())-1);
                    END;
                END IF;
			END;
		ELSEIF (AniosAntiguedad  = 4) THEN
			BEGIN
                IF(SELECT COUNT(*) FROM tr_vacacionesPendientes WHERE idEmpleado = idEmp AND year(fechaActualizacion) = year(NOW())) = 0 THEN
				    BEGIN
                        INSERT INTO tr_vacacionesPendientes VALUES (null,idEmp,12,NOW(), idChec, 1);
                        UPDATE tr_vacacionesPendientes SET utilizables = 0 where idEmpleado = idEmp AND year(fechaActualizacion) = (year(NOW())-1);
                    END;
                END IF;
			END;
		ELSEIF (AniosAntiguedad  >= 5 ) || (AniosAntiguedad  <= 9 )THEN
			BEGIN
                IF(SELECT COUNT(*) FROM tr_vacacionesPendientes WHERE idEmpleado = idEmp AND year(fechaActualizacion) = year(NOW())) = 0 THEN
				    BEGIN
                        INSERT INTO tr_vacacionesPendientes VALUES (null,idEmp,14,NOW(), idChec, 1);
                        UPDATE tr_vacacionesPendientes SET utilizables = 0 where idEmpleado = idEmp AND year(fechaActualizacion) = (year(NOW())-1);
                    END;
                END IF;
			END;
		ELSEIF (AniosAntiguedad  >= 10 ) || (AniosAntiguedad  <= 14 )THEN
			BEGIN
                IF(SELECT COUNT(*) FROM tr_vacacionesPendientes WHERE idEmpleado = idEmp AND year(fechaActualizacion) = year(NOW())) = 0 THEN
				    BEGIN
                        INSERT INTO tr_vacacionesPendientes VALUES (null,idEmp,16,NOW(), idChec, 1);
                        UPDATE tr_vacacionesPendientes SET utilizables = 0 where idEmpleado = idEmp AND year(fechaActualizacion) = (year(NOW())-1);
                    END;
                END IF;
			END;
		ELSEIF (AniosAntiguedad  >= 15 ) || (AniosAntiguedad  <= 19 )THEN
			BEGIN
                IF(SELECT COUNT(*) FROM tr_vacacionesPendientes WHERE idEmpleado = idEmp AND year(fechaActualizacion) = year(NOW())) = 0 THEN
				    BEGIN
                        INSERT INTO tr_vacacionesPendientes VALUES (null,idEmp,18,NOW(), idChec, 1);
                        UPDATE tr_vacacionesPendientes SET utilizables = 0 where idEmpleado = idEmp AND year(fechaActualizacion) = (year(NOW())-1);
                    END;
                END IF;
			END;
		ELSEIF (AniosAntiguedad  >= 20 ) || (AniosAntiguedad  <= 24 )THEN
			BEGIN
                IF(SELECT COUNT(*) FROM tr_vacacionesPendientes WHERE idEmpleado = idEmp AND year(fechaActualizacion) = year(NOW())) = 0 THEN
				    BEGIN
                        INSERT INTO tr_vacacionesPendientes VALUES (null,idEmp,20,NOW(), idChec, 1);
                        UPDATE tr_vacacionesPendientes SET utilizables = 0 where idEmpleado = idEmp AND year(fechaActualizacion) = (year(NOW())-1);
                    END;
                END IF;
			END;
		ELSEIF (AniosAntiguedad  = 25 )THEN
			BEGIN
                IF(SELECT COUNT(*) FROM tr_vacacionesPendientes WHERE idEmpleado = idEmp AND year(fechaActualizacion) = year(NOW())) = 0 THEN
				    BEGIN
                        INSERT INTO tr_vacacionesPendientes VALUES (null,idEmp,22,NOW(), idChec, 1);
                        UPDATE tr_vacacionesPendientes SET utilizables = 0 where idEmpleado = idEmp AND year(fechaActualizacion) = (year(NOW())-1);
                    END;
                END IF;
			END;
		ELSEIF (AniosAntiguedad  >= 26 ) || (AniosAntiguedad  <= 30 )THEN
			BEGIN
                IF(SELECT COUNT(*) FROM tr_vacacionesPendientes WHERE idEmpleado = idEmp AND year(fechaActualizacion) = year(NOW())) = 0 THEN
				    BEGIN
                        INSERT INTO tr_vacacionesPendientes VALUES (null,idEmp,24,NOW(), idChec, 1);
                        UPDATE tr_vacacionesPendientes SET utilizables = 0 where idEmpleado = idEmp AND year(fechaActualizacion) = (year(NOW())-1);
                    END;
                END IF;
			END;
		END IF;
	END IF;
	END LOOP;

	CLOSE cursorEmpleados;
	END