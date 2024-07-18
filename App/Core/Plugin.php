<?php

namespace WordPressAutoAncestor\Core;

class Plugin {
    /**
     * Register Activation Hook
     */
    public static function activation() {
        register_activation_hook(WORDPRESSAUTOANCESTOR_PATH, function() {
            if (version_compare(PHP_VERSION, WORDPRESSAUTOANCESTOR_PHP, '<')) {
                deactivate_plugins(plugin_basename( __FILE__ ));
                wp_die(
                    '<p>'
                    . sprintf(__(WORDPRESSAUTOANCESTOR_NAME . ' can not be activated because it requires a PHP version greater than %1$s.<br>Your PHP version can be updated by your hosting company.', WORDPRESSAUTOANCESTOR_SLUG), WORDPRESSAUTOANCESTOR_PHP)
                    . '</p>
                    <a href="' . admin_url('plugins.php') . '">' . __( 'Go back', 'my_plugin' ) . '</a>'
                );
            }
        });
    }

    /**
     * Is plugin active?
     * Test if plugin active or in mu-plugins (forced active)
     */
    public static function active() {
        return (is_plugin_active(WORDPRESSAUTOANCESTOR_BASENAME) || file_exists(WPMU_PLUGIN_DIR . '/' . WORDPRESSAUTOANCESTOR_BASENAME)) ? true : false;
    }

    /**
     * Display admin notice
     * @param  string  $message
     * @param  string  $type
     * @param  boolean $dismissible
     */
    public static function notice($message = '', $type = 'success', $dismissible = true) {
        add_action('admin_notices', function() use ($message, $type, $dismissible) {
            ?>
            <div class="notice <?php echo $type ? 'notice-' . $type : ''; ?> <?php echo $dismissible ? 'is-dismissible' : ''; ?>">
                <p><?php _e($message, WORDPRESSAUTOANCESTOR_SLUG); ?></p>
            </div>
            <?php
        });
    }
}
