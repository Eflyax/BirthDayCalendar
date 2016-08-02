<?php

namespace FrontModule\Presenters;

use Libs\DentistLoader;
use Model\Patients;
use Nette;


class DefaultPresenter extends FrontPresenter
{

    /** @var Patients @inject */
    public $patients;

    public function actionDefault()
    {

        //$path = __DIR__ . '/../../../www/files/pacienti_min.ods';
      //  $dentist = new DentistLoader($path);
     //   $dentist->importPatients($this->patients);




    }

}
