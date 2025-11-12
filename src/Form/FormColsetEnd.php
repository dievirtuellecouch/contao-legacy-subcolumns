<?php

namespace Websailing\SubcolumnsBundle\Form;

use Contao\Widget;

class FormColsetEnd extends Widget
{
    protected $strTemplate = 'form_formcolend';
    public function validate(): void {}
    public function generate(): string {
        if (defined('TL_MODE') && TL_MODE === 'BE') {
            return '';
        }
        $setKey = $GLOBALS['TL_CONFIG']['subcolumns'] ?? 'yaml3';
        $inside = (bool)($GLOBALS['TL_SUBCL'][$setKey]['inside'] ?? false);
        $tpl = $this->getTemplateObject();
        $tpl->useInside = $inside;
        return $tpl->parse();
    }
}
