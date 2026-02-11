<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
    'expense_name',
    'expencate_id',
    'expense_amount',
    'expense_note',
    'expense_date',
    'expense_creator',
    'expense_editor',
    'expense_slug',
];

    protected $table = 'expenses';
    protected $primaryKey = 'expense_id';

    public function CategoryInfo(){
        return $this->belongsTo('App\Models\ExpenseCategory', 'expencate_id', 'expencate_id');
    }

    public function creatorUser () {
        return $this->belongsTo('App\Models\User', 'expense_creator', 'id');
    }

    public function editorUser () {
        return $this->belongsTo('App\Models\User', 'expense_editor', 'id');
    }
}
