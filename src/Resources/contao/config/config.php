<?php

// Register content elements
$GLOBALS['TL_CTE']['subcolumns'] = [
    'colsetStart' => Websailing\SubcolumnsBundle\Element\ContentColsetStart::class,
    'colsetPart'  => Websailing\SubcolumnsBundle\Element\ContentColsetPart::class,
    'colsetEnd'   => Websailing\SubcolumnsBundle\Element\ContentColsetEnd::class,
];

// Register form fields
$GLOBALS['TL_FFL']['formcolstart'] = Websailing\SubcolumnsBundle\Form\FormColsetStart::class;
$GLOBALS['TL_FFL']['formcolpart']  = Websailing\SubcolumnsBundle\Form\FormColsetPart::class;
$GLOBALS['TL_FFL']['formcolend']   = Websailing\SubcolumnsBundle\Form\FormColsetEnd::class;

// Register wrappers so Contao indents records between start/part/end in BE lists
// Content elements
$GLOBALS['TL_WRAPPERS']['start'][]     = 'colsetStart';
$GLOBALS['TL_WRAPPERS']['separator'][] = 'colsetPart';
$GLOBALS['TL_WRAPPERS']['stop'][]      = 'colsetEnd';

// Form fields
$GLOBALS['TL_WRAPPERS']['start'][]     = 'formcolstart';
$GLOBALS['TL_WRAPPERS']['separator'][] = 'formcolpart';
$GLOBALS['TL_WRAPPERS']['stop'][]      = 'formcolend';

// Minimal subcolumns configuration using a generic flex approach
// Administrators can override this via config.php or a custom bundle if desired.
$GLOBALS['TL_CONFIG']['subcolumns'] = $GLOBALS['TL_CONFIG']['subcolumns'] ?? 'flex';

$GLOBALS['TL_SUBCL']['flex'] = [
    'label'   => 'Flex Columns',
    'scclass' => 'sc-flex',
    'equalize'=> 'sc-flex--equalize',
    'inside'  => false,
    'gap'     => true,
    'files'   => [ 'css' => 'bundles/subcolumns/flex/subcols.css', 'ie' => '' ],
    'sets'    => [
        // 2 columns
        '50x50' => [ ['sc-flex__col sc-flex__col--1-2'], ['sc-flex__col sc-flex__col--1-2'] ],
        '66x33' => [ ['sc-flex__col sc-flex__col--2-3'], ['sc-flex__col sc-flex__col--1-3'] ],
        '33x66' => [ ['sc-flex__col sc-flex__col--1-3'], ['sc-flex__col sc-flex__col--2-3'] ],
        '75x25' => [ ['sc-flex__col sc-flex__col--3-4'], ['sc-flex__col sc-flex__col--1-4'] ],
        '25x75' => [ ['sc-flex__col sc-flex__col--1-4'], ['sc-flex__col sc-flex__col--3-4'] ],
        '70x30' => [ ['sc-flex__col sc-flex__col--7-10'], ['sc-flex__col sc-flex__col--3-10'] ],
        '30x70' => [ ['sc-flex__col sc-flex__col--3-10'], ['sc-flex__col sc-flex__col--7-10'] ],
        '60x40' => [ ['sc-flex__col sc-flex__col--3-5'], ['sc-flex__col sc-flex__col--2-5'] ],
        '40x60' => [ ['sc-flex__col sc-flex__col--2-5'], ['sc-flex__col sc-flex__col--3-5'] ],
        // 3 columns
        '33x33x33' => [ ['sc-flex__col sc-flex__col--1-3'], ['sc-flex__col sc-flex__col--1-3'], ['sc-flex__col sc-flex__col--1-3'] ],
        '50x25x25' => [ ['sc-flex__col sc-flex__col--1-2'], ['sc-flex__col sc-flex__col--1-4'], ['sc-flex__col sc-flex__col--1-4'] ],
        '25x50x25' => [ ['sc-flex__col sc-flex__col--1-4'], ['sc-flex__col sc-flex__col--1-2'], ['sc-flex__col sc-flex__col--1-4'] ],
        '25x25x50' => [ ['sc-flex__col sc-flex__col--1-4'], ['sc-flex__col sc-flex__col--1-4'], ['sc-flex__col sc-flex__col--1-2'] ],
        '40x30x30' => [ ['sc-flex__col sc-flex__col--2-5'], ['sc-flex__col sc-flex__col--3-10'], ['sc-flex__col sc-flex__col--3-10'] ],
        '30x40x30' => [ ['sc-flex__col sc-flex__col--3-10'], ['sc-flex__col sc-flex__col--2-5'], ['sc-flex__col sc-flex__col--3-10'] ],
        '30x30x40' => [ ['sc-flex__col sc-flex__col--3-10'], ['sc-flex__col sc-flex__col--3-10'], ['sc-flex__col sc-flex__col--2-5'] ],
        '20x40x40' => [ ['sc-flex__col sc-flex__col--1-5'], ['sc-flex__col sc-flex__col--2-5'], ['sc-flex__col sc-flex__col--2-5'] ],
        '40x20x40' => [ ['sc-flex__col sc-flex__col--2-5'], ['sc-flex__col sc-flex__col--1-5'], ['sc-flex__col sc-flex__col--2-5'] ],
        '40x40x20' => [ ['sc-flex__col sc-flex__col--2-5'], ['sc-flex__col sc-flex__col--2-5'], ['sc-flex__col sc-flex__col--1-5'] ],
        // 4 columns
        '25x25x25x25' => [
            ['sc-flex__col sc-flex__col--1-4'], ['sc-flex__col sc-flex__col--1-4'], ['sc-flex__col sc-flex__col--1-4'], ['sc-flex__col sc-flex__col--1-4']
        ],
    ],
];


