CREATE TABLE IF NOT EXISTS `#__tj_activities` (
	`id`       INT(11)     NOT NULL AUTO_INCREMENT,
	`actor` text(900),
	`actor_id` int(12),
	`object` text(900),
	`object_id` int(12),
	`target` text(900),
	`target_id` int(12),
	`type` text(900),
	`template` text(900),
	`access` tinyint(2),
	`state` tinyint(2),
	`location` text(900),
	`latitude` float(10,6),
	`longitude` float(10,6),
	`created_date` datetime DEFAULT NULL,
	`updated_date` datetime DEFAULT NULL,
	PRIMARY KEY (`id`)
)
	AUTO_INCREMENT =0
	DEFAULT CHARSET =utf8;
