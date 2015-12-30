
--
-- Table structure for table `hinnangud_s88k`
--

CREATE TABLE IF NOT EXISTS `hinnangud_s88k` (
  `hinnangID` int(11) NOT NULL,
  `tellimusID` int(11) NOT NULL,
  `hinnang` char(1) NOT NULL,
  `lisatud` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `hinnangud_tellimus`
--

CREATE TABLE IF NOT EXISTS `hinnangud_tellimus` (
  `hinnangID` int(11) NOT NULL,
  `tellimusID` int(11) NOT NULL,
  `hinnang` char(1) NOT NULL,
  `lisatud` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `kasutajad`
--

CREATE TABLE IF NOT EXISTS `kasutajad` (
  `ID` int(11) NOT NULL,
  `roll_ID` int(11) NOT NULL DEFAULT '0',
  `password` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `menyy`
--

CREATE TABLE IF NOT EXISTS `menyy` (
  `menyyID` int(11) NOT NULL,
  `nimi` varchar(20) NOT NULL,
  `tyyp` char(1) NOT NULL,
  `hind` varchar(5) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Table structure for table `rajad`
--

CREATE TABLE IF NOT EXISTS `rajad` (
  `ID` int(11) NOT NULL,
  `kohti` int(1) NOT NULL,
  `staatus` char(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `tellimus`
--

CREATE TABLE IF NOT EXISTS `tellimus` (
  `tellimusID` int(11) NOT NULL,
  `rajaID` int(11) NOT NULL,
  `staatus` int(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `tellimus_toit`
--

CREATE TABLE IF NOT EXISTS `tellimus_toit` (
  `tellimus_toit_ID` int(11) NOT NULL,
  `tellimusID` int(11) DEFAULT NULL,
  `menyyID` int(11) NOT NULL,
  `kogus` char(2) NOT NULL,
  `staatus` int(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;



--
-- Indexes for table `hinnangud_s88k`
--
ALTER TABLE `hinnangud_s88k`
  ADD PRIMARY KEY (`hinnangID`);

--
-- Indexes for table `hinnangud_tellimus`
--
ALTER TABLE `hinnangud_tellimus`
  ADD PRIMARY KEY (`hinnangID`);

--
-- Indexes for table `kasutajad`
--
ALTER TABLE `kasutajad`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `menyy`
--
ALTER TABLE `menyy`
  ADD PRIMARY KEY (`menyyID`);

--
-- Indexes for table `rajad`
--
ALTER TABLE `rajad`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tellimus`
--
ALTER TABLE `tellimus`
  ADD PRIMARY KEY (`tellimusID`);

--
-- Indexes for table `tellimus_toit`
--
ALTER TABLE `tellimus_toit`
  ADD PRIMARY KEY (`tellimus_toit_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hinnangud_s88k`
--
ALTER TABLE `hinnangud_s88k`
  MODIFY `hinnangID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `hinnangud_tellimus`
--
ALTER TABLE `hinnangud_tellimus`
  MODIFY `hinnangID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `kasutajad`
--
ALTER TABLE `kasutajad`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `menyy`
--
ALTER TABLE `menyy`
  MODIFY `menyyID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `rajad`
--
ALTER TABLE `rajad`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tellimus`
--
ALTER TABLE `tellimus`
  MODIFY `tellimusID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `tellimus_toit`
--
ALTER TABLE `tellimus_toit`
  MODIFY `tellimus_toit_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=92;
