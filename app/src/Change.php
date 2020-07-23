<?php
declare(strict_types=1);
namespace OliverHader\PhpProxies;

class Change
{
    public $oldValue;
    public $newValue;

    public function __construct($oldValue, $newValue)
    {
        $this->oldValue = $oldValue;
        $this->newValue = $newValue;
    }
}
