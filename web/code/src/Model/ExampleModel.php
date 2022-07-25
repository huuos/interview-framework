<?php

declare(strict_types = 1);

namespace Example\Model;

use Mini\Model\Model;

/**
 * Example data.
 */
class Example
{
    public function __construct(int $id, string $created, string $code, string $description) {
        $this->id = $id;
        $this->created = $created;
        $this->code = $code;
        $this->description = $description;
    }
}

class ExampleModel extends Model
{

        /**
     * Get example data by ID.
     *
     * @param int $id example id
     *  
     * @return array example data
     */

    public function get(int $id): Example
    {   
        $sql = '
            SELECT
                example_id AS "id",
                created,
                code,
                description
            FROM
            ' . getenv('DB_SCHEMA') . '.master_example
            WHERE
                example_id = ?';
        
        $query = $this->db->select([
            'title'  => 'Get example data',
            'sql'    => $sql,
            'inputs' => [$id]
        ]);

        $example = new Example($query['id'], $query['created'], $query['code'], $query['description']);
        return $example;
    }

    public function set(int $id, string $created, string $code, string $description, Example $example): Example
    {

        $sql = '
            UPDATE 
            ' . getenv('DB_SCHEMA') . '.master_example
            SET 
                code = ?, 
                description = ? 
            WHERE 
                example_id = ?' ;
        
        $query = $this->db->statement([
            'title' => 'Update data',
            'sql' => $sql,
            'inputs' => [
                $code, $description, $id
            ]
        ]);

        $example->code = $code;
        $example->description = $description;

        return $example;
    }

    /**
     * Create an example.
     *
     * @param string $created     example created on
     * @param string $code        example code
     * @param string $description example description
     *  
     * @return int example id
     */
    public function create(string $created, string $code, string $description): int
    {

        $example = new Example(0, $created, $code, $description);

        $sql = '
            INSERT INTO
                ' . getenv('DB_SCHEMA') . '.master_example
            (
                created,
                code,
                description
            )
            VALUES
            (?,?,?)';

        $id = $this->db->statement([
            'title'  => 'Create example',
            'sql'    => $sql,
            'inputs' => [
                $example->created,
                $example->code,
                $example->description
            ]
        ]);

        

        $this->db->validateAffected();
        $example->id = $id;
        return $id;
    }

}


