<?php

namespace Amranidev\ScaffoldInterface;

use Illuminate\Support\Facades\DB;

/**
 * class Attribute
 *
 * @author Amrani Houssain <amranidev@gmail.com>
 *
 * @todo Test
 */
class Attribute
{

    /**
     * table name
     *
     * @var $table String
     */
    private $table;

    /**
     * Result
     *
     * @var $Result[]
     */
    private $result = [];

    /**
     * create new Attrebutes
     *
     * @param $table
     */
    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * Get attributes from table
     *
     * @return mixed
     */
    public function getAttributes()
    {
        //if PostgreSql
        if (env('DB_CONNECTION') == 'pgsql') {
            $this->result = DB::select(DB::raw("SELECT column_name FROM information_schema.columns WHERE table_name ='" . $this->table . "';"));
        
        //if Mysql
        } elseif (env('DB_CONNECTION') == 'mysql') {
            $this->result = DB::select(DB::raw("SELECT column_name FROM information_schema.columns WHERE table_schema ='" . env('DB_DATABASE') . "' and table_name ='" . $this->table . "';"));
        }
        
        //delete the first element.(ignore the id section)
        unset($this->result[0]);

        //get result
        return $this->result;
    }
}
