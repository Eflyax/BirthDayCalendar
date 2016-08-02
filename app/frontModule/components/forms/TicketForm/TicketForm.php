<?php

namespace App\Forms;

use App\Model\Entity\Reservation;
use DateTime;
use Model\Reservations;
use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI;


class TicketForm extends UI\Control
{
	public $onSave = [];

	private $reservations;

	/**
	 * AssignEventForm constructor.
	 * @param Reservations $reservations
	 * @internal param array $on_save
	 */
	public function __construct(Reservations $reservations)
	{
		parent::__construct();
		$this->reservations = $reservations;
	}

	public function render()
	{
		$this->template->setFile(__DIR__ . "/TicketForm.latte");
		$this->template->render();
	}

	/**
	 * @return Form
	 */
	public function createComponentForm()
	{
		$form = new Form();

		$ticket_type = array(
			'90' => '90,-',
			'100' => '100,-',
			'60' => '60,-',
			'70' => '70,-',
			'180' => '180,-',
			'200' => '200,-',
			'135' => '135,-',
			'150' => '150,-',
		);

		$form->addRadioList('ticket_price', 'Vyberte typ lístku:', $ticket_type)
			->setRequired('Vyberte prosím typ lístku')
			->setDefaultValue('90');
			//->setAttribute('class', 'form-control');

		$form->addText('quantity', 'Počet lístků:')
			->setRequired('Zadejte počet lístků')
			->addRule(Form::INTEGER, 'Počet lístků musí být číslo')->setValue('1')->setAttribute('class', 'form-control quantity');

		$form->addText('name', 'Jméno:')
			->setRequired('Zadejte prosím své jméno')->setAttribute('class', 'form-control')->setAttribute('class', 'form-control');

		$form->addText('surname', 'Příjmení:')
			->setRequired('Zadejte prosím své příjmení')->setAttribute('class', 'form-control');

		$form->addText('email', 'E-mail:')
			->setRequired('Zadejte prosím váš email')->setAttribute('class', 'form-control');

		$form->addSubmit('send', 'Odeslat')
			->setAttribute('class', 'btn btn-lg btn-primary btn-block');;
		$form->onSuccess[] = $this->processForm;
		return $form;
	}

	public function processForm(Form $form, $values)
	{
		$reservation = new Reservation();
		$reservation->setName($values->name);
		$reservation->setSurname($values->surname);
		$reservation->setName($values->name);
		$reservation->setPrice($values->ticket_price);
		$reservation->setQuantity($values->quantity);
		$reservation->setEmail($values->email);
		$reservation->setDate(new DateTime());

		$this->reservations->save($reservation);

		$this->onSave($form, $values);
	}


}

interface ITicketFormFactory
{
	/** @return TicketForm */
	function create();
}