// Legacy YAML 3 sets (classes only; CSS not bundled)
$GLOBALS['TL_SUBCL']['yaml3'] = [
    'label'   => 'YAML 3 Standard',
    'scclass' => 'subcolumns',
    'equalize'=> 'equalize',
    'inside'  => true,
    'gap'     => true,
    'files'   => [
        'css' => 'bundles/subcolumns/yaml3/subcols.css',
        'ie'  => 'bundles/subcolumns/yaml3/subcolsIEHacks.css',
    ],
    'sets'    => [
        '20x20x20x20x20' => [ ['c20l','subcl'],['c20l','subc'],['c20l','subc'],['c20l','subc'],['c20r','subcr'] ],
        '25x25x25x25'    => [ ['c25l','subcl'],['c25l','subc'],['c25l','subc'],['c25r','subcr'] ],
        '50x16x16x16'    => [ ['c50l','subcl'],['c16l','subc'],['c16l','subc'],['c16r','subcr'] ],
        '33x33x33'       => [ ['c33l','subcl'],['c33l','subc'],['c33r','subcr'] ],
        '50x25x25'       => [ ['c50l','subcl'],['c25l','subc'],['c25r','subcr'] ],
        '25x50x25'       => [ ['c25l','subcl'],['c50l','subc'],['c25r','subcr'] ],
        '25x25x50'       => [ ['c25l','subcl'],['c25l','subc'],['c50r','subcr'] ],
        '40x30x30'       => [ ['c40l','subcl'],['c30l','subc'],['c30r','subcr'] ],
        '30x40x30'       => [ ['c30l','subcl'],['c40l','subc'],['c30r','subcr'] ],
        '30x30x40'       => [ ['c30l','subcl'],['c30l','subc'],['c40r','subcr'] ],
        '20x40x40'       => [ ['c20l','subcl'],['c40l','subc'],['c40r','subcr'] ],
        '40x20x40'       => [ ['c40l','subcl'],['c20l','subc'],['c40r','subcr'] ],
        '40x40x20'       => [ ['c40l','subcl'],['c40l','subc'],['c20r','subcr'] ],
        '85x15'          => [ ['c85l','subcl'],['c15r','subcr'] ],
        '80x20'          => [ ['c80l','subcl'],['c20r','subcr'] ],
        '75x25'          => [ ['c75l','subcl'],['c25r','subcr'] ],
        '70x30'          => [ ['c70l','subcl'],['c30r','subcr'] ],
        '66x33'          => [ ['c66l','subcl'],['c33r','subcr'] ],
        '62x38'          => [ ['c62l','subcl'],['c38r','subcr'] ],
        '60x40'          => [ ['c60l','subcl'],['c40r','subcr'] ],
        '55x45'          => [ ['c55l','subcl'],['c45r','subcr'] ],
        '50x50'          => [ ['c50l','subcl'],['c50r','subcr'] ],
        '45x55'          => [ ['c45l','subcl'],['c55r','subcr'] ],
        '40x60'          => [ ['c40l','subcl'],['c60r','subcr'] ],
        '38x62'          => [ ['c38l','subcl'],['c62r','subcr'] ],
        '33x66'          => [ ['c33l','subcl'],['c66r','subcr'] ],
        '30x70'          => [ ['c30l','subcl'],['c70r','subcr'] ],
        '25x75'          => [ ['c25l','subcl'],['c75r','subcr'] ],
        '20x80'          => [ ['c20l','subcl'],['c80r','subcr'] ],
        '15x85'          => [ ['c15l','subcl'],['c85r','subcr'] ],
    ],
];

