<?php

namespace FrontModule\Presenters;

use Libs\DentistLoader;
use Model\Patients;
use Nette;


class ImportPresenter extends FrontPresenter
{

    /** @var Patients @inject */
    public $patients;

    public function actionDefault()
    {
        $this->template->page_header = "Import";
//        $path = __DIR__ . '/../../../www/files/pacienti.xlsx';
//        $dentist = new DentistLoader($path, $this->patients);
//        $import_result = $dentist->importPatients();
        $this->template->duplicity = 5;//$import_result['duplicity'];
        $this->template->imported = 6;//$import_result['imported'];
    }

}
