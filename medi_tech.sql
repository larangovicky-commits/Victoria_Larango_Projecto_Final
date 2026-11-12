-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2026 a las 04:19:33
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `medi_tech`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialmedico`
--

CREATE TABLE `historialmedico` (
  `ID_Historial` int(100) NOT NULL,
  `Documento_Paciente` int(12) NOT NULL,
  `Nombre_Apellido` varchar(100) NOT NULL,
  `Medico_Tratante` varchar(100) NOT NULL,
  `Matricula` int(20) NOT NULL,
  `Fecha` date DEFAULT NULL,
  `Tratamiento` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historialmedico`
--

INSERT INTO `historialmedico` (`ID_Historial`, `Documento_Paciente`, `Nombre_Apellido`, `Medico_Tratante`, `Matricula`, `Fecha`, `Tratamiento`) VALUES
(1, 35760922, 'Victoria Larango', 'Catalina Cacheiro', 2022, '0000-00-00', 'Se le hace revisión bucal, hay una pieza en mal estado, se le deriva a cirujano.'),
(2, 2000000, 'Matias Garcia', 'Jacinto Perez', 7878, '2022-12-02', 'Se le hace una inspección visual, se detecta problema en las encias, se le aplica tratamiento preventivo y se lo deriva a periodoncista.'),
(4, 2000000, 'Matias Garcia', 'Norberto Napolitano', 9009, '2022-12-13', 'Se le hizo la revision bucal y se le aplico limpieza para reducr el sarro, se le indico medicación para bajar la inflamacion.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `ID` int(20) NOT NULL,
  `Nombres_Apellidos` varchar(100) NOT NULL,
  `Telefono` int(12) NOT NULL,
  `Matricula` int(20) NOT NULL,
  `Especialidad` varchar(50) NOT NULL,
  `Fecha_Ingreso` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`ID`, `Nombres_Apellidos`, `Telefono`, `Matricula`, `Especialidad`, `Fecha_Ingreso`) VALUES
(1, 'Seleccione médico', 0, 0, '0000000000', '0000-00-00'),
(3, 'Catalina Cacheiro', 13456789, 2022, 'Dentista general', '2021-12-01'),
(4, 'Norberto Napolitano', 543254, 9009, 'Periodoncista ', '2022-12-01'),
(5, 'Jacinto Perez', 43214321, 7878, 'Dentista general', '2021-12-01'),
(7, 'Van Halen', 12121212, 8080, 'Dentista general', '2022-07-13'),
(8, 'Charly Garcia', 123456543, 1010, 'Odontopediatra ', '2018-12-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `ID` int(20) NOT NULL,
  `Nombres_Apellidos` varchar(100) NOT NULL,
  `Telefono` int(14) NOT NULL,
  `Documento` int(11) NOT NULL,
  `Edad` int(3) NOT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`ID`, `Nombres_Apellidos`, `Telefono`, `Documento`, `Edad`, `Fecha_Nacimiento`) VALUES
(1, 'Victoria Larango', 1128897830, 35760922, 31, '1991-06-18'),
(4, 'Matias Garcia', 1, 2000000, 44, '1978-08-04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `Documento_Paciente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historialmedico`
--
ALTER TABLE `historialmedico`
  ADD PRIMARY KEY (`ID_Historial`),
  ADD KEY `Matricula` (`Matricula`),
  ADD KEY `Documento_Paciente` (`Documento_Paciente`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Matricula` (`Matricula`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Documento` (`Documento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Documento_Paciente` (`Documento_Paciente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historialmedico`
--
ALTER TABLE `historialmedico`
  MODIFY `ID_Historial` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `medicos`
--
ALTER TABLE `medicos`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historialmedico`
--
ALTER TABLE `historialmedico`
  ADD CONSTRAINT `historialmedico_ibfk_1` FOREIGN KEY (`Documento_Paciente`) REFERENCES `pacientes` (`Documento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `historialmedico_ibfk_2` FOREIGN KEY (`Matricula`) REFERENCES `medicos` (`Matricula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`Documento_Paciente`) REFERENCES `pacientes` (`Documento`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
