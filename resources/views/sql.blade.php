INSERT INTO `wims`.`products`(`id`, `category_id`, `sub_category_id`, `product_name`, `product_code`, `product_weight`, `unit_id`, `sell_by`, `product_image`, `created_at`, `updated_at`) SELECT `id`, `category_id`, `sub_category_id`, `product_name`, `product_code`, `product_weight`, `unit_id`, `sell_by`, `product_image`, `created_at`, `updated_at` FROM `wims2`.`products`;

<!-- for multiple culmn  -->

INSERT INTO `wims`.`product_stocks`(`id`, `pbrand_id`, `stock`, `stock_sold`, `product_price_piece`, `product_price_piece_wholesale`, `product_price_unit`, `product_price_unit_wholesale`, `purchasing_price`, `created_at`, `updated_at`) SELECT `product_stocks`.`id`, `product_stocks`.`pbrand_id`, `product_stocks`.`stock`,`product_stocks`. `stock_sold`, `product_price_piece`, `product_price_piece_wholesale`, `product_price_unit`, `product_price_unit_wholesale`, `purchasing_price`, `product_stocks`.`created_at`, `product_stocks`.`updated_at` FROM `wims2`.`product_brands`
 JOIN `product_stocks` ON `product_stocks`.`pbrand_id` = `product_brands`.`Id`;
<!DOCTYPE html>


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