<?php

namespace FrontModule\Presenters;

use Libs\DentistLoader;
use Model\Patients;
use Nette;


class UserPresenter extends FrontPresenter
{

    /** @var Patients @inject */
    public $patients;


    public function renderDefault($search = null)
    {

        if ($search) {
            $patients = $this->patients->findBySearch($search);
        } else {
            $patients = $this->patients->findLimit(25);

        }

        $this->template->search = $search;
        $this->template->page_header = "Správa uživatelů";
        //$path = __DIR__ . '/../../../www/files/pacienti_min.ods';
        //  $dentist = new DentistLoader($path);
        //   $dentist->importPatients($this->patients);
        
        $this->template->patients = $patients;//$this->patients->findArchived();

    }

    public function handleUnArchive($id)
    {
        $data = ['archived' => 0];
        $this->patients->update($id, $data);
    }


}
