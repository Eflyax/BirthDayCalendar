<?php
namespace Libs;

use Entity\User;
use Nette\Application\LinkGenerator;
use Nette\Object;
use Nette\Utils\ArrayHash;
use Nette\Utils\Strings;

class ProjectInitializer extends Object
{



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
//		$this->addContent('faq', 'FAQ', 'faq text');
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