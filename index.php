<?php

use UKMNorge\DesignBundle\Utils\SEO;
use UKMNorge\DesignBundle\Utils\SEOImage;
use DateTime;

ini_set('display_errors', true);
require_once('UKMconfig.inc.php');

define('STANDALONE_URL', 'https://datakultur' . (UKM_HOSTNAME == 'ukm.dev' ? '.ukm.dev' : '.org'));
define('STANDALONE_AJAX', 'false');
define('STANDALONE_SECTION', 'Møteplass datakultur');
define('STANDALONE_TITLE', 'Møteplass datakultur');
define('STANDALONE_DESCRIPTION', 'Vega scene, Oslo, lørdag 25.januar');
define('STANDALONE_TWIG_PATH', dirname(__FILE__) . '/twig/');

require_once('vendor/autoload.php');
require_once('vendor/ukmnorge/designbundle/UKMNorge/Standalone/Environment/loader.php');

if( UKM_HOSTNAME != 'ukm.dev' ) {
    WP_TWIG::setCacheDir(dirname(__FILE__) . '/cache/');
}

$environment = [
    'needs_environment' => true,
    'is_safe' => ['html']
];

WP_TWIG::addFilter('count', ['data', 'count'], $environment);
WP_TWIG::addFilter('countByCol', ['data', 'countByCol'], $environment);
WP_TWIG::addFilter('header', ['data', 'header']);

SEO::setSiteName('Møteplass datakultur');
SEO::setImage( 
    new SEOImage( 
        STANDALONE_URL.'/grafikk-1800.png',
        1800,
        930,
        'png'
    )
);

if (!isset($_GET['PAGE'])) {
    $_GET['PAGE'] = 'front';
}
switch ($_GET['PAGE']) { 
    case 'pamelding':
        $template = 'pamelding';
    break;
    case 'info':
        $template = 'info';
    break;
    case 'program':
        $template = 'program';
    break;
    default:
        $template = 'front';
    break;
}

$pameldingsfrist = DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-19 23:59:59');

setlocale(LC_ALL, array('nb_NO.UTF-8','nb_NO@euro','nb_NO','norwegian'));

echo WP_TWIG::render(
    'Datakultur/'.$template, 
    [
        'pameldingsfrist' => $pameldingsfrist,
        'apen_pamelding' => new DateTime('now') < $pameldingsfrist
    ]
);
