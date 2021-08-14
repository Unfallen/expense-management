<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    /**
     * Gets the expenses of the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    /**
     * Get the sum of expenses prices of the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenseSum()
    {
        return $this->hasMany(Expense::class)->selectRaw('expenses.category_id,SUM(expenses.price) as total')->groupBy('expenses.category_id');
    }
}
