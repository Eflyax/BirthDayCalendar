<?php
namespace Libs;

use Entity\AttendantDepartment;
use Entity\Content;
use Entity\EmailTemplate;
use Entity\Gallery;
use Entity\Hotel;
use Entity\Language;
use Entity\Lector;
use Entity\LectorDepartment;
use Entity\User;
use Kdyby\Doctrine\EntityManager;
use Libs\TranslationParser\TranslationParser;
use Model\Galleries;
use Model\Translations;
use Nette\Application\LinkGenerator;
use Nette\Object;
use Nette\Utils\ArrayHash;
use Nette\Utils\Strings;

class ProjectInitializer extends Object
{
	/** @var EntityManager @inject */
	public $em;
	/** @var \Model\Users @inject */
	public $users;

	public function initialize()
	{
		$this->addUsers();
	}


	private function addUsers()
	{
		$this->addUser('eflyax42@gmail.com', 'password');
	}

	private function addContents()
	{
		$this->addContent('faq', 'FAQ', 'faq text');
	}

	///////////// Single addings
	/**
	 * @param $email
	 * @param $password
	 */
	public function addUser($email, $password)
	{
		$user = $this->users->findBy(['email' => $email]);

		if ($user) {
			echo 'duplication of EMAIL ' . $email . ', pick another;<br>';
		} else {
			$user = new User;
			$user->email = $email;
			$user->password = $password;
			$user->role = 'admin';

			$this->users->save($user);
			echo 'USERNAME ' . $email . ' added;<br>';
		}
	}

}