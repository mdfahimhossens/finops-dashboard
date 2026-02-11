<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
    'income_name','incate_id','income_office','income_age','income_salary',
    'income_date','income_creator','income_slug'
    ];
    use HasFactory;

    protected $table = 'incomes';
    protected $primaryKey = 'income_id';

    public function CategoryInfo(){
        return $this->belongsTo('App\Models\IncomeCategory', 'incate_id', 'incate_id');
    }

    function CreatorUser(){
        return $this->belongsTo('App\Models\User', 'income_creator', 'id');
    }

    function EditorInfo(){
        return $this->belongsTo('App\Models\User', 'income_editor', 'id');
    }

}
