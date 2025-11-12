<?php

use Contao\DataContainer;
use Websailing\SubcolumnsBundle\Dca\TlContentSubcolumns;

// Content element palettes
$GLOBALS['TL_DCA']['tl_content']['palettes']['colsetStart'] = '{type_legend},type;{colset_legend},sc_name,sc_type,sc_color,sc_gapuse,sc_gap;{colheight_legend:hide},sc_equalize;{wrap_legend},sc_wrap_id,sc_wrap_class;{protected_legend:hide},protected;{expert_legend:hide},guests,invisible,cssID,space';
$GLOBALS['TL_DCA']['tl_content']['palettes']['colsetPart']  = '{type_legend},type;{expert_legend:hide},cssID,space,invisible';
$GLOBALS['TL_DCA']['tl_content']['palettes']['colsetEnd']   = '{type_legend},type;{expert_legend:hide},cssID,space,invisible';

// Fields
$GLOBALS['TL_DCA']['tl_content']['fields']['sc_name'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['sc_name'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength'=>255, 'unique'=>false, 'tl_class'=>'w50'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sc_type'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['sc_type'],
    'exclude'   => true,
    'inputType' => 'select',
    'options_callback' => [TlContentSubcolumns::class, 'getAllTypes'],
    'eval'      => ['mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'],
    'sql'       => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sc_equalize'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['sc_equalize'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => ['tl_class'=>'w50 m12'],
    'sql'       => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sc_gapuse'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['sc_gapuse'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => ['tl_class'=>'clr w50'],
    'sql'       => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sc_gap'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['sc_gap'],
    'exclude'   => true,
    'inputType' => 'text',
    'default'   => '',
    'eval'      => ['maxlength'=>4, 'rgxp'=>'digit', 'tl_class'=>'w50'],
    'sql'       => "varchar(16) NOT NULL default ''",
];

// Wrapper-specific fields for the outer section
$GLOBALS['TL_DCA']['tl_content']['fields']['sc_wrap_class'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['sc_wrap_class'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength'=>255, 'tl_class'=>'w50', 'class'=>'tl_text_2'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['sc_wrap_id'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['sc_wrap_id'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength'=>255, 'tl_class'=>'w50'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

// Entfernt das alte Kombifeld, wir nutzen sc_wrap_id/sc_wrap_class separat
unset($GLOBALS['TL_DCA']['tl_content']['fields']['sc_wrap']);

$GLOBALS['TL_DCA']['tl_content']['fields']['sc_color'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['sc_color'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength'=>6, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'],
    'sql'       => "varchar(64) NOT NULL default ''",
];

// Note: two short fields are used (sc_wrap_id, sc_wrap_class) to match expert layout

// Internal linkage fields
$GLOBALS['TL_DCA']['tl_content']['fields']['sc_parent'] = [ 'sql'=>"int(10) unsigned NOT NULL default '0'" ];
$GLOBALS['TL_DCA']['tl_content']['fields']['sc_childs'] = [ 'sql'=>"varchar(255) NOT NULL default ''" ];
$GLOBALS['TL_DCA']['tl_content']['fields']['sc_sortid'] = [ 'sql'=>"int(2) unsigned NOT NULL default '0'" ];

// Callbacks to maintain children
$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] = [TlContentSubcolumns::class, 'scOnFirstSubmit'];
$GLOBALS['TL_DCA']['tl_content']['config']['ondelete_callback'][] = [TlContentSubcolumns::class, 'scDelete'];
