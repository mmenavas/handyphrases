<?php

/**
 * Load services definition file.
 */
$settings['container_yamls'][] = __DIR__ . '/services.yml';

/**
 * Include the Pantheon-specific settings file.
 *
 * n.b. The settings.pantheon.php file makes some changes
 *      that affect all envrionments that this site
 *      exists in.  Always include this file, even in
 *      a local development environment, to insure that
 *      the site settings remain consistent.
 */
include __DIR__ . "/settings.pantheon.php";

/**
 * If there is a local settings file, then include it
 */
$local_settings = __DIR__ . "/settings.local.php";
if (file_exists($local_settings)) {
  include $local_settings;
}
$settings['install_profile'] = 'minimal';

/**
 * Trusted Host Settings
 */
if (defined('PANTHEON_ENVIRONMENT')) {
  if (in_array($_ENV['PANTHEON_ENVIRONMENT'], array('dev', 'test', 'live'))) {
    $settings['trusted_host_patterns'][] = "{$_ENV['PANTHEON_ENVIRONMENT']}-{$_ENV['PANTHEON_SITE_NAME']}.pantheonsite.io";

    # Replace value with custom domain(s) added in the site Dashboard
    $settings['trusted_host_patterns'][] = '^.+\.handyphrases\.com$';
    $settings['trusted_host_patterns'][] = '^handyphrases\.com$';
  }
}

/**
 * Custom settings for Pantheon environments
 */
if (defined('PANTHEON_ENVIRONMENT') && PANTHEON_ENVIRONMENT == 'live') {
  // Anonymous caching - enabled.
  $conf['cache'] = 1;
  // Block caching - enabled.
  $conf['block_cache'] = 1;
  // Expiration of cached pages - 15 minutes.
  $conf['page_cache_maximum_age'] = 900;
  // Aggregate and compress CSS files in Drupal - on.
  $conf['preprocess_css'] = 1;
  // Aggregate JavaScript files in Drupal - on.
  $conf['preprocess_js'] = 1;
  // Minimum cache lifetime - always none.
  $conf['cache_lifetime'] = 0;
  // Cached page compression - always off.
  $conf['page_compression'] = 0;
  // Google Analytics.
  $conf['googleanalytics_account'] = 'UA-77566945-1';
}