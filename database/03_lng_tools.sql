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
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tools Table';
insert into `lng_tools`(`id`,`name`,`shortname`,`status`,`updated_by`,`inserted_on`) values (1,'LO Number Generator View','lonumadmin',1,'mattheje','2017-01-19 17:33:25');
insert into `lng_tools`(`id`,`name`,`shortname`,`status`,`updated_by`,`inserted_on`) values (2,'LO Number Generator Create/Edit','lonumadminedit',1,'mattheje','2017-01-27 00:00:00');
insert into `lng_tools`(`id`,`name`,`shortname`,`status`,`updated_by`,`inserted_on`) values (3,'User and Tool Permissions Administration','useradmin',1,'mattheje','2017-01-27 00:00:00');
insert into `lng_tools`(`id`,`name`,`shortname`,`status`,`updated_by`,`inserted_on`) values (4,'CSOD Deeplink Generator','csoddeeplink',1,'mattheje','2017-01-31 00:00:00');
insert into `lng_tools`(`id`,`name`,`shortname`,`status`,`updated_by`,`inserted_on`) values (5,'SCORM Auto-Complete Package Builder','scormautocompbuilder',1,'mattheje','2017-01-31 00:00:00');
insert into `lng_tools`(`id`,`name`,`shortname`,`status`,`updated_by`,`inserted_on`) values (6,'SCORM No-Complete Package Builder','scormnocompbuilder',1,'mattheje','2017-01-31 00:00:00');

