<?php

namespace Model;

use Entity\Day;
use Entity\Patient;
use Kdyby;
use Kdyby\Doctrine\EntityManager;
use Model\base\BaseService;
use Nette;

class Patients extends BaseService
{

	public function __construct(EntityManager $em)
	{
        parent::__construct($em, $em->getRepository(Patient::class));
	}
	
}
