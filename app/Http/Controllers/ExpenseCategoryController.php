<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ExpenseCategory;
use Carbon\Carbon;
use Auth;
use Session;
use DB;

class ExpenseCategoryController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $allData = DB::table('expense_categories')->where('expencate_status', 1)->orderBy('expencate_id', 'DESC')->get();
       return view('admin.expense.category.all', compact('allData'));
    }

    public function add()
    {
       return view('admin.expense.category.add');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:25|unique:expense_categories,expencate_name',
            'remarks'=>'required|max:500'   
        ], [

        ]);

        $slug = Str::slug($request['name'], '-');
        $creator = Auth::user()->id;
        ExpenseCategory::insert([
            'expencate_name' => $request['name'],
            'expencate_remarks' => $request['remarks'],
            'expencate_creator' => $creator,
            'expencate_slug' => $slug,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);

        return to_route('dashboard.expense.category.index')->with('success', 'Expense Category Successfully Inserted');
    }


    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
      $data = ExpenseCategory::where('expencate_status', 1)->where('expencate_slug', $slug)->firstOrFail();
      return view('admin.expense.category.view', compact('data'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
       $data = ExpenseCategory::where('expencate_status', 1)->where('expencate_slug', $slug)->firstOrFail();
       return view('admin.expense.category.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required|max:25|unique:expense_categories,expencate_name,'.$request->id.',expencate_id',
            'remarks'=>'required|max:500' 
        ]);

        $slug = Str::slug($request->name);
        $editor = Auth::id();
        ExpenseCategory::where('expencate_id', $request->id)->update([
            'expencate_name' => $request->name,
            'expencate_remarks' => $request->remarks,
            'expencate_editor' => $editor,
            'expencate_slug' => $slug,
            'updated_at' => Carbon::now(),
        ]);

    return to_route(
    'dashboard.expense.category.show',
    $slug
    )->with('success', 'Expense Category Updated Successfully');
    }

    public function permanentDelete($id)
    {
    ExpenseCategory::where('expencate_id', $id)->delete();

    return redirect()->back()->with('success', 'Category restored successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function softdelete($id)
    {
        ExpenseCategory::where('expencate_status', 1)->where('expencate_id', $id)->update([
           'expencate_status' => 0,
           'expencate_editor' => Auth::id(),
           'updated_at' => Carbon::now() 
        ]);

        return redirect()->back()->with('success', 'Category moved to trash successfully');
    }

    public function restore($id)
    {
        ExpenseCategory::where('expencate_id', $id)->update([
            'expencate_status' => 1,
            'expencate_editor' => Auth::id(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'Category restored successfully');
    }


}
