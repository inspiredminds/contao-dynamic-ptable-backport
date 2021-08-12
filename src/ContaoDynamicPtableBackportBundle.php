<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Dynamic Ptable Backport extension.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoDynamicPtableBackport;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContaoDynamicPtableBackportBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
