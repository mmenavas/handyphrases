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
  // Expiration of cached pages - 15 minutes.
  $config['system.performance']['cache']['page']['max_age'] = 900;
  // Aggregate and compress CSS files in Drupal - on.
  $config['system.performance']['css']['preprocess'] = true;
  // Aggregate JavaScript files in Drupal - on.
  $config['system.performance']['js']['preprocess'] = true;
  // Google Analytics.
  $config['google_analytics.settings']['account'] = 'UA-77566945-1';
}