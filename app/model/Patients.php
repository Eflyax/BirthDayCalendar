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

    public function findByMonth($month)
    {
        $query = $this->db->query('SELECT * FROM '.self::TABLE.' WHERE MONTH(birth_date)=?', $month);

        return $query->fetchAll();
    }

    public function save($array_hash)
    {
        $this->table->insert($array_hash);
    }


}
