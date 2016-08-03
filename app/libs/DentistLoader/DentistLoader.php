<?php

namespace Libs;


use DateTime;
use Entity\Patient;
use Model\Patients;
use Nette\Utils\ArrayHash;
use PHPExcel;
use PHPExcel_IOFactory;

class DentistLoader
{
    const PATIENT_PERSON_ID = 'Rodné číslo';

    const PATIENT_PERSON_FULLNAME = 'Příjmení Jméno';

    /** @var PHPExcel @inject */
    public $PHP_Excel;

    private $actual_sheet;

    private $highest_column;

    private $highest_row;

    private $patient_index_person_id;

    private $patient_index_name_surname;

    /** @var  Patients */
    private $patients;

    public function __construct($filename, Patients $patients)
    {
        $this->PHP_Excel = PHPExcel_IOFactory::load($filename);
        $this->initHeader();
        $this->patients = $patients;
    }

    private function initHeader()
    {
        $this->actual_sheet = $this->PHP_Excel->getSheet(0);
        $this->highest_column = ord($this->actual_sheet->getHighestColumn()) - 64;
        $this->highest_row = $this->actual_sheet->getHighestRow();

        $header = $this->getExcelRowToArray(1);

        $index = 0;
        foreach ($header as $header_cell) {

            if ($header_cell == self::PATIENT_PERSON_FULLNAME) {
                $this->patient_index_name_surname = $index;
            }

            if ($header_cell == self::PATIENT_PERSON_ID) {
                $this->patient_index_person_id = $index;
            }

            $index++;
        }
    }

    public function importPatients()
    {
        $row = 2;
        $person_id = $this->readPatientId($row);
        While ($person_id) {
            $person_id = $this->readPatientId($row);
            $patient = new ArrayHash();
            $name_array = explode(' ', $this->readPatientFullName($row));
            $patient->name = $name_array[count($name_array) - 1];
            $patient->surname = "";
            for ($i = 0; $i < count($name_array) - 1; $i++) {
                $patient->surname .= $name_array[$i] . ' ';
            }
            $patient->person_id = $person_id;
            $patient->birth_date = $this->personIdToDate($person_id);

            if ($person_id == null) {
                continue;
            }

            $this->patients->save($patient);

            $row++;
        }
    }

    private function personIdToDate($patient_id)
    {
        $year = substr($patient_id, 0, 2) + 1900;
        $month = substr($patient_id, 2, 2);
        if ($month >= 13) {
            $month -= 50;
        }
        $day = substr($patient_id, 4, 2);

        $date = new DateTime();
        $date->setDate($year * 1, $month * 1, $day * 1);
        return $date;

    }

    private function readPatientId($row)
    {
        return $this->actual_sheet->getCellByColumnAndRow($this->patient_index_person_id, $row)->getValue();
    }

    private function readPatientFullName($row)
    {
        return $this->actual_sheet->getCellByColumnAndRow($this->patient_index_name_surname, $row)->getValue();
    }

    /**
     * @param $row Number of row in excel document
     * @return array Array of cells in excel row
     */
    private function getExcelRowToArray($row)
    {
        $array_row = [];
        for ($column = 0; $column < $this->highest_row; $column++) {
            $cell = $this->actual_sheet->getCellByColumnAndRow($column, $row);
            $array_row[$column] = $cell->getValue();
        }

        return $array_row;
    }

    /**
     * @return mixed
     */
    public function getActualSheet()
    {
        return $this->actual_sheet;
    }

    /**
     * @return mixed
     */
    public function getHighestColumn()
    {
        return $this->highest_column;
    }

    /**
     * @return mixed
     */
    public function getHighestRow()
    {
        return $this->highest_row;
    }

    /**
     * @return mixed
     */
    public function getPatientIndexPersonId()
    {
        return $this->patient_index_person_id;
    }

    /**
     * @return mixed
     */
    public function getPatientIndexNameSurname()
    {
        return $this->patient_index_name_surname;
    }


}