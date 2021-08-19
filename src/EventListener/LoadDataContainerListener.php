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

use Composer\Semver\Semver;
use Contao\Controller;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Input;
use Jean85\Exception\ReplacedPackageException;
use Jean85\PrettyVersions;

/**
 * @Hook("loadDataContainer")
 */
class LoadDataContainerListener
{
    public function __invoke(string $currentTable): void
    {
        if (!$this->isNeeded()) {
            return;
        }

        // Fix for https://github.com/contao/contao/pull/3311
        if (empty($GLOBALS['TL_DCA'][$currentTable]['config']['ptable'])) {
            unset($GLOBALS['TL_DCA'][$currentTable]['config']['ptable']);
        }

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

    private function isNeeded(): bool
    {
        try {
            $version = PrettyVersions::getVersion('contao/core-bundle');

            if ('' === $version->getShortVersion()) {
                $version = PrettyVersions::getVersion('contao/contao');
            }
        } catch (ReplacedPackageException $e) {
            $version = PrettyVersions::getVersion('contao/contao');
        } catch (\OutOfBoundsException $e) {
			$version = PrettyVersions::getVersion('contao/contao');
		}

        return Semver::satisfies($version->getShortVersion(), '4.9.*');
    }
}
