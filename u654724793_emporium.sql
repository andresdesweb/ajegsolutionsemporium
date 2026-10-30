-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-10-2026 a las 19:32:42
-- Versión del servidor: 11.8.9-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u654724793_emporium`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tc_aplicaciones`
--

CREATE TABLE `tc_aplicaciones` (
  `idApp` int(11) NOT NULL,
  `nombreAplicacion` mediumtext NOT NULL,
  `descripcionApp` longtext NOT NULL,
  `urlApp` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tc_archivospoliticas`
--

CREATE TABLE `tc_archivospoliticas` (
  `idArchivo` int(11) NOT NULL,
  `tituloPolitica` mediumtext NOT NULL,
  `urlAchivo` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tc_departamento`
--

CREATE TABLE `tc_departamento` (
  `idDepartamento` int(11) NOT NULL,
  `nombreDepartamento` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tc_diasperiodonomina`
--

CREATE TABLE `tc_diasperiodonomina` (
  `idRegistro` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idPeriodo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tc_direccion`
--

CREATE TABLE `tc_direccion` (
  `idDireccion` int(11) NOT NULL,
  `nombreDireccion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tc_empleados`
--

CREATE TABLE `tc_empleados` (
  `idEmpleado` int(11) NOT NULL,
  `idChecador` int(11) DEFAULT NULL,
  `nombre` mediumtext DEFAULT NULL,
  `segundoNombre` mediumtext NOT NULL,
  `apellido_p` mediumtext NOT NULL,
  `apellido_m` mediumtext NOT NULL,
  `departamento` int(11) DEFAULT NULL,
  `direccion` int(11) NOT NULL,
  `ingreso` date DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `entrada` time DEFAULT NULL,
  `salida` time DEFAULT NULL,
  `entradaDos` time NOT NULL,
  `salidaDos` time NOT NULL,
  `idEncargado` int(11) DEFAULT NULL,
  `isActive` int(11) DEFAULT NULL,
  `puesto` mediumtext DEFAULT NULL,
  `entradaViernes` time NOT NULL,
  `salidaViernes` time NOT NULL,
  `acumulaVacs` int(11) NOT NULL,
  `fechaNacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tc_periodosnomina`
--

CREATE TABLE `tc_periodosnomina` (
  `idPeriodo` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tc_usuarios`
--

CREATE TABLE `tc_usuarios` (
  `idUsuario` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `tokenSession` mediumtext NOT NULL,
  `idEmp` int(11) NOT NULL,
  `primeraVez` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tr_accesoapps`
--

CREATE TABLE `tr_accesoapps` (
  `idRegistroApp` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `idApp` int(11) NOT NULL,
  `nivelAcceso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tr_incidencias`
--

CREATE TABLE `tr_incidencias` (
  `idPase` int(11) NOT NULL,
  `fechaPase` date NOT NULL,
  `nombreEmpleado` mediumtext NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `areaEmpleado` int(11) NOT NULL,
  `direccionEmpleado` int(11) NOT NULL,
  `entrada` time NOT NULL,
  `salida` time NOT NULL,
  `motivo` mediumtext NOT NULL,
  `tipoIncidencia` int(11) NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `idQuincena` int(11) NOT NULL,
  `inserta` mediumtext NOT NULL,
  `estado` int(11) NOT NULL,
  `comentarioNoProcede` mediumtext NOT NULL,
  `urlEvidencia` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tr_reportenomina`
--

CREATE TABLE `tr_reportenomina` (
  `idRegistro` int(11) NOT NULL,
  `idChecador` int(11) NOT NULL,
  `tipoChecada` varchar(11) NOT NULL,
  `fechaHora` datetime NOT NULL,
  `comentario` mediumtext DEFAULT NULL,
  `checador` mediumtext NOT NULL,
  `idPeriodo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tr_solicitudvacaciones`
--

CREATE TABLE `tr_solicitudvacaciones` (
  `folioSolicitud` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `numDias` int(11) NOT NULL,
  `dias` mediumtext NOT NULL,
  `empleado` mediumtext NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `fechaAceptacion` datetime NOT NULL,
  `activa` int(11) NOT NULL,
  `aniosServicio` int(11) NOT NULL,
  `diasDisfruteAteriormente` int(11) NOT NULL,
  `diasDispoDisfrute` int(11) NOT NULL,
  `saldoActualVacaciones` int(11) NOT NULL,
  `diasVacaCorrespon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tr_vacacionespendientes`
--

CREATE TABLE `tr_vacacionespendientes` (
  `idRegistro` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `diasPendientes` int(11) NOT NULL,
  `fechaActualizacion` date NOT NULL,
  `idChecador` int(11) NOT NULL,
  `utilizables` int(11) NOT NULL,
  `registroManual` int(11) NOT NULL,
  `registroVacaciones` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tr_vacacionespendientes151026`
--

CREATE TABLE `tr_vacacionespendientes151026` (
  `idRegistro` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `diasPendientes` int(11) NOT NULL,
  `fechaActualizacion` date NOT NULL,
  `idChecador` int(11) NOT NULL,
  `utilizables` int(11) NOT NULL,
  `registroManual` int(11) NOT NULL,
  `registroVacaciones` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tr_vacacionespendientes170626`
--

CREATE TABLE `tr_vacacionespendientes170626` (
  `idRegistro` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `diasPendientes` int(11) NOT NULL,
  `fechaActualizacion` date NOT NULL,
  `idChecador` int(11) NOT NULL,
  `utilizables` int(11) NOT NULL,
  `registroManual` int(11) NOT NULL,
  `registroVacaciones` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tr_vacacionespendientes251125`
--

CREATE TABLE `tr_vacacionespendientes251125` (
  `idRegistro` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `diasPendientes` int(11) NOT NULL,
  `fechaActualizacion` date NOT NULL,
  `idChecador` int(11) NOT NULL,
  `utilizables` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tr_vacacionespendientes270526`
--

CREATE TABLE `tr_vacacionespendientes270526` (
  `idRegistro` int(11) NOT NULL,
  `idEmpleado` int(11) NOT NULL,
  `diasPendientes` int(11) NOT NULL,
  `fechaActualizacion` date NOT NULL,
  `idChecador` int(11) NOT NULL,
  `utilizables` int(11) NOT NULL,
  `registroManual` int(11) NOT NULL,
  `registroVacaciones` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tc_aplicaciones`
--
ALTER TABLE `tc_aplicaciones`
  ADD PRIMARY KEY (`idApp`);

--
-- Indices de la tabla `tc_archivospoliticas`
--
ALTER TABLE `tc_archivospoliticas`
  ADD PRIMARY KEY (`idArchivo`);

--
-- Indices de la tabla `tc_departamento`
--
ALTER TABLE `tc_departamento`
  ADD PRIMARY KEY (`idDepartamento`);

--
-- Indices de la tabla `tc_diasperiodonomina`
--
ALTER TABLE `tc_diasperiodonomina`
  ADD PRIMARY KEY (`idRegistro`);

--
-- Indices de la tabla `tc_direccion`
--
ALTER TABLE `tc_direccion`
  ADD PRIMARY KEY (`idDireccion`);

--
-- Indices de la tabla `tc_empleados`
--
ALTER TABLE `tc_empleados`
  ADD PRIMARY KEY (`idEmpleado`);

--
-- Indices de la tabla `tc_periodosnomina`
--
ALTER TABLE `tc_periodosnomina`
  ADD PRIMARY KEY (`idPeriodo`);

--
-- Indices de la tabla `tc_usuarios`
--
ALTER TABLE `tc_usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- Indices de la tabla `tr_accesoapps`
--
ALTER TABLE `tr_accesoapps`
  ADD PRIMARY KEY (`idRegistroApp`);

--
-- Indices de la tabla `tr_incidencias`
--
ALTER TABLE `tr_incidencias`
  ADD PRIMARY KEY (`idPase`);

--
-- Indices de la tabla `tr_solicitudvacaciones`
--
ALTER TABLE `tr_solicitudvacaciones`
  ADD PRIMARY KEY (`folioSolicitud`);

--
-- Indices de la tabla `tr_vacacionespendientes`
--
ALTER TABLE `tr_vacacionespendientes`
  ADD PRIMARY KEY (`idRegistro`);

--
-- Indices de la tabla `tr_vacacionespendientes151026`
--
ALTER TABLE `tr_vacacionespendientes151026`
  ADD PRIMARY KEY (`idRegistro`);

--
-- Indices de la tabla `tr_vacacionespendientes170626`
--
ALTER TABLE `tr_vacacionespendientes170626`
  ADD PRIMARY KEY (`idRegistro`);

--
-- Indices de la tabla `tr_vacacionespendientes251125`
--
ALTER TABLE `tr_vacacionespendientes251125`
  ADD PRIMARY KEY (`idRegistro`);

--
-- Indices de la tabla `tr_vacacionespendientes270526`
--
ALTER TABLE `tr_vacacionespendientes270526`
  ADD PRIMARY KEY (`idRegistro`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tc_direccion`
--
ALTER TABLE `tc_direccion`
  MODIFY `idDireccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tc_empleados`
--
ALTER TABLE `tc_empleados`
  MODIFY `idEmpleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tc_usuarios`
--
ALTER TABLE `tc_usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tr_accesoapps`
--
ALTER TABLE `tr_accesoapps`
  MODIFY `idRegistroApp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tr_incidencias`
--
ALTER TABLE `tr_incidencias`
  MODIFY `idPase` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tr_solicitudvacaciones`
--
ALTER TABLE `tr_solicitudvacaciones`
  MODIFY `folioSolicitud` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tr_vacacionespendientes`
--
ALTER TABLE `tr_vacacionespendientes`
  MODIFY `idRegistro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tr_vacacionespendientes151026`
--
ALTER TABLE `tr_vacacionespendientes151026`
  MODIFY `idRegistro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tr_vacacionespendientes170626`
--
ALTER TABLE `tr_vacacionespendientes170626`
  MODIFY `idRegistro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tr_vacacionespendientes251125`
--
ALTER TABLE `tr_vacacionespendientes251125`
  MODIFY `idRegistro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tr_vacacionespendientes270526`
--
ALTER TABLE `tr_vacacionespendientes270526`
  MODIFY `idRegistro` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
