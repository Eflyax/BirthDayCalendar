<?php

namespace Libs\DivRenderer;

use Nette\Application\UI\Form;
use Nette\Forms\Rendering\DefaultFormRenderer;

class BsForm extends Form
{
    public function __construct()
    {
        parent::__construct();

        $this->setRenderer(new BsFormRenderer);
    }
}
