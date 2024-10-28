<?php

namespace Odb\TabulatorUxBundle\Builder;

use Odb\TabulatorUxBundle\Model\Tabulator;

interface TabulatorBuilderInterface
{
    public function createTabulator(): Tabulator;
}