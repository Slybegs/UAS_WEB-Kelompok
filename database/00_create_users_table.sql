CREATE TABLE IF NOT EXISTS `admins`
(
    `id`             int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name`           varchar(255) NOT NULL,
    `email`          varchar(255) NOT NULL,
    `password`       varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
)