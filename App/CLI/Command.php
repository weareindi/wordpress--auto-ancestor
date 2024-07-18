<?php

namespace WordPressAutoAncestor\CLI;

use WP_CLI;
use WordPressAutoAncestor\PostType\Product;

class Command {
    public static function register() {
        if (!defined('WP_CLI') || !WP_CLI) {
            return null;
        }

        self::registerCommand();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private static function registerCommand() {
        WP_CLI::add_command('autoancestor', function($args) {
            $command = reset($args);

            if ($command === 'products') {
                return self::invokeProducts();
            }

            return self::invokeUnknown();

        }, [
            'shortdesc' => __('Auto-select ancestor terms/categories on all posts')
        ]);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private static function invokeUnknown() {
        WP_CLI::error('Unknown command');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private static function invokeProducts() {
        $time_start = time();
        self::updateProducts();
        $time_end = time();

        WP_CLI::success('Auto-Ancestor Completed in: '. ($time_end - $time_start) . ' seconds');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    private static function updateProducts() {
        WP_CLI::log('Updating Products');

        $total = Product::getTotal();
        
        for ($index = 0; $index < $total; $index++) {
            self::progress($total, $index);

            // get current product
            $products = wc_get_products([
                'limit' => 1,
                'status' => 'publish',
                'page' => $index + 1
            ]);

            Product::update($products[0]);
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $total
     * @param [type] $index
     * @return void
     */
    private static function progress($total, $index) {
        $current = $index + 1;

        $perc = floor(($current / $total) * 100);
        $left = 100 - $perc;
        $write = sprintf("\033[0G\033[2K[%'={$perc}s>%-{$left}s] - $perc%% - $current/$total", "", "");
        fwrite(STDERR, $write);

        if ($total == $current) {
            fwrite(STDERR, PHP_EOL);
        }
    }
}
