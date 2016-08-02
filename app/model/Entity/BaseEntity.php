<?php

namespace Entity;


use Kdyby\Doctrine\Entities\MagicAccessors;

abstract class BaseEntity
{
    use MagicAccessors;

    abstract function getId();
}