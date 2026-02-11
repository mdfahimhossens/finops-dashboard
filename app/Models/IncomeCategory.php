<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'incate_id';

    function CreatorUser(){
        return $this->belongsTo('App\Models\User', 'incate_creator', 'id');
    }

    function EditorInfo(){
        return $this->belongsTo('App\Models\User', 'incate_editor', 'id');
    }
}
