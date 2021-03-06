<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Dynamic Ptable Backport extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoDynamicPtableBackport\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use InspiredMinds\ContaoDynamicPtableBackport\ContaoDynamicPtableBackportBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ContaoDynamicPtableBackportBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
