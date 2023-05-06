CREATE TABLE IF NOT EXISTS `sales`
(
    `id`             int(10) unsigned NOT NULL AUTO_INCREMENT,
    `date`           date NOT NULL,
    `customer_id`    int(10) unsigned NOT NULL,
    `total_product`  int(10) NOT NULL DEFAULT 0,
    `total_price`    numeric(16,2) NOT NULL DEFAULT 0,
    `note`           text NULL,
    PRIMARY KEY (`id`)
)