<?php

namespace Websailing\SubcolumnsBundle\Form;

use Contao\Widget;
use Contao\Database;

class FormColsetPart extends Widget
{
    protected $strTemplate = 'form_formcolpart';
    public function validate(): void {}
    public function generate(): string {
        if (defined('TL_MODE') && TL_MODE === 'BE') {
            return '';
        }
        $setKey = 'flex';
        $inside = (bool)($GLOBALS['TL_SUBCL'][$setKey]['inside'] ?? false);
        $tpl = $this->getTemplateObject();
        $tpl->useInside = $inside;
        $tpl->inside_class = '';
        // Keine Klassen für Mittelteile im Formular
        $tpl->col_class = '';
        // No inline widths: handled via classes and CSS only
        return $tpl->parse();
    }
}
