ALTER TABLE `invoice_expenses`
  CHANGE `amount` `cost` DOUBLE(6,2) NOT NULL,
  ADD COLUMN `currency_id` INT(10) UNSIGNED NULL AFTER `cost`,
  ADD FOREIGN KEY (`currency_id`) REFERENCES `currencies`(`id`);
