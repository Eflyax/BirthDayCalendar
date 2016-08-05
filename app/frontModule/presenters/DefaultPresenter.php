<?php

namespace FrontModule\Presenters;

use Entity\Patient;
use Libs\DentistLoader;
use Model\Patients;
use Nette;
use Nette\Utils\DateTime;


class DefaultPresenter extends FrontPresenter
{
    /** @var Patients @inject */
    public $patients;


    public function actionDefault($month = null)
    {
        if (!$month) {
            $month = date('m');
        }

        $this->template->month = $month;
        $this->template->patients = $this->patients->findByMonthAndDay($month, date('d'));
        $this->template->birthday_day = date('d');
        $this->template->birthday_month = $month;
        $this->template->birthday_year = date('Y');
        $this->template->page_header = "Kalendář";
    }

    public function actionCalendarMonth($id)
    {
        $current_year = date("Y");
        $patients = $this->patients->findByMonth($id);
//        $patients = $this->patients->findAll();

        $result = [];
        foreach ($patients as $patient) {
            $date_index = $patient->birth_date->format($current_year . '-m-d');
            if (isset($result[$date_index])) {
                $result[$date_index]['number']++;
            } else {
                $result[$date_index]['number'] = 1;
                $result[$date_index]['url'] = '/?do=showDay&month=' . $patient->birth_date->format('m') . '&day=' . $patient->birth_date->format('d');
            }
        }
        $wrapper['time'] = date('Y-' . sprintf('%02d', $id));
        $wrapper['events'] = $result;

        $this->sendJson($wrapper);
    }

    public function actionCalendarCurrent()
    {
        $current_month = date("m");
        $this->actionCalendarMonth($current_month);
    }

    public function actionLoadPatients($date)
    {
        $this->sendJson(null);
    }

    public function handleShowDay($month, $day)
    {
        $this->template->birthday_day = $day;
        $this->template->birthday_month = $month;
        $this->template->patients = $this->patients->findByMonthAndDay($month, $day);
        if ($this->isAjax()) {
            $this->redrawControl('showPatients');
        }
    }

    public function handleArchive($id_patient, $month, $day)
    {
        $data = ['archived' => 1];
        $this->patients->update($id_patient, $data);

    }


    public function handleEmployee($id_patient, $month, $day)
    {
        $patient = $this->patients->findOneBy(['id' => $id_patient]);
        $data = ['employee' => 1];
        if ($patient->employee) {
            $data = ['employee' => 0];
        }

        $this->patients->update($id_patient, $data);
        $this->handleShowDay($month, $day);
    }


    public function handleFavorite($id_patient, $month, $day)
    {
        $patient = $this->patients->findOneBy(['id' => $id_patient]);
        $data = ['favorite' => 1];
        if ($patient->favorite) {
            $data = ['favorite' => 0];
        }

        $this->patients->update($id_patient, $data);
        $this->handleShowDay($month, $day);
    }

}
