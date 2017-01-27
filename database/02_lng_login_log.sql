DROP TABLE IF EXISTS `lng_login_log`;
CREATE TABLE `lng_login_log` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `successful` tinyint DEFAULT 0 COMMENT '0=NO, 1=Yes',
  `attempted_on` datetime DEFAULT NULL,
  `remote_addr` varchar(255) COLLATE utf8_unicode_ci NULL,
  `referer` varchar(255) COLLATE utf8_unicode_ci NULL,
  `user_agent` varchar(255) COLLATE utf8_unicode_ci NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Login Log Table';