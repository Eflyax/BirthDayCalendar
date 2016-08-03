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

    public function actionDefault()
    {
//        $path = __DIR__ . '/../../../www/files/pacienti_min.ods';
//        $dentist = new DentistLoader($path, $this->patients);
//        $dentist->importPatients();
    }

    public function actionCalendarMonth($id)
    {
        $current_year = date("Y");
//        $patients = $this->patients->findByMonth($id);
        $patients = $this->patients->findAll();

        $result = [];
        foreach ($patients as $patient) {
            $date_index = $patient->birth_date->format($current_year . '-m-d');
            if (isset($result[$date_index])) {
                $result[$date_index]['number']++;
            } else {
                $result[$date_index]['number'] = 1;
                $result[$date_index]['url'] = '/loadPatients?date=' . $patient->birth_date->format('m-d');
            }
        }
        $wrapper['time'] = date('Y-'.sprintf('%02d', $id));
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

}
