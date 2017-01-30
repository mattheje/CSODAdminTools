DROP TABLE IF EXISTS `lng_tools`;
CREATE TABLE `lng_tools` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `shortname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint DEFAULT 1 NOT NULL COMMENT '1=Active, 0=Inactive',
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inserted_on` datetime DEFAULT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `shortname` (`shortname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tools Table';
insert into `lng_tools`(`id`,`name`,`shortname`,`status`,`updated_by`,`inserted_on`) values (1,'LO Number Generator View Only','lonumadmin',1,'mattheje',NOW());
insert into `lng_tools`(`id`,`name`,`shortname`,`status`,`updated_by`,`inserted_on`) values (2,'LO Number Generator Create/Edit','lonunadminedit',1,'mattheje',NOW());
insert into `lng_tools`(`id`,`name`,`shortname`,`status`,`updated_by`,`inserted_on`) values (3,'User Administration','useradmin',1,'mattheje',NOW());