<?php

namespace WordPressAutoAncestor\PostType;

class Product {
    /**
     * Undocumented function
     *
     * @return void
     */
    public static function getTotal() {
        $query = wc_get_products([
            'limit' => 1,
            'page' => 1,
            'status' => 'publish',
            'paginate' => true
        ]);

        return $query->total;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function update($product) {
        $terms = get_the_terms($product->get_id(), 'product_cat');

        foreach ($terms as $term) {
            // if no parent
            if (!isset($term->parent) || empty($term->parent)) {
                // ... go to next iteration
                continue;
            }

            // if we got here we have a parent to apply
            wp_set_post_terms($product->get_id(), [$term->parent], 'product_cat', true);
        }        
    }
}
