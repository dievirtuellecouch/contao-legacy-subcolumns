<?php

namespace Websailing\SubcolumnsBundle\Dca;

use Contao\DataContainer;
use Contao\Database;
use Contao\StringUtil;
use Contao\Input;
use Contao\System;

class TlFormFieldSubcolumns
{
    /**
     * Return a set of common column splits similar to legacy TL_SUBCL
     */
    public function getAllTypes(): array
    {
        return [
            '50x50', '33x33x33', '25x25x25x25', '66x33', '33x66', '75x25', '25x75', '70x30', '30x70',
            '40x60', '60x40', '20x40x40', '40x20x40', '40x40x20',
        ];
    }

    /**
     * After first submit of a newly created formcolstart, create the parts and end.
     * Uses the new_records session bag to detect first submit after creation.
     */
    public function onFirstSubmit(DataContainer $dc): void
    {
        if (!$dc->activeRecord || $dc->activeRecord->type !== 'formcolstart') { return; }
        // Only on first submit after creation
        $bag = System::getContainer()->get('request_stack')->getSession()->getBag('contao_backend');
        $newRecords = (array) ($bag->get('new_records') ?? []);
        if (empty($newRecords['tl_form_field']) || !\in_array((int)$dc->id, array_map('intval', $newRecords['tl_form_field']), true)) {
            return;
        }
        $db = Database::getInstance();
        $obj = $db->prepare('SELECT * FROM tl_form_field WHERE id=?')->limit(1)->execute($dc->id);
        if (!$obj->numRows) { return; }
        $type = (string) $obj->fsc_type;
        if ($type === '') { return; }
        $pid = (int) $obj->pid;
        $sortingStart = (int) $obj->sorting;
        $name = (string) ($obj->fsc_name ?: ('colset.'.$dc->id));
        $gapuse = (string) $obj->fsc_gapuse;
        $gap = (string) $obj->fsc_gap;

        // Determine column count from type like "33x33x33"
        $cols = array_filter(array_map('trim', explode('x', $type)), 'strlen');
        $colCount = max(2, count($cols));

        // Existing children
        $childs = [];
        if ($obj->fsc_childs) {
            $tmp = @unserialize($obj->fsc_childs) ?: [];
            if (is_array($tmp)) { $childs = array_map('intval', $tmp); }
        }

        // Helper to move following rows (keep order)
        $moveRows = function(int $amount) use ($db, $pid, $sortingStart) {
            $db->prepare('UPDATE tl_form_field SET sorting = sorting + ? WHERE pid=? AND sorting > ?')
               ->execute($amount, $pid, $sortingStart);
        };

        // Create all if empty (only on initial creation)
        if (!$childs) {
            // space for parts+end
            $moveRows(64 * ($colCount));
            // Insert parts
            for ($i = 1; $i <= $colCount - 1; $i++) {
                $set = [
                    'pid' => $pid,
                    'tstamp' => time(),
                    'sorting' => $sortingStart + ($i+1)*64,
                    'type' => 'formcolpart',
                    'label' => '',
                    'fsc_name' => $name.'-Part-'.$i,
                    'fsc_type' => $type,
                    'fsc_parent' => $dc->id,
                    'fsc_sortid' => $i,
                    'fsc_gapuse' => $gapuse,
                    'fsc_gap' => $gap,
                ];
                $insertId = $db->prepare('INSERT INTO tl_form_field %s')->set($set)->execute()->insertId;
                $childs[] = (int) $insertId;
            }
            // Insert end
            $set = [
                'pid' => $pid,
                'tstamp' => time(),
                'sorting' => $sortingStart + ($colCount+1)*64,
                'type' => 'formcolend',
                'label' => '',
                'fsc_name' => $name.'-End',
                'fsc_type' => $type,
                'fsc_parent' => $dc->id,
                'fsc_sortid' => $colCount,
                'fsc_gapuse' => $gapuse,
                'fsc_gap' => $gap,
            ];
            $endId = $db->prepare('INSERT INTO tl_form_field %s')->set($set)->execute()->insertId;
            $childs[] = (int) $endId;

            // Save children list
            $db->prepare('UPDATE tl_form_field %s WHERE id=?')
               ->set(['fsc_childs' => serialize($childs), 'fsc_name' => $name])
               ->execute($dc->id);
            // Remove id from new_records to prevent re-triggering
            $newRecords['tl_form_field'] = array_values(array_filter($newRecords['tl_form_field'], static fn($v) => (int)$v !== (int)$dc->id));
            $bag->set('new_records', $newRecords);
            return;
        }
        // Do NOT auto-create, delete or re-sort children after initial creation.
        // Changes to the start element must not modify existing parts or end.
        return;
    }

    public function onDelete(DataContainer $dc): void
    {
        if (!$dc->activeRecord || $dc->activeRecord->type !== 'formcolstart' || !$dc->activeRecord->fsc_childs) return;
        $childs = @unserialize($dc->activeRecord->fsc_childs) ?: [];
        if (!$childs) return;
        Database::getInstance()->prepare('DELETE FROM tl_form_field WHERE id IN ('.implode(',', array_map('intval',$childs)).')')->execute();
    }

    /** Combine wrap id/class into a single multi-field UI */
    public function loadWrapAttrs($value, DataContainer $dc): array
    {
        $id = (string)($dc->activeRecord->fsc_wrap_id ?? '');
        $cls = (string)($dc->activeRecord->fsc_wrap_class ?? '');
        return [$id, $cls];
    }

    public function saveWrapAttrs($value, DataContainer $dc): string
    {
        $arr = is_array($value) ? $value : StringUtil::deserialize((string)$value, true);
        $id  = (string)($arr[0] ?? '');
        $cls = (string)($arr[1] ?? '');
        Database::getInstance()->prepare('UPDATE tl_form_field %s WHERE id=?')->set([
            'fsc_wrap_id' => $id,
            'fsc_wrap_class' => $cls,
        ])->execute($dc->id);
        return '';
    }
}
