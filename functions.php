<?php
/**
 * functions.php - VTuber Wiki Theme entrypoint.
 * Loads the PSR-4 Autoloader and bootstraps the main Object-Oriented plugin.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// 1. Load and register PSR-4 Autoloader for VTWiki\Theme namespace
require_once get_template_directory() . '/inc/Core/Autoloader.php';
\VTWiki\Theme\Core\Autoloader::register();

// 2. Load global procedural helpers for template backward compatibility
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/custom-functions.php';

// 3. Bootstrap the core theme orchestrator via Singleton Pattern
\VTWiki\Theme\Core\Plugin::get_instance()->register();