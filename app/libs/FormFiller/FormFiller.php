<?php

use Latte\Engine;

class FormFiller extends Nette\Forms\Controls\BaseControl
{

    private $inputs;
    private $form_name;

    public function __construct($inputs, $form_name = null)
    {
        parent::__construct();

        $this->inputs = $inputs;
        $this->form_name = $form_name;
    }

    public function getControl()
    {
        $template = new Engine;

        $data = [
            'inputs' => $this->inputs,
            'form_name' => $this->form_name,
            'class' => 'form_filler'
        ];
        return $template->renderToString(__DIR__ . '/formFiller.latte', $data);
    }

}