<?php

namespace Model;

use Entity\Patient;
use Model\base\BaseService;
use Nette;
use Nette\Database\Context;
use Nette\Utils\ArrayHash;

class Patients
{

    const TABLE = 'patient';

    /**
     * @var \Nette\Database\Context
     */
    private $db;

    private $table;

    /**
     * @param Context $db
     */
    public function __construct(Context $db)
    {
        $this->db = $db;
        $this->table = $db->table(self::TABLE);
    }

    public function findAll()
    {
        $query = $this->table->select('*');

        return $query->fetchAll();
    }

    public function findByMonthAndDay($month, $day)
    {
        $query = $this->db->query('SELECT * FROM ' . self::TABLE . ' WHERE MONTH(birth_date)=? AND DAY(birth_date)=? AND archived =? ORDER BY  employee DESC, favorite DESC', $month, $day, 0);
        $patients = $query->fetchAll();

        $result = [];
        foreach ($patients as $patient) {
            $patient->birth_day = (date('Y') - $patient->birth_date->format('Y'));
            $result[] = $patient;
        }

        return $result;
    }

    public function save($array_hash)
    {
        $this->table->insert($array_hash);
    }

    public function findByMonth($month)
    {
        $query = $this->db->query('SELECT * FROM ' . self::TABLE . ' WHERE MONTH(birth_date)=? AND archived =?', $month, 0);
        $patients = $query->fetchAll();

        return $patients;
    }

    public function update($id, $data)
    {
        $this->table->where('id', $id)->update($data);
    }

    public function findArchived()
    {
        $result = $this->table->select('*')->where('archived', 1);
        return $result;
    }

    public function findBySearch($search)
    {
        if (is_numeric($search)) {
            $query = $this->db->query('SELECT * FROM ' . self::TABLE . ' WHERE person_id=? ', $search);
        } else {
            $name_array = explode(' ', $search);
            if (count($name_array) <= 1) {
                $query = $this->db->query('SELECT * FROM ' . self::TABLE . ' WHERE name LIKE ?', '%' . $search . '%', ' OR surname LIKE ?', '%' . $search . '%');
            } else {
                $query = $this->db->query('SELECT * FROM ' . self::TABLE . ' WHERE name LIKE ?', '%' . $name_array[0] . '%', ' AND surname LIKE ?', '%' . $name_array[1] . '%');
            }
        }
        $patients = $query->fetchAll();

        return $patients;
    }

    public function findLimit($limit)
    {
        $query = $this->table->select('*')->limit($limit);

        return $query->fetchAll();
    }

    public function findBy(array $criteria)
    {
        $query = $this->table->select('*');
        foreach ($criteria as $key => $value) {
            $query->where($key, $value);
        }

        return $query->fetchAll();

    }

    public function findOneBy(array $criteria)
    {
        $query = $this->table->select('*');
        foreach ($criteria as $key => $value) {
            $query->where($key, $value);
        }

        return ArrayHash::from($query->fetch()->toArray());
    }

}
