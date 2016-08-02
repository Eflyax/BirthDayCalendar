<?php

namespace FrontModule\Presenters;

use App\Forms\SignFormFactory;
use FrontModule\Presenters\FrontPresenter;
use Nette;


class SignPresenter extends FrontPresenter
{
	/** @var SignFormFactory @inject */
	public $factory;


	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		$form = $this->factory->create();
		$form->onSuccess[] = function ($form) {
			$form->redirect('Homepage:');
		};
		return $form;
	}	


	public function actionOut()
	{
		$this->getUser()->logout();
	}

}
