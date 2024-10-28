<?php
namespace Odb\TabulatorUxBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;

class TabulatorUxBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}