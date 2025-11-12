<?php

namespace Websailing\SubcolumnsBundle\Element;

use Contao\ContentElement;
use Contao\Database;

class ContentColsetPart extends ContentElement
{
    protected $strTemplate = 'ce_colsetPart';

    public function generate(): string
    {
        if ((defined('TL_MODE') && TL_MODE === 'BE') || (defined('TL_SCRIPT') && strpos((string)TL_SCRIPT, 'contao') !== false)) {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### Spaltenset Teil ###';
            $objTemplate->title = (string) ($this->headline ?: ($this->sc_name ?: ''));
            $objTemplate->id = $this->id;
            $objTemplate->link = 'ID '.$this->id;
            $objTemplate->href = '';
            return $objTemplate->parse();
        }
        return parent::generate();
    }

    protected function compile(): void
    {
        // Keine Klassen für Mittelteile
        $this->Template->col_class = '';
    }
}
