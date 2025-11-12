<?php

namespace Websailing\SubcolumnsBundle\Form;

use Contao\Widget;
use Contao\StringUtil;

class FormColsetStart extends Widget
{
    protected $strTemplate = 'form_formcolstart';
    public function validate(): void {}
    public function generate(): string {
        if (defined('TL_MODE') && TL_MODE === 'BE') {
            return '';
        }
        $setKey  = 'flex';
        $scclass = $GLOBALS['TL_SUBCL'][$setKey]['scclass'] ?? 'sc-flex';
        $inside  = (bool)($GLOBALS['TL_SUBCL'][$setKey]['inside'] ?? false);
        $eqClass = $GLOBALS['TL_SUBCL'][$setKey]['equalize'] ?? '';

        // Ensure CSS for the set is loaded
        $css = $GLOBALS['TL_SUBCL'][$setKey]['files']['css'] ?? '';
        if ($css) {
            $GLOBALS['TL_CSS'][] = $css.'|static';
        }

        $eq      = (!empty($this->fsc_equalize) && !empty($eqClass)) ? ($eqClass.' ') : '';
        $hasGap  = !empty($this->fsc_gapuse) ? ' has-gap' : '';
        // Keine colcount_N und keine col-<type>, nur generische Wrapper-Klassen
        $wrapper = trim($eq.($scclass ?: 'subcolumns').$hasGap.(($this->class ?? '') ? ' '.$this->class : ''));

        $tpl = $this->getTemplateObject();
        $tpl->sc_wrapper_class = $wrapper;
        // Build CSS custom properties for column widths based on fsc_type (e.g. 33x66)
        $styleParts = [];
        $type = trim((string) ($this->fsc_type ?? ''));
        $colsCount = 0;
        if ($type !== '') {
            $raw = array_values(array_filter(array_map('trim', explode('x', $type)), 'strlen'));
            $colsCount = count($raw);
            for ($i = 0; $i < $colsCount; $i++) {
                $num = preg_replace('~[^0-9]~', '', $raw[$i]);
                if ($num !== '') {
                    $styleParts[] = '--sc-col-'.($i+1).': '.$num.'%';
                }
            }
        }
        if ($colsCount > 0) {
            $styleParts[] = '--sc-cols: '.$colsCount;
        }
        // Gap handling: if enabled, set explicit gap; otherwise CSS default (5px) applies
        if (!empty($this->fsc_gapuse)) {
            $gapVal = trim((string)($this->fsc_gap ?? ''));
            if ($gapVal === '') {
                $gapVal = (string)($GLOBALS['TL_CONFIG']['subcolumns_gapdefault'] ?? '20');
            }
            $gapInt = (int)$gapVal;
            if ($gapInt < 0) { $gapInt = 0; }
            $styleParts[] = '--sc-gap: '.$gapInt.'px';
        }
        if (!empty($styleParts)) {
            $tpl->wrapper_style = implode('; ', $styleParts);
        }
        $tpl->useInside = $inside;
        $tpl->inside_class = '';
        // Keine Klassen für Kinder im Form-Wrapper
        $tpl->col_class = '';
        // No inline widths: handled via classes and CSS only
        return $tpl->parse();
    }
}