// Legacy YAML 3 extended sets
$GLOBALS['TL_SUBCL']['yaml3_additional'] = [
    'label'   => 'YAML 3 Erweitert',
    'scclass' => 'subcolumns',
    'equalize'=> 'equalize',
    'inside'  => true,
    'gap'     => true,
    'files'   => [
        'css' => 'bundles/subcolumns/yaml3/subcols_extended.css',
        'ie'  => 'bundles/subcolumns/yaml3/subcolsIEHacks_extended.css',
    ],
    'sets'    => [
        '20x20x20x20x20' => [ ['c20l','subcl'],['c20l','subc'],['c20l','subc'],['c20l','subc'],['c20r','subcr'] ],
        '25x25x25x25'    => [ ['c25l','subcl'],['c25l','subc'],['c25l','subc'],['c25r','subcr'] ],
        '50x16x16x16'    => [ ['c50l','subcl'],['c16l','subc'],['c16l','subc'],['c16r','subcr'] ],
        '33x33x33'       => [ ['c33l','subcl'],['c33l','subc'],['c33r','subcr'] ],
        '50x25x25'       => [ ['c50l','subcl'],['c25l','subc'],['c25r','subcr'] ],
        '25x50x25'       => [ ['c25l','subcl'],['c50l','subc'],['c25r','subcr'] ],
        '25x25x50'       => [ ['c25l','subcl'],['c25l','subc'],['c50r','subcr'] ],
        '40x30x30'       => [ ['c40l','subcl'],['c30l','subc'],['c30r','subcr'] ],
        '30x40x30'       => [ ['c30l','subcl'],['c40l','subc'],['c30r','subcr'] ],
        '30x30x40'       => [ ['c30l','subcl'],['c30l','subc'],['c40r','subcr'] ],
        '20x40x40'       => [ ['c20l','subcl'],['c40l','subc'],['c40r','subcr'] ],
        '40x20x40'       => [ ['c40l','subcl'],['c20l','subc'],['c40r','subcr'] ],
        '40x40x20'       => [ ['c40l','subcl'],['c40l','subc'],['c20r','subcr'] ],
        '85x15'          => [ ['c85l','subcl'],['c15r','subcr'] ],
        '80x20'          => [ ['c80l','subcl'],['c20r','subcr'] ],
        '75x25'          => [ ['c75l','subcl'],['c25r','subcr'] ],
        '70x30'          => [ ['c70l','subcl'],['c30r','subcr'] ],
        '66x33'          => [ ['c66l','subcl'],['c33r','subcr'] ],
        '62x38'          => [ ['c62l','subcl'],['c38r','subcr'] ],
        '60x40'          => [ ['c60l','subcl'],['c40r','subcr'] ],
        '55x45'          => [ ['c55l','subcl'],['c45r','subcr'] ],
        '50x50'          => [ ['c50l','subcl'],['c50r','subcr'] ],
        '45x55'          => [ ['c45l','subcl'],['c55r','subcr'] ],
        '40x60'          => [ ['c40l','subcl'],['c60r','subcr'] ],
        '38x62'          => [ ['c38l','subcl'],['c62r','subcr'] ],
        '33x66'          => [ ['c33l','subcl'],['c66r','subcr'] ],
        '30x70'          => [ ['c30l','subcl'],['c70r','subcr'] ],
        '25x75'          => [ ['c25l','subcl'],['c75r','subcr'] ],
        '20x80'          => [ ['c20l','subcl'],['c80r','subcr'] ],
        '15x85'          => [ ['c15l','subcl'],['c85r','subcr'] ],
    ],
];

