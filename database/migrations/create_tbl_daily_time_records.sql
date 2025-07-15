CREATE TABLE `tbl_daily_time_records` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NOT NULL,
    `employee_no` VARCHAR(20) NOT NULL,
    `date` DATE NOT NULL,
    `time_in_am` TIME NULL,
    `time_out_am` TIME NULL,
    `time_in_pm` TIME NULL,
    `time_out_pm` TIME NULL,
    `undertime` VARCHAR(50) NULL,
    `total_hours` DECIMAL(5,2) NULL,
    `date_generated` DATE NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,


    KEY `idx_user_id` (`user_id`),
    KEY `idx_user_date` (`user_id`, `date`),
    KEY `idx_date` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



ALTER TABLE users ADD FULLTEXT fulltext_name (first_name, last_name);

