<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\IncomeCategoryController;
use Carbon\Carbon;
use Auth;
use Session;
use DB;

class RecycleController extends Controller
{
    public function index() {
        return view('admin.recycle.recycle');
    }

    public function user() {

    }

    public function income() {
        return view ('admin.recycle.income-main');
    }
    public function expense () {
        return view ('admin.recycle.expense-main');
    }
    public function income_category(){
        return view ('admin.recycle.income-category');
    }

    public function expense_category() {
        return view ('admin.recycle.expense-category');
    }
}
