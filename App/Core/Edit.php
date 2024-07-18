<?php

namespace WordPressAutoAncestor\Core;

class Edit {
    /**
     * Register
     */
    public static function register() {
        self::setObjectTerms();
    }

    /**
     * Action: set_object_terms
     */
    public static function setObjectTerms() {
        add_action('set_object_terms', function($object_id, $terms, $term_taxonomy_ids, $taxonomy) {
            // bail if not taxonomy ids to work with
            if (empty($term_taxonomy_ids)) {
                return false;
            }

            // loop through term ids
            foreach ($term_taxonomy_ids as $term_taxonomy_id) {
                // .. get he parent
                $parent = wp_get_term_taxonomy_parent_id($term_taxonomy_id, $taxonomy);

                // if no parent
                if (!isset($parent) || empty($parent)) {
                    // ... go to next iteration
                    continue;
                }

                // if we got here we have a parent to apply
                wp_set_post_terms($object_id, [$parent], $taxonomy, true);
            }
        }, 99, 4);
    }
}
