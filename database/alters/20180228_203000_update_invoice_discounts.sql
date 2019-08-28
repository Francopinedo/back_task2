ALTER TABLE `admin_task`.`invoice_discounts`
  ADD COLUMN `percentage` TINYINT(4) NULL AFTER `amount`;

ALTER TABLE `admin_task`.`invoice_taxes`
  ADD COLUMN `percentage` TINYINT(4) NULL AFTER `amount`;
