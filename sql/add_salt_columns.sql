-- Add salt columns to support salted SHA-256 passwords
ALTER TABLE `user` 
  ADD COLUMN `salt` VARCHAR(64) NULL AFTER `password`;

ALTER TABLE `admin`
  ADD COLUMN `salt` VARCHAR(64) NULL AFTER `password`;


