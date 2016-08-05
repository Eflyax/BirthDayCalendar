<?php

namespace FrontModule\Presenters;

use App\Forms\INewPatientFormFactory;
use Libs\DentistLoader;
use Model\Patients;
use Nette;
use Nette\Application\UI\Form;


class UserPresenter extends FrontPresenter
{

    /** @var Patients @inject */
    public $patients;

    const DEFAULT_LIMIT = 25;

    /** @var  INewPatientFormFactory @inject */
    public $new_patient_form_factory;


    public function renderDefault($search = null, $filter = null)
    {
        if ($filter) {
            switch ($filter) {
                case 'employee':
                    $this->template->filter = $filter;
                    $patients = $this->patients->findBy([$filter => 1]);
                    break;
                case 'favorite':
                    $this->template->filter = $filter;
                    $patients = $this->patients->findBy([$filter => 1]);
                    break;
                case 'archived':
                    $this->template->filter = $filter;
                    $patients = $this->patients->findBy([$filter => 1]);
                    break;
            }
        } else {
            if ($search) {
                $patients = $this->patients->findBySearch($search);
            } else {
                $patients = $this->patients->findLimit(self::DEFAULT_LIMIT);

            }
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


    public function handleArchive($id_patient)
    {
        $data = ['archived' => 1];
        $this->patients->update($id_patient, $data);

    }


    public function handleEmployee($id_patient)
    {
        $patient = $this->patients->findOneBy(['id' => $id_patient]);
        $data = ['employee' => 1];
        if ($patient->employee) {
            $data = ['employee' => 0];
        }

        $this->patients->update($id_patient, $data);
    }


    public function handleFavorite($id_patient)
    {
        $patient = $this->patients->findOneBy(['id' => $id_patient]);
        $data = ['favorite' => 1];
        if ($patient->favorite) {
            $data = ['favorite' => 0];
        }

        $this->patients->update($id_patient, $data);
    }

    protected function createComponentNewPatientForm()
    {
        $form = new Form();

        $form = $this->new_patient_form_factory->create();

        $form->onSave[] = function (Form $form, Nette\Utils\ArrayHash $patient) {



            $dentist_loader = new DentistLoader(null, $this->patients);

            try {
                $patient->birth_date = $dentist_loader->personIdToDate($patient->person_id);
            } catch (\Exception $e) {
                $this->flashMessage("Osobní číslo se nepodařilo převést na datum narození", 'danger');
            }


            if (isset($patient->birth_date)) {
                try {
                    $this->patients->save($patient);
                    $this->flashMessage("Pacient byl úspěšně přidán do systému", 'success');
                } catch (\Exception $e) {
                    $this->flashMessage('Chyba při ukládání pacienta. Toto rodné číslo již zřejmě v databázi existuje.', 'danger');
                }
            }

            $this->redirect('this');
        };

        return $form;
    }

}
