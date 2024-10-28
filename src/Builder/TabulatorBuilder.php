<?php

namespace Odb\TabulatorUxBundle\Builder;

use Odb\TabulatorUxBundle\Model\Tabulator;

class TabulatorBuilder implements TabulatorBuilderInterface
{
    public function createTabulator(): Tabulator
    {
        return new Tabulator();
    }

}