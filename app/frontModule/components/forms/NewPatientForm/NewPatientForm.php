<?php

namespace App\Forms;

use DateTime;
use Model\Patients;
use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI;


class NewPatientForm extends UI\Control
{
    public $onSave = [];

    private $patients;


    public function __construct(Patients $patients)
    {
        parent::__construct();
        $this->patients = $patients;
    }

    public function render()
    {
        $this->template->setFile(__DIR__ . "/NewPatientForm.latte");
        $this->template->render();
    }

    /**
     * @return Form
     */
    public function createComponentForm()
    {
        $form = new Form();


        $form->addText('name', 'Jméno:')
            ->setRequired('Zadejte prosím své jméno')
            ->setAttribute('class', 'form-control');

        $form->addText('surname', 'Příjmení:')
            ->setRequired('Zadejte prosím své příjmení')
            ->setAttribute('class', 'form-control');
       
       
        $form->addText('person_id', 'Rodné číslo:')
//            ->addRule($form::INTEGER, 'Rodné číslo musí být číslo')
            ->setRequired('Zadejte prosím datum narození pacienta')
            ->setAttribute('class', 'form-control');


        $form->addSubmit('send', 'Odeslat')
            ->setAttribute('class', 'btn btn-lg btn-primary btn-block');;
        $form->onSuccess[] = $this->processForm;
        return $form;
    }

    public function processForm(Form $form, $values)
    {
        $this->onSave($form, $values);
    }


}

interface INewPatientFormFactory
{
    /** @return NewPatientForm */
    function create();
}