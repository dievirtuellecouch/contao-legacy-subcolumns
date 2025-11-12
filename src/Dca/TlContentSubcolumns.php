<?php

namespace Websailing\SubcolumnsBundle\Dca;

use Contao\Database;
use Contao\DataContainer;
use Contao\Controller;
use Contao\Input;
use Contao\System;
use Contao\Widget as CtlWidget;
use Contao\TextField as CtlTextField;
use Contao\StringUtil;

class TlContentSubcolumns
{
    public function getAllTypes(): array
    {
        // Read from TL_SUBCL['flex'] sets
        $sets = $GLOBALS['TL_SUBCL']['flex']['sets'] ?? [];
        return array_keys($sets);
    }

    public function createPalette(DataContainer $dc): void
    {
        // Palette already defined; could be adapted per global config if needed
    }

    /**
     * After first submit of a newly created colsetStart, create the parts and end.
     * Uses the new_records session bag to detect first submit after creation.
     */
    public function scOnFirstSubmit(DataContainer $dc): void
    {
        if (!$dc->activeRecord || $dc->activeRecord->type !== 'colsetStart') return;
        // Only on first submit after creation
        $bag = System::getContainer()->get('request_stack')->getSession()->getBag('contao_backend');
        $newRecords = (array) ($bag->get('new_records') ?? []);
        if (empty($newRecords['tl_content']) || !\in_array((int)$dc->id, array_map('intval', $newRecords['tl_content']), true)) {
            return;
        }
        $db = Database::getInstance();
        $obj = $db->prepare('SELECT * FROM tl_content WHERE id=?')->limit(1)->execute($dc->id);
        if (!$obj->numRows) return;
        $type = (string) $obj->sc_type;
        if ($type === '') return;
        $pid = (int) $obj->pid;
        $sortingStart = (int) $obj->sorting;
        $name = (string) ($obj->sc_name ?: ('colset.'.$dc->id));
        $gap  = (string) $obj->sc_gap;
        $equal= (string) $obj->sc_equalize;

        $cols = array_filter(array_map('trim', explode('x', $type)), 'strlen');
        $colCount = max(2, count($cols));

        $childs = [];
        if ($obj->sc_childs) {
            $tmp = @unserialize($obj->sc_childs) ?: [];
            if (is_array($tmp)) { $childs = array_map('intval', $tmp); }
        }

        $moveRows = function(int $amount) use ($db, $pid, $sortingStart) {
            $db->prepare('UPDATE tl_content SET sorting = sorting + ? WHERE pid=? AND sorting > ?')
               ->execute($amount, $pid, $sortingStart);
        };

        // Only create children once on initial creation; never auto-update afterwards
        if (!$childs) {
            $moveRows(64 * ($colCount));
            for ($i=1; $i <= $colCount-1; $i++) {
                $set = [
                    'pid'=>$pid,
                    'tstamp'=>time(),
                    'sorting'=>$sortingStart+($i+1)*64,
                    'type'=>'colsetPart',
                    'cssID'=>'',
                    'sc_parent'=>$dc->id,
                    'sc_sortid'=>$i,
                    'sc_type'=>$type,
                ];
                $id = $db->prepare('INSERT INTO tl_content %s')->set($set)->execute()->insertId;
                $childs[] = (int)$id;
            }
            $end = [
                'pid'=>$pid,
                'tstamp'=>time(),
                'sorting'=>$sortingStart+($colCount+1)*64,
                'type'=>'colsetEnd',
                'cssID'=>'',
                'sc_parent'=>$dc->id,
                'sc_sortid'=>$colCount,
                'sc_type'=>$type,
            ];
            $endId = $db->prepare('INSERT INTO tl_content %s')->set($end)->execute()->insertId;
            $childs[] = (int)$endId;
            $db->prepare('UPDATE tl_content %s WHERE id=?')->set(['sc_childs'=>serialize($childs),'sc_name'=>$name])->execute($dc->id);
            // Remove id from new_records to prevent re-triggering
            $newRecords['tl_content'] = array_values(array_filter($newRecords['tl_content'], static fn($v) => (int)$v !== (int)$dc->id));
            $bag->set('new_records', $newRecords);
            return;
        }
        // From here on: do NOT auto-create, delete or re-sort children.
        // Edits to the start element should not change existing parts or end.
        return;
    }

    public function scDelete(DataContainer $dc): void
    {
        if (!$dc->activeRecord || $dc->activeRecord->type !== 'colsetStart' || !$dc->activeRecord->sc_childs) return;
        $childs = @unserialize($dc->activeRecord->sc_childs) ?: [];
        if (!$childs) return;
        Database::getInstance()->prepare('DELETE FROM tl_content WHERE id IN ('.implode(',', array_map('intval',$childs)).')')->execute();
    }

    /** Combine wrap id/class into a single multi-field UI */
    public function loadWrapAttrs($value, DataContainer $dc): array
    {
        $id = (string)($dc->activeRecord->sc_wrap_id ?? '');
        $cls = (string)($dc->activeRecord->sc_wrap_class ?? '');
        return [$id, $cls];
    }

    public function saveWrapAttrs($value, DataContainer $dc): string
    {
        $arr = is_array($value) ? $value : StringUtil::deserialize((string)$value, true);
        $id  = (string)($arr[0] ?? '');
        $cls = (string)($arr[1] ?? '');
        Database::getInstance()->prepare('UPDATE tl_content %s WHERE id=?')->set([
            'sc_wrap_id' => $id,
            'sc_wrap_class' => $cls,
        ])->execute($dc->id);
        // Return empty since this is a virtual field
        return '';
    }

    /**
     * Render the sc_wrap_id field wrapped in a tl_text_field div.
     */
    public function renderWrapIdInput(DataContainer $dc): string
    {
        $table = 'tl_content';
        $name  = 'sc_wrap_id';
        $value = '';
        if ($dc->activeRecord && property_exists($dc->activeRecord, $name)) {
            $value = (string) $dc->activeRecord->$name;
        }
        $arr = $GLOBALS['TL_DCA'][$table]['fields'][$name] ?? [];
        // Prevent recursion: do not include this callback when creating the widget
        if (isset($arr['input_field_callback'])) {
            unset($arr['input_field_callback']);
        }
        $attributes = CtlWidget::getAttributesFromDca($arr, $name, $value, $name, $table, $dc);
        $widget = new CtlTextField($attributes);
        return '<div class="tl_text_field">'.$widget->parse().'</div>';
    }
}
