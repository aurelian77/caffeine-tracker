-- -----------------------------------------------------------

DROP TABLE IF EXISTS `cf_users`;

CREATE TABLE `cf_users`(
    `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `is_banned` TINYINT UNSIGNED DEFAULT NULL COMMENT 'Do not delete users, just ban them',
    `username` VARCHAR(50) NOT NULL UNIQUE COMMENT 'Could be its name',
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` CHAR(128) DEFAULT NULL COMMENT 'SHA512',
    `role_id` TINYINT UNSIGNED DEFAULT NULL COMMENT 'See cf_roles table',
    `picture_extension` VARCHAR(4) DEFAULT NULL COMMENT 'Picture is not required, is not a social network',
    `last_read_log_id` BIGINT UNSIGNED DEFAULT NULL COMMENT 'See cf_log table',
    `invitation_hash` CHAR(128) DEFAULT NULL COMMENT 'After he reset his password becomes NULL',
    
    KEY(`role_id`),
    KEY(`last_read_log_id`)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- -----------------------------------------------------------

DROP TABLE IF EXISTS `cf_task_statuses`;

CREATE TABLE `cf_task_statuses`(
    `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO `cf_task_statuses` SET `name` = 'In Plan';
INSERT INTO `cf_task_statuses` SET `name` = 'Estimated';
INSERT INTO `cf_task_statuses` SET `name` = 'Approved For Work';
INSERT INTO `cf_task_statuses` SET `name` = 'Taken';
INSERT INTO `cf_task_statuses` SET `name` = 'Available';
INSERT INTO `cf_task_statuses` SET `name` = 'In Progress';
INSERT INTO `cf_task_statuses` SET `name` = 'Cannot Be Resolved';
INSERT INTO `cf_task_statuses` SET `name` = 'Ready For Test';
INSERT INTO `cf_task_statuses` SET `name` = 'In Testing';
INSERT INTO `cf_task_statuses` SET `name` = 'Not Accepted On Staging';
INSERT INTO `cf_task_statuses` SET `name` = 'Approved For Deployment';
INSERT INTO `cf_task_statuses` SET `name` = 'Live';
INSERT INTO `cf_task_statuses` SET `name` = 'Not accepted On Live';
INSERT INTO `cf_task_statuses` SET `name` = 'Approved On Live';
INSERT INTO `cf_task_statuses` SET `name` = 'Reopened';
INSERT INTO `cf_task_statuses` SET `name` = 'Abandoned';

-- -----------------------------------------------------------

DROP TABLE IF EXISTS `cf_tasks`;

CREATE TABLE `cf_tasks`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `project_id` SMALLINT UNSIGNED NOT NULL COMMENT 'See table cf_projects',
    
    `title` VARCHAR(250) NOT NULL,
    `description` LONGTEXT DEFAULT NULL COMMENT 'Some tasks does not have description',
    
    `status_id` TINYINT UNSIGNED NOT NULL COMMENT 'See cf_task_statuses table',
    
    `revert_changes` TINYINT UNSIGNED DEFAULT NULL,
    `changes_reverted` TINYINT UNSIGNED DEFAULT NULL,
    
    `created_by` SMALLINT UNSIGNED NOT NULL COMMENT 'See table cf_users',
    
    `last_update` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'On first insert is creation time',

    `priority` ENUM('High','Normal','Low') DEFAULT 'Normal',
    `high_priority_reason` VARCHAR(250) DEFAULT NULL COMMENT 'Plain short text',

    `cannot_be_resolved_reason` VARCHAR(250) DEFAULT NULL,
    `not_accepted_on_staging_reason` VARCHAR(250) DEFAULT NULL,
    `not_accepted_on_live_reason` VARCHAR(250) DEFAULT NULL,
    `reopened_reason` VARCHAR(250) DEFAULT NULL,
    `abandoned_reason` VARCHAR(250) DEFAULT NULL,
    
    KEY(`project_id`),
    KEY(`status_id`),
    KEY(`created_by`)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- -----------------------------------------------------------

DROP TABLE IF EXISTS `cf_log`;

CREATE TABLE `cf_log`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `log_type` ENUM('comment','status','time') NOT NULL,
    `task_id` BIGINT UNSIGNED NOT NULL COMMENT 'See table cf_tasks',
    `last_update` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'For sorting we use id column',
    `spent_time` MEDIUMINT UNSIGNED DEFAULT NULL COMMENT 'In minutes',
    `content` LONGTEXT DEFAULT NULL COMMENT 'Time spent could not have a reason',
    
    KEY(`task_id`)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- -----------------------------------------------------------

DROP TABLE IF EXISTS `cf_files`;

CREATE TABLE `cf_files`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `subfolder` ENUM('pages','tasks','comments') NOT NULL COMMENT 'E.g. /files/{pages}/:page_id:/:timestamp:.:extension: - page=0(null) means is a company page',
    `extension` VARCHAR(4) DEFAULT NULL COMMENT 'Should be able to upload files like .htaccess or without extension'
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Usually they are other types than images';

-- :: IMAGES :: (note that this project isn't a social network, for large-image.png):
-- /files/projects/:logo_project_id:.:extension: (ratio: w2/h1)
-- /files/users/:user_id:.:extension: (ratio: w1/h1)

-- -----------------------------------------------------------

DROP TABLE IF EXISTS `cf_tasks_watchers`;

CREATE TABLE `cf_tasks_watchers`(
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `task_id` BIGINT UNSIGNED NOT NULL COMMENT 'See cf_tasks table',
    `user_id` SMALLINT UNSIGNED NOT NULL COMMENT 'See cf_users table',
    
    KEY(`task_id`),
    KEY(`user_id`),
    UNIQUE KEY(`task_id`,`user_id`)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- -----------------------------------------------------------

DROP TABLE IF EXISTS `cf_projects`;

CREATE TABLE `cf_projects`(
    `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `short_name` VARCHAR(12) NOT NULL UNIQUE COMMENT 'Letters (upp., low.), numbers, and -',
    `title` VARCHAR(250) NOT NULL UNIQUE,
    `description` LONGTEXT DEFAULT NULL COMMENT 'Some projects does not have a description',
    `logo_extension` VARCHAR(4) DEFAULT NULL COMMENT 'Logo is not a requirement'
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- -----------------------------------------------------------

DROP TABLE IF EXISTS `cf_pages`;

CREATE TABLE `cf_pages`(
    `id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `project_id` SMALLINT UNSIGNED DEFAULT NULL COMMENT 'NULL means is a company page',
    `title` VARCHAR(250) NOT NULL,
    `content` LONGTEXT DEFAULT NULL,
    `last_update` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'On first insert is creation time'
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- -----------------------------------------------------------

DROP TABLE IF EXISTS `cf_roles`;

CREATE TABLE `cf_roles`(
    `id` TINYINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

INSERT INTO `cf_roles` SET `name` = 'Manager';
INSERT INTO `cf_roles` SET `name` = 'Contributor';

-- -----------------------------------------------------------