<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'expencate_id';

    function creatorUser() {
        return $this->belongsTo('App\Models\User', 'expencate_creator','id');
    }

    function editorUser (){
        return $this->belongsTo('App\Models\User', 'expencate_editor', 'id');
    }
}
