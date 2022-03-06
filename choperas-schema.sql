SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- --------------------------------------------------------

--
-- Table structure for table `ccaas`
--

CREATE TABLE `ccaas` (
  `id` int(2) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gasolineras`
--

CREATE TABLE `gasolineras` (
  `id` int(9) NOT NULL,
  `id_localidad` int(6) NOT NULL,
  `id_municipio` int(6) NOT NULL,
  `id_provincia` int(6) NOT NULL,
  `id_ccaa` int(2) NOT NULL,
  `horario` varchar(300) NOT NULL,
  `cp` int(5) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `rotulo` varchar(300) NOT NULL,
  `tipo_venta` varchar(2) NOT NULL,
  `margen` varchar(2) NOT NULL,
  `remision` varchar(3) NOT NULL,
  `latitud` varchar(20) NOT NULL,
  `longitud` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `localidades`
--

CREATE TABLE `localidades` (
  `id` int(6) NOT NULL,
  `id_municipio` int(6) NOT NULL,
  `id_provincia` int(6) NOT NULL,
  `id_ccaa` int(2) NOT NULL,
  `nombre` int(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `municipios`
--

CREATE TABLE `municipios` (
  `id` int(6) NOT NULL,
  `id_provincia` int(6) NOT NULL,
  `id_ccaa` int(2) NOT NULL,
  `nombre` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `precios`
--

CREATE TABLE `precios` (
  `id` int(11) NOT NULL,
  `id_gasolinera` int(6) NOT NULL,
  `fecha` date NOT NULL,
  `biodiesel` decimal(3,3) NOT NULL,
  `bioetanol` decimal(3,3) NOT NULL,
  `gas_natural_comprimido` decimal(3,3) NOT NULL,
  `gas_natural_licuado` decimal(3,3) NOT NULL,
  `gases_licuados_del_petroleo` decimal(3,3) NOT NULL,
  `gasoleo_a` decimal(3,3) NOT NULL,
  `gasoleo_b` decimal(3,3) NOT NULL,
  `gasoleo_premium` decimal(3,3) NOT NULL,
  `gasolina_95_e10` decimal(3,3) NOT NULL,
  `gasolina_95_e5` decimal(3,3) NOT NULL,
  `gasolina_95_e5_premium` decimal(3,3) NOT NULL,
  `gasolina_98_e10` decimal(3,3) NOT NULL,
  `gasolina_98_e5` decimal(3,3) NOT NULL,
  `hidrogeno` decimal(3,3) NOT NULL,
  `porcentaje_bioetanol` decimal(3,3) NOT NULL,
  `porcentaje_ester_metilico` decimal(3,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `provincias`
--

CREATE TABLE `provincias` (
  `id` int(6) NOT NULL,
  `id_ccaa` int(2) NOT NULL,
  `nombre` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ccaas`
--
ALTER TABLE `ccaas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gasolineras`
--
ALTER TABLE `gasolineras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_municipio` (`id_municipio`),
  ADD KEY `id_provincia` (`id_provincia`),
  ADD KEY `id_ccaa` (`id_ccaa`),
  ADD KEY `id_localidad` (`id_localidad`);

--
-- Indexes for table `localidades`
--
ALTER TABLE `localidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_municipio` (`id_municipio`),
  ADD KEY `id_provincia` (`id_provincia`),
  ADD KEY `id_ccaa` (`id_ccaa`);

--
-- Indexes for table `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_provincia` (`id_provincia`),
  ADD KEY `id_ccaa` (`id_ccaa`);

--
-- Indexes for table `precios`
--
ALTER TABLE `precios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_gasolinera` (`id_gasolinera`);

--
-- Indexes for table `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ccaa` (`id_ccaa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ccaas`
--
ALTER TABLE `ccaas`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gasolineras`
--
ALTER TABLE `gasolineras`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `localidades`
--
ALTER TABLE `localidades`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `precios`
--
ALTER TABLE `precios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `provincias`
--
ALTER TABLE `provincias`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gasolineras`
--
ALTER TABLE `gasolineras`
  ADD CONSTRAINT `gasolineras_ibfk_1` FOREIGN KEY (`id_ccaa`) REFERENCES `ccaas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gasolineras_ibfk_2` FOREIGN KEY (`id_provincia`) REFERENCES `provincias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gasolineras_ibfk_3` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gasolineras_ibfk_4` FOREIGN KEY (`id_localidad`) REFERENCES `localidades` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `localidades`
--
ALTER TABLE `localidades`
  ADD CONSTRAINT `localidades_ibfk_1` FOREIGN KEY (`id_ccaa`) REFERENCES `ccaas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `localidades_ibfk_2` FOREIGN KEY (`id_provincia`) REFERENCES `provincias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `localidades_ibfk_3` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `municipios`
--
ALTER TABLE `municipios`
  ADD CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`id_ccaa`) REFERENCES `ccaas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `municipios_ibfk_2` FOREIGN KEY (`id_provincia`) REFERENCES `provincias` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `precios`
--
ALTER TABLE `precios`
  ADD CONSTRAINT `precios_ibfk_1` FOREIGN KEY (`id_gasolinera`) REFERENCES `gasolineras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `provincias`
--
ALTER TABLE `provincias`
  ADD CONSTRAINT `provincias_ibfk_1` FOREIGN KEY (`id_ccaa`) REFERENCES `ccaas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
