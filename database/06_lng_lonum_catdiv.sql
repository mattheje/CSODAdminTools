DROP TABLE IF EXISTS `lng_lonum_catdiv`;
CREATE TABLE `lng_lonum_catdiv` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `division_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pl_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_number` int(11) DEFAULT '1',
  `status` tinyint DEFAULT 1 NOT NULL COMMENT '1=Active, 0=Inactive',
  `custom1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custom3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inserted_on` datetime DEFAULT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `xs_unq_lng_catdiv_code` (`code`),
  KEY `division_name` (`division_name`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT 'Category Divisions Table';

insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (1,'BU','Business','Business',1,null,null,null,'2016-01-11 10:10:34');
insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (2,'GK','General Knowledge','General Knowledge',1,null,null,null,'2016-01-11 10:10:34');
insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (3,'IR','Inter-personal Relationships','Inter-personal Relationships',1,null,null,null,'2016-01-11 10:10:34');
insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (4,'MG','Management','Management',1,null,null,null,'2016-01-11 10:10:34');
insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (5,'AC','Product/Access','Product/Fixed Networks',1,null,null,null,'2016-01-11 10:10:34');
insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (6,'AP','Product/Applications','Product/IP Platforms',1,null,null,null,'2016-01-11 10:10:34');
insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (7,'ER','Product/Carrier Ethernet and IP Routing','Product/IP Routing',1,null,null,null,'2016-01-11 10:10:34');
insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (8,'MO','Product/Mobile Network','Product/Wireless',1,null,null,null,'2016-01-11 10:10:34');
insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (9,'OP','Product/Optical Networking Products','Product/IP Transport/',1,null,null,null,'2016-01-11 10:10:34');
insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (10,'WT','Product/Wireless Access and Transmission','Product/IP Wireless Access & Transmission',1,null,null,null,'2016-01-11 10:10:34');
insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (11,'TI','Technology/Internal Methods and Tools','Technology/Internal Methods and Tools',1,null,null,null,'2016-01-11 10:10:34');
insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (12,'TP','Technology/Product or Service-Related','Technology/Product or Service-Related',1,null,null,null,'2016-01-11 10:10:34');
insert into `lng_lonum_catdiv`(`id`,`code`,`division_name`,`pl_name`,`start_number`,`custom1`,`custom2`,`custom3`,`inserted_on`) values (13,'OS','Product/Network, Service Management and OSS','Multiple',1,null,null,null,'2016-01-11 10:10:34');
