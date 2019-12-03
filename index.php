<?php

require_once('UKMconfig.inc.php');

define('STANDALONE_URL', 'https://datakultur'. (UKM_HOSTNAME == 'ukm.dev' ? '.ukm.dev' : 'org'));
define('STANDALONE_AJAX', 'false');
define('STANDALONE_SECTION', 'Møteplass datakultur');
define('STANDALONE_TITLE', 'Møteplass datakultur');
define('STANDALONE_DESCRIPTION', 'Vega scene, Oslo, lørdag 25.januar');
define('STANDALONE_TWIG_PATH', dirname(__FILE__) . '/twig/');

require_once('vendor/autoload.php');
require_once('vendor/ukmnorge/designbundle/UKMNorge/Standalone/Environment/loader.php');

WP_TWIG::setCacheDir( dirname(__FILE__).'/cache/' );

$environment = [
	'needs_environment' => true,
	'is_safe' => ['html']
];

WP_TWIG::addFilter('count', ['data', 'count'], $environment);
WP_TWIG::addFilter('countByCol', ['data', 'countByCol'], $environment);
WP_TWIG::addFilter('header', ['data','header']);


echo WP_TWIG::render( 'Datakultur/front', [] );