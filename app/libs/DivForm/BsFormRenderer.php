<?php

namespace Libs\DivRenderer;

use Nette\Forms\Rendering\DefaultFormRenderer;

class BsFormRenderer extends DefaultFormRenderer
{
    /** @var \Nette\Forms\Form */
    protected $form;

    public $wrappers = array(
        'form' => array(
            'container' => NULL,
        ),

        'error' => array(
            'container' => 'ul class=error',
            'item' => 'li',
        ),

        'group' => array(
            'container' => 'fieldset',
            'label' => 'legend',
            'description' => 'p',
        ),

        'controls' => array(
            'container' => null,
        ),

        'pair' => array(
            'container' => 'div class="form-group"',
            '.required' => 'required',
            '.optional' => NULL,
            '.odd' => NULL,
            '.error' => 'has-error',
        ),

        'control' => array(
            'container' => NULL,
            '.odd' => NULL,

            'description' => 'small',
            'requiredsuffix' => '',
            'errorcontainer' => 'span class=error',
            'erroritem' => '',

            '.required' => 'required',
            '.text' => 'form-control',
            '.password' => 'text',
            '.file' => 'btn btn-default btn-file',
            '.submit' => 'btn btn-default',
            '.image' => 'imagebutton',
            '.button' => 'button',
        ),

        'label' => array(
            'container' => NULL,
            'suffix' => NULL,
            'requiredsuffix' => '',
        ),

        'hidden' => array(
            'container' => 'div',
        ),
    );


    public function render(\Nette\Forms\Form $form, $mode = NULL)
    {
        foreach ($form->getControls() as $control) {
            $control->getControlPrototype()->class[] = $control->name;
        }

        return parent::render($form, $mode);
    }



}
