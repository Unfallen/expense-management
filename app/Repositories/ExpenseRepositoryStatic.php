<?php

namespace App\Repositories;

use App\Models\Expense;
use App\Repositories\ExpenseRepositoryInterface;

class ExpenseRepositoryStatic implements ExpenseRepositoryInterface
{

    protected $_model;

    public function __construct()
    {
        $expense = collect([
            [
                'name' => 'Ball',
                'description' => 'Spalding Basketball',
                'price' => rand(1000000, 100000000),
                'category_id' => 5,
                'photo' => null,
                'created_at' => '',
            ],
            [
                'name' => 'Sofa Set',
                'description' => 'Modern Sala Set',
                'price' => rand(1000000, 100000000),
                'category_id' => 3,
                'photo' => null,
                'created_at' => '',
            ],
            [
                'name' => 'Refuel',
                'description' => 'Shell V-Power Gasoline',
                'price' => rand(1000000, 100000000),
                'category_id' => 1,
                'photo' => null,
                'created_at' => '',

            ]
        ]);
        $this->_model = $expense;
    }

    /**
     * Get All
     * @return array
     */
    public function get()
    {
        return $this->_model->all();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);

        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {

        return $this->_model->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    /**
     * Pagination
     * @param $perPage
     * @return mixed
     */
    public function paginate($perPage)
    {
        return $this->_model->paginate($perPage);
    }

    /**
     * Latest
     * @return mixed
     */
    public function latest()
    {
        return $this->_model->sortBy('created_at');
    }
}
