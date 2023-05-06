CREATE TABLE IF NOT EXISTS `products`
(
    `id`             int(10) unsigned NOT NULL AUTO_INCREMENT,
    `code`           varchar(255) NOT NULL,
    `name`           varchar(255) NOT NULL,
    `category`       varchar(255) NOT NULL,
    `purchase_price` numeric(16,2) NOT NULL,
    `sales_price`    numeric(16,2) NOT NULL,
    `qty`            int(10) NULL,
    PRIMARY KEY (`id`)
)