<?php

namespace FrontModule\Presenters;

use App\Model;
use FrontModule\Presenters\FrontPresenter;
use Nette;


class AboutPresenter extends FrontPresenter
{

	public function startup()
	{
		parent::startup();
		$this->template->title = "O nás";
	}

	public function actionDefault()
	{

	}
}
