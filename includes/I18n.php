<?php

namespace plugin\name;

/**
 * Class I18n
 *
 * Handles internationalization (i18n) by loading the plugin text domain.
 */
class I18n {

    /**
     * Load the plugin text domain for translation.
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            PLUGIN_NAME_NAME,
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );

    }

}

