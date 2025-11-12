<?php

namespace Websailing\SubcolumnsBundle\Element;

use Contao\ContentElement;

class ContentColsetStart extends ContentElement
{
    protected $strTemplate = 'ce_colsetStart';

    public function generate(): string
    {
        if ((defined('TL_MODE') && TL_MODE === 'BE') || (defined('TL_SCRIPT') && strpos((string)TL_SCRIPT, 'contao') !== false)) {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### Spaltenset Anfang ###';
            $objTemplate->title = (string) ($this->headline ?: ($this->sc_name ?: ''));
            $objTemplate->id = $this->id;
            $objTemplate->link = 'ID '.$this->id;
            $objTemplate->href = ''; // let Contao default links render
            return $objTemplate->parse();
        }
        return parent::generate();
    }

    protected function compile(): void
    {
        $setKey = $GLOBALS['TL_CONFIG']['subcolumns'] ?? 'flex';
        $scclass= $GLOBALS['TL_SUBCL'][$setKey]['scclass'] ?? 'sc-flex';
        $eqCls  = $GLOBALS['TL_SUBCL'][$setKey]['equalize'] ?? 'equalize';
        $equal  = ($this->sc_equalize ?? '') ? (' '.$eqCls) : '';
        // Nur generische Klassen, keine Abhängigkeit von Typ/Split
        $gapCls = !empty($this->sc_gapuse) ? ' has-gap' : '';
        $this->Template->sc_wrapper_class = trim($scclass.$gapCls.$equal);

        // Optionale CSS-Datei laden
        $css = $GLOBALS['TL_SUBCL'][$setKey]['files']['css'] ?? '';
        if ($css) {
            $GLOBALS['TL_CSS'][] = $css.'|static';
        }

        // Build CSS custom properties for column widths based on sc_type (e.g. 33x66)
        $styleParts = [];
        $type = trim((string) ($this->sc_type ?? ''));
        $colsCount = 0;
        if ($type !== '') {
            $raw = array_values(array_filter(array_map('trim', explode('x', $type)), 'strlen'));
            $colsCount = count($raw);
            for ($i = 0; $i < $colsCount; $i++) {
                $num = preg_replace('~[^0-9]~', '', $raw[$i]);
                if ($num !== '') {
                    // Use the value as-is in percent (e.g., 33 -> 33%)
                    $styleParts[] = '--sc-col-'.($i+1).': '.$num.'%';
                }
            }
        }
        if ($colsCount > 0) {
            $styleParts[] = '--sc-cols: '.$colsCount;
        }
        // Gap handling: if enabled, set explicit gap; otherwise CSS default (5px) applies
        if (!empty($this->sc_gapuse)) {
            $gapVal = trim((string)($this->sc_gap ?? ''));
            if ($gapVal === '') {
                $gapVal = (string)($GLOBALS['TL_CONFIG']['subcolumns_gapdefault'] ?? '20');
            }
            $gapInt = (int)$gapVal;
            if ($gapInt < 0) { $gapInt = 0; }
            $styleParts[] = '--sc-gap: '.$gapInt.'px';
        }
        if (!empty($styleParts)) {
            $this->Template->wrapper_style = implode('; ', $styleParts);
        }

        // Keine spaltenspezifischen Klassen für Kinder
        $this->Template->col_class = '';
    }
}
