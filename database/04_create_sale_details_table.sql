CREATE TABLE IF NOT EXISTS `sale_details`
(
    `id`             int(10) unsigned NOT NULL AUTO_INCREMENT,
    `sales_id`       int(10) unsigned NOT NULL,
    `product_id`     int(10) unsigned NOT NULL,
    `purchase_price` numeric(16,2) NOT NULL DEFAULT 0,
    `price`          numeric(16,2) NOT NULL,
    `qty`            int(10) NULL,
    `total`          numeric(16,2) NOT NULL,
    PRIMARY KEY (`id`)
)