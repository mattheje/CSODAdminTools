DROP TABLE IF EXISTS `lng_user_permissions`;
CREATE TABLE `lng_user_permissions` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(10) NOT NULL,
  `tool_id` bigint(10) NOT NULL,
  `status` tinyint DEFAULT 1 NOT NULL COMMENT '1=Active, 0=Inactive',
  `updated_by` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `inserted_on` datetime DEFAULT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_permission` (`user_id`,`tool_id`),
  KEY `user_id` (`user_id`),
  KEY `tool_id` (`tool_id`),
  KEY `status` (`status`),
  CONSTRAINT `fk_lng_up_user_id` FOREIGN KEY (`user_id`) REFERENCES `lng_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_lng_up_tool_id` FOREIGN KEY (`tool_id`) REFERENCES `lng_tools` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User Permissions Table';
insert into `lng_user_permissions`(`id`,`user_id`,`tool_id`,`status`,`updated_by`,`inserted_on`) values (1,1,1,1,'mattheje',NOW());
