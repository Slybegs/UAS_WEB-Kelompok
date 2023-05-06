CREATE TABLE IF NOT EXISTS `customers`
(
    `id`             int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`           varchar(255) NOT NULL,
    `phone_number`   varchar(16) NULL,
    `address`        text NULL,
    PRIMARY KEY (`id`)
)