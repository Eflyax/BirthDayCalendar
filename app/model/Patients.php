<?php

namespace Model;

use Entity\Patient;
use Model\base\BaseService;
use Nette;
use Nette\Database\Context;

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
        $query = $this->db->query('SELECT * FROM ' . self::TABLE . ' WHERE MONTH(birth_date)=? AND DAY(birth_date)=? AND archived =?', $month, $day, 0);
        $result = $query->fetchAll();
        
        return $result;
    }

    public function save($array_hash)
    {
        $this->table->insert($array_hash);
    }

    public function findByMonth($month)
    {
        
        $query = $this->db->query('SELECT * FROM ' . self::TABLE . ' WHERE MONTH(birth_date)=? AND archived =?', $month, 0);
        $result = $query->fetchAll();

        return $result;
    }

    public function update($id, $data)
    {
        $this->table->where('id', $id)->update($data);
    }


}
