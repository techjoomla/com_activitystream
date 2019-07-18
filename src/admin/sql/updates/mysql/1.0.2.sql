ALTER TABLE `#__tj_activities` MODIFY `template` text;
ALTER TABLE `#__tj_activities` MODIFY `formatted_text` text;

ALTER TABLE `#__tj_activities` ENGINE = InnoDB;
ALTER TABLE `#__tj_activities` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;