// Legacy YAML 4 sets (classes only; CSS not bundled)
$GLOBALS['TL_SUBCL']['yaml4'] = [
    'label'   => 'YAML 4 Standard',
    'scclass' => 'ym-grid',
    'equalize'=> 'ym-equalize',
    'inside'  => true,
    'gap'     => true,
    'files'   => [
        'css' => 'bundles/subcolumns/yaml4/subcols.css',
        'ie'  => 'bundles/subcolumns/yaml4/subcolsIEHacks.css',
    ],
    'sets'    => [
        '20x20x20x20x20' => [ ['ym-g20 ym-gl','ym-gbox-left'],['ym-g20 ym-gl','ym-gbox'],['ym-g20 ym-gl','ym-gbox'],['ym-g20 ym-gl','ym-gbox'],['ym-g20 ym-gr','ym-gbox-right'] ],
        '50x16x16x16'    => [ ['ym-g50 ym-gl','ym-gbox-left'],['ym-g16 ym-gl','ym-gbox'],['ym-g16 ym-gl','ym-gbox'],['ym-g16 ym-gr','ym-gbox-right'] ],
        '25x25x25x25'    => [ ['ym-g25 ym-gl','ym-gbox-left'],['ym-g25 ym-gl','ym-gbox'],['ym-g25 ym-gl','ym-gbox'],['ym-g25 ym-gr','ym-gbox-right'] ],
        '25x25x50'       => [ ['ym-g25 ym-gl','ym-gbox-left'],['ym-g25 ym-gl','ym-gbox'],['ym-g50 ym-gr','ym-gbox-right'] ],
        '25x50x25'       => [ ['ym-g25 ym-gl','ym-gbox-left'],['ym-g50 ym-gl','ym-gbox'],['ym-g25 ym-gr','ym-gbox-right'] ],
        '50x25x25'       => [ ['ym-g50 ym-gl','ym-gbox-left'],['ym-g25 ym-gl','ym-gbox'],['ym-g25 ym-gr','ym-gbox-right'] ],
        '40x40x20'       => [ ['ym-g40 ym-gl','ym-gbox-left'],['ym-g40 ym-gl','ym-gbox'],['ym-g20 ym-gr','ym-gbox-right'] ],
        '40x20x40'       => [ ['ym-g40 ym-gl','ym-gbox-left'],['ym-g20 ym-gl','ym-gbox'],['ym-g40 ym-gr','ym-gbox-right'] ],
        '20x40x40'       => [ ['ym-g20 ym-gl','ym-gbox-left'],['ym-g40 ym-gl','ym-gbox'],['ym-g40 ym-gr','ym-gbox-right'] ],
        '33x33x33'       => [ ['ym-g33 ym-gl','ym-gbox-left'],['ym-g33 ym-gl','ym-gbox'],['ym-g33 ym-gr','ym-gbox-right'] ],
        '85x15'          => [ ['ym-g85 ym-gl','ym-gbox-left'],['ym-g15 ym-gr','ym-gbox-right'] ],
        '80x20'          => [ ['ym-g80 ym-gl','ym-gbox-left'],['ym-g20 ym-gr','ym-gbox-right'] ],
        '75x25'          => [ ['ym-g75 ym-gl','ym-gbox-left'],['ym-g25 ym-gr','ym-gbox-right'] ],
        '70x30'          => [ ['ym-g70 ym-gl','ym-gbox-left'],['ym-g30 ym-gr','ym-gbox-right'] ],
        '66x33'          => [ ['ym-g66 ym-gl','ym-gbox-left'],['ym-g33 ym-gr','ym-gbox-right'] ],
        '65x35'          => [ ['ym-g65 ym-gl','ym-gbox-left'],['ym-g35 ym-gr','ym-gbox-right'] ],
        '60x40'          => [ ['ym-g60 ym-gl','ym-gbox-left'],['ym-g40 ym-gr','ym-gbox-right'] ],
        '55x45'          => [ ['ym-g55 ym-gl','ym-gbox-left'],['ym-g45 ym-gr','ym-gbox-right'] ],
        '50x50'          => [ ['ym-g50 ym-gl','ym-gbox-left'],['ym-g50 ym-gr','ym-gbox-right'] ],
        '45x55'          => [ ['ym-g45 ym-gl','ym-gbox-left'],['ym-g55 ym-gr','ym-gbox-right'] ],
        '40x60'          => [ ['ym-g40 ym-gl','ym-gbox-left'],['ym-g60 ym-gr','ym-gbox-right'] ],
        '35x65'          => [ ['ym-g35 ym-gl','ym-gbox-left'],['ym-g65 ym-gr','ym-gbox-right'] ],
        '33x66'          => [ ['ym-g33 ym-gl','ym-gbox-left'],['ym-g66 ym-gr','ym-gbox-right'] ],
        '30x70'          => [ ['ym-g30 ym-gl','ym-gbox-left'],['ym-g70 ym-gr','ym-gbox-right'] ],
        '25x75'          => [ ['ym-g25 ym-gl','ym-gbox-left'],['ym-g75 ym-gr','ym-gbox-right'] ],
        '20x80'          => [ ['ym-g20 ym-gl','ym-gbox-left'],['ym-g80 ym-gr','ym-gbox-right'] ],
        '15x85'          => [ ['ym-g15 ym-gl','ym-gbox-left'],['ym-g85 ym-gr','ym-gbox-right'] ],
    ],
];

// Auto-include CSS of the currently selected set
$__set = $GLOBALS['TL_CONFIG']['subcolumns'] ?? 'flex';
// Default gap when none is provided (project can override in config)
$GLOBALS['TL_CONFIG']['subcolumns_gapdefault'] = $GLOBALS['TL_CONFIG']['subcolumns_gapdefault'] ?? 20;
if (isset($GLOBALS['TL_SUBCL'][$__set]['files']['css']) && $GLOBALS['TL_SUBCL'][$__set]['files']['css']) {
    $GLOBALS['TL_CSS'][] = $GLOBALS['TL_SUBCL'][$__set]['files']['css'] . '|static';
}
if (isset($GLOBALS['TL_SUBCL'][$__set]['files']['ie']) && $GLOBALS['TL_SUBCL'][$__set]['files']['ie']) {
    $GLOBALS['TL_CSS'][] = $GLOBALS['TL_SUBCL'][$__set]['files']['ie'] . '|static';
}
