<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Dynamic Ptable Backport extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoDynamicPtableBackport\EventListener;

use Contao\Controller;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Input;

/**
 * @Hook("loadDataContainer")
 */
class LoadDataContainerListener
{
    public function __invoke(string $currentTable): void
    {
        if (!($GLOBALS['TL_DCA'][$currentTable]['config']['dynamicPtable'] ?? false) || !empty($GLOBALS['TL_DCA'][$currentTable]['config']['ptable']) || !isset($GLOBALS['BE_MOD'])) {
            return;
        }

        if (!$do = Input::get('do')) {
            return;
        }

        foreach (array_merge(...array_values($GLOBALS['BE_MOD'])) as $key => $module) {
            if ($do !== $key || !isset($module['tables']) || !\is_array($module['tables'])) {
                continue;
            }

            foreach ($module['tables'] as $table) {
                Controller::loadDataContainer($table);
                $ctable = $GLOBALS['TL_DCA'][$table]['config']['ctable'] ?? [];

                if (\in_array($currentTable, $ctable, true)) {
                    $GLOBALS['TL_DCA'][$currentTable]['config']['ptable'] = $table;

                    return;
                }
            }
        }
    }
}
