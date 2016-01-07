

--
-- Table structure for table `grade_food_t`
--

CREATE TABLE IF NOT EXISTS `grade_food_t` (
  `gradedID_t` int(11) NOT NULL,
  `orderID_t` int(11) NOT NULL,
  `grade_t` char(1) NOT NULL,
  `submited_t` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;



--
-- Table structure for table `grade_service_t`
--

CREATE TABLE IF NOT EXISTS `grade_service_t` (
  `gradeID_t` int(11) NOT NULL,
  `orderID_t` int(11) NOT NULL,
  `grade_t` char(1) NOT NULL,
  `submited_t` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;



--
-- Table structure for table `menu_t`
--

CREATE TABLE IF NOT EXISTS `menu_t` (
  `menuID_t` int(11) NOT NULL,
  `name_t` varchar(20) NOT NULL,
  `type_t` char(1) NOT NULL,
  `price_t` varchar(5) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;



--
-- Table structure for table `order_food_t`
--

CREATE TABLE IF NOT EXISTS `order_food_t` (
  `order_food_ID_t` int(11) NOT NULL,
  `orderID_t` int(11) DEFAULT NULL,
  `menuID_t` int(11) NOT NULL,
  `amount_t` char(2) NOT NULL,
  `staatus_t` int(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=148 DEFAULT CHARSET=latin1;



--
-- Table structure for table `order_t`
--

CREATE TABLE IF NOT EXISTS `order_t` (
  `orderID_t` int(11) NOT NULL,
  `rowID_t` int(11) NOT NULL,
  `staatus_t` int(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;



--
-- Table structure for table `rows_t`
--

CREATE TABLE IF NOT EXISTS `rows_t` (
  `ID` int(11) NOT NULL,
  `seats_t` int(1) NOT NULL,
  `staatus_t` char(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;



--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL,
  `role_ID` int(11) NOT NULL DEFAULT '0',
  `password` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;


--
-- Indexes for table `grade_food_t`
--
ALTER TABLE `grade_food_t`
  ADD PRIMARY KEY (`gradedID_t`);

--
-- Indexes for table `grade_service_t`
--
ALTER TABLE `grade_service_t`
  ADD PRIMARY KEY (`gradeID_t`);

--
-- Indexes for table `menu_t`
--
ALTER TABLE `menu_t`
  ADD PRIMARY KEY (`menuID_t`);

--
-- Indexes for table `order_food_t`
--
ALTER TABLE `order_food_t`
  ADD PRIMARY KEY (`order_food_ID_t`);

--
-- Indexes for table `order_t`
--
ALTER TABLE `order_t`
  ADD PRIMARY KEY (`orderID_t`);

--
-- Indexes for table `rows_t`
--
ALTER TABLE `rows_t`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grade_food_t`
--
ALTER TABLE `grade_food_t`
  MODIFY `gradedID_t` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `grade_service_t`
--
ALTER TABLE `grade_service_t`
  MODIFY `gradeID_t` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `menu_t`
--
ALTER TABLE `menu_t`
  MODIFY `menuID_t` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `order_food_t`
--
ALTER TABLE `order_food_t`
  MODIFY `order_food_ID_t` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=148;
--
-- AUTO_INCREMENT for table `order_t`
--
ALTER TABLE `order_t`
  MODIFY `orderID_t` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `rows_t`
--
ALTER TABLE `rows_t`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
