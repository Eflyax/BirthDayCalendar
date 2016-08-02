<?php

namespace Model;

use Entity\User;
use Kdyby;
use Kdyby\Doctrine\EntityManager;
use Model\base\BaseService;
use Nette;

class Users extends BaseService
{

	public function __construct(EntityManager $em)
	{
        parent::__construct($em, $em->getRepository(User::class));
	}

	/**
	 * @return array
	 */
	public function getFullNames(){
		$users = [];
		foreach($this->findAll() as $users){
			$users[$user->getId()] = $user->getFullName();
		}

		return $users;
	}

	public function getFullName($id){
		$user = $this->find($id);
		if(!$user){
			return NULL;
		}

		return $user->getFullName();
	}

}
