<?php

use Websailing\SubcolumnsBundle\Dca\TlFormFieldSubcolumns;

// Palettes for form fields
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['formcolstart'] = '{type_legend},type;{colset_legend},fsc_name,fsc_type,fsc_color,fsc_gapuse,fsc_gap;{colheight_legend:hide},fsc_equalize;{wrap_legend},fsc_wrap_id,fsc_wrap_class;{expert_legend:hide},class,accesskey,tabindex';
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['formcolpart']  = '{type_legend},type;{expert_legend:hide},class';
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['formcolend']   = '{type_legend},type;{expert_legend:hide},class';

// Fields
$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_name'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fsc_name'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength'=>255, 'tl_class'=>'w50'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_type'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fsc_type'],
    'exclude'   => true,
    'inputType' => 'select',
    'options_callback' => [TlFormFieldSubcolumns::class, 'getAllTypes'],
    'eval'      => ['mandatory'=>true, 'chosen'=>true, 'tl_class'=>'w50'],
    'sql'       => "varchar(32) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_gapuse'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fsc_gapuse'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => ['submitOnChange'=>false, 'tl_class'=>'clr w50'],
    'sql'       => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_gap'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fsc_gap'],
    'exclude'   => true,
    'inputType' => 'text',
    'default'   => '',
    'eval'      => ['maxlength'=>4, 'rgxp'=>'digit', 'tl_class'=>'w50'],
    'sql'       => "varchar(16) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_equalize'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fsc_equalize'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => ['tl_class'=>'w50 m12'],
    'sql'       => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_color'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fsc_color'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength'=>6, 'colorpicker'=>true, 'isHexColor'=>true, 'decodeEntities'=>true, 'tl_class'=>'w50 wizard'],
    'sql'       => "varchar(64) NOT NULL default ''",
];

// Wrapper-specific fields for the outer section (form start)
$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_wrap_class'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fsc_wrap_class'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength'=>255, 'tl_class'=>'w50', 'class'=>'tl_text_2'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_wrap_id'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['fsc_wrap_id'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['maxlength'=>255, 'tl_class'=>'w50'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

// Note: two short fields are used (fsc_wrap_id, fsc_wrap_class) to match expert layout

// Internal linkage fields
$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_parent'] = [ 'sql'=>"int(10) unsigned NOT NULL default '0'" ];
$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_childs'] = [ 'sql'=>"varchar(255) NOT NULL default ''" ];
$GLOBALS['TL_DCA']['tl_form_field']['fields']['fsc_sortid'] = [ 'sql'=>"int(2) unsigned NOT NULL default '0'" ];

// Callbacks for auto-maintenance
$GLOBALS['TL_DCA']['tl_form_field']['config']['onsubmit_callback'][] = [TlFormFieldSubcolumns::class, 'onFirstSubmit'];
$GLOBALS['TL_DCA']['tl_form_field']['config']['ondelete_callback'][] = [TlFormFieldSubcolumns::class, 'onDelete'];
