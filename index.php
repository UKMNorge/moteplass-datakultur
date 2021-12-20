<?php

use UKMNorge\DesignBundle\Utils\SEO;
use UKMNorge\DesignBundle\Utils\SEOImage;

ini_set('display_errors', true);
require_once('UKMconfig.inc.php');

define('STANDALONE_URL', 'https://datakultur' . (UKM_HOSTNAME == 'ukm.dev' ? '.ukm.dev' : '.org'));
define('STANDALONE_AJAX', 'false');
define('STANDALONE_SECTION', 'Møteplass datakultur');
define('STANDALONE_TITLE', 'Møteplass datakultur');
define('STANDALONE_DESCRIPTION', 'En rapport om ungdommens behov for flere sosiale arenaer med gaming i fokus');
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
        STANDALONE_URL.'/grafikk-1800_ny.png',
        1800,
        930,
        'png'
    )
);

$release = DateTime::createFromFormat('Y-m-d H:i:s', '2020-09-08 00:00:00');
$now = new DateTime();
$released = $now > $release;


$is_frontpage = !isset($_GET['PAGE']);

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
        
    case 'rapport':
        $template = 'rapport';
    break;
        
    case 'anbefalinger':
        $template = 'anbefalinger';
    break;
        
        case 'veileder':
        $template = 'veileder';
    break;

    case 'timer':
        $template = 'timer';
    break;

    case 'kontroll':
        $template = 'kontroll';
    break;

    default:
        if( $is_frontpage && !$released) {
            $template = 'kommersnart';
            break;
        }
        $template = 'front';
    break;
    
}

$pameldingsfrist = DateTime::createFromFormat('Y-m-d H:i:s', '2020-01-19 23:59:59');

setlocale(LC_ALL, array('nb_NO.UTF-8','nb_NO@euro','nb_NO','norwegian'));

echo WP_TWIG::render(
    'Datakultur/'.$template, 
    [
        'pameldingsfrist' => $pameldingsfrist,
        'apen_pamelding' => new DateTime('now') < $pameldingsfrist,
        'current_page' => $template,
        'release_date' => $release,
        'released' => $released
    ]
);
