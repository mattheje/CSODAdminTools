DROP TABLE IF EXISTS `lng_users`;
CREATE TABLE `lng_users` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `csod_userid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint DEFAULT 1 NOT NULL COMMENT '1=Active, 0=Inactive',
  `fname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source` char(1) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'A=ALU LDAP, N=NOKIA LDAP, D=DQuery, O=Other Legacy system, C=CSOD, M=Manual Entry',
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inserted_on` datetime DEFAULT NULL,
  `last_login_on` datetime DEFAULT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `csod_userid` (`csod_userid`),
  KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `lname` (`lname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Users Table';
insert into `lng_users`(`id`,`csod_userid`,`username`,`status`,`fname`,`lname`,`email`,`country`,`source`,`updated_by`,`inserted_on`,`last_login_on`) values (1,'69046752','mattheje',1,'Matthew','JENSEN','matthew.jensen@nokia.com','US','A','login',NOW(),NOW());
