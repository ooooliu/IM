DROP TABLE IF EXISTS `im_users`;
CREATE TABLE `im_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机',
  `nickname` varchar(64) NOT NULL DEFAULT '' COMMENT '昵称',
  `password` varchar(128) NOT NULL DEFAULT '' COMMENT '密码',
  `head_url` varchar(256) NOT NULL DEFAULT '' COMMENT '头像',
  `app_id` int(6) NOT NULL DEFAULT 0 COMMENT '来源(平台)',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '用户状态 1:有效 0:无效',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `INDEX_APP_MOBILE` (`app_id`,`mobile`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS `im_records`;
CREATE TABLE `im_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `chat_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '群组id',
  `from_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '发送者id',
  `to_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '接收者id',
  `type` varchar(8) NOT NULL DEFAULT '' COMMENT '消息类型',
  `msg` text NOT NULL COMMENT '聊天内容',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '用户状态 0:正常 1:删除 2:撤回 3:屏蔽 ',
  `read` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否已读 0:未读 1:已读',
  `extends` varchar(256) NOT NULL DEFAULT '' COMMENT '扩展字段',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS `im_group`;
CREATE TABLE `im_group` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(64) NOT NULL DEFAULT '' COMMENT '群名称',
  `creator_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '创建者id',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '群头像',
  `info` varchar(255) NOT NULL DEFAULT '' COMMENT '群公告',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS `im_group_member`;
CREATE TABLE `im_group_member` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '群id',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '用户id',
  `remark` varchar(64) NOT NULL DEFAULT '' COMMENT '标签',
  `read_time` datetime NOT NULL DEFAULT '' COMMENT '阅读时间',
  `extends` varchar(256) NOT NULL DEFAULT '' COMMENT '扩展字段',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

DROP TABLE IF EXISTS `im_group_records`;
CREATE TABLE `im_group_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '群组id',
  `from_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '发送者id',
  `type` varchar(8) NOT NULL DEFAULT '' COMMENT '消息类型',
  `msg` text NOT NULL COMMENT '聊天内容',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '用户状态 0:正常 1:删除 2:撤回 3:屏蔽 ',
  `extends` varchar(256) NOT NULL DEFAULT '' COMMENT '扩展字段',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;