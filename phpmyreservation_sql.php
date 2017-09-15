CREATE TABLE IF NOT EXISTS `phpmyreservation_reservations` (
  `reservation_id` int(10) NOT NULL AUTO_INCREMENT,
  `reservation_made_time` datetime NOT NULL,
  `reservation_year` smallint(4) NOT NULL,
  `reservation_week` tinyint(2) NOT NULL,
  `reservation_day` tinyint(1) NOT NULL,
  `reservation_time` varchar(100) NOT NULL,
  `reservation_price` decimal(10,2) NOT NULL,
  `reservation_user_id` int(10) NOT NULL,
  `reservation_user_email` varchar(100) NOT NULL,
  `reservation_user_name` varchar(100) NOT NULL,
  PRIMARY KEY (`reservation_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

CREATE TABLE IF NOT EXISTS `phpmyreservation_blocked` (
  `rscblocked_id` int(10) NOT NULL AUTO_INCREMENT,
  `reservation_week` tinyint(2) NOT NULL,
  `rscblocked_day` tinyint(1) NOT NULL,
  `rscblocked_time` varchar(100) NOT NULL,
  `reservation_resource` int(11) NOT NULL,
  PRIMARY KEY (`rscblocked_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;