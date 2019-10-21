--
-- Change default table engine to InnoDB;
--
ALTER TABLE `#__tj_activities` ENGINE = InnoDB;

--
-- Change default table CHARACTER to utf8mb4 and COLLATE to utf8mb4_unicode_ci;
--
ALTER TABLE `#__tj_activities` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

