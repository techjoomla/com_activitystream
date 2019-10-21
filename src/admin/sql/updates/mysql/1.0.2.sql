--
-- Change default table engine to InnoDB;
--
ALTER TABLE `#__tj_activities` ENGINE = InnoDB;

--
-- Change default table CHARACTER to utf8mb4 and COLLATE to utf8mb4_unicode_ci;
--
ALTER TABLE `#__tj_activities` CHANGE `actor` `actor` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `#__tj_activities` CHANGE `actor_id` `actor_id` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `#__tj_activities` CHANGE `object` `object` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `#__tj_activities` CHANGE `object_id` `object_id` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `#__tj_activities` CHANGE `target` `target` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `#__tj_activities` CHANGE `target_id` `target_id` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `#__tj_activities` CHANGE `type` `type` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `#__tj_activities` CHANGE `client` `client` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `#__tj_activities` CHANGE `template` `template` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `#__tj_activities` CHANGE `default_theme` `default_theme` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `#__tj_activities` CHANGE `formatted_text` `formatted_text` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `#__tj_activities` CHANGE `location` `location` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
