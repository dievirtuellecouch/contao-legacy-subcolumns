<?php

namespace Websailing\SubcolumnsBundle\Element;

use Contao\ContentElement;

class ContentColsetEnd extends ContentElement
{
    protected $strTemplate = 'ce_colsetEnd';

    public function generate(): string
    {
        if ((defined('TL_MODE') && TL_MODE === 'BE') || (defined('TL_SCRIPT') && strpos((string)TL_SCRIPT, 'contao') !== false)) {
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### Spaltenset Ende ###';
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
        // No additional data, purely structural
    }
}
