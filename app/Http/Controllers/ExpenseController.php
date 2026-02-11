<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\AdminActivityNotification;
use Illuminate\Support\Str;
use App\Models\Expense;
use Carbon\Carbon;
use Auth;
use Session;
use DB;

class ExpenseController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
      $all = Expense::where('expense_status', 1)->orderBy('expense_id', 'DESC')->get();
      return view('admin.expense.main.all', compact('all'));
    }

    public function add()
    {
        return view ('admin.expense.main.add');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'exp_name'     => 'required|max:80',
            'exp_category'   => 'required',
            'exp_amount'   => 'required',
            'exp_date'   => 'required|date',
        ], [
            'exp_name.required' => 'Please enter your user name',
            'exp_category.required' => 'Please enter your category name',
            'exp_amount.required' => 'Please enter your amount',
            'exp_date.required' => 'Please enter your date',
        ]);

        $slug = 'EC' . uniqid(20);
        $creator = Auth::id();

        Expense::insert([
            'expense_name'   => $request->exp_name,
            'expencate_id'   => $request->exp_category,
            'expense_amount'  => $request->exp_amount,
            'expense_note'  => $request->exp_note,
            'expense_date'    => $request->exp_date,
            'expense_creator' => $creator,
            'expense_slug'    => $slug,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        return redirect()->route('dashboard.expense.index')
                         ->with('success', 'Expense Successfully Inserted');
        
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
       $data = Expense::where('expense_status', 1)->where('expense_slug', $slug)->firstOrFail();
       return view ('admin.expense.main.view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
      $data = Expense::where('expense_status', 1)->where('expense_slug', $slug)->firstOrFail();
      return view ('admin.expense.main.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
    $slug = 'EC' . uniqid(20);
    $editor = Auth::id();

    $expense = Expense::where('expense_id', $request->id)->firstOrFail();

   $expense->update([
        'expense_name'    => $request->exp_name,
        'expencate_id'      => $request->exp_category,
        'expense_amount'  => $request->exp_amount,
        'expense_note'  => $request->exp_note,
        'expense_date'    => $request->exp_date,
        'expense_editor' => $editor,
        'updated_at' => Carbon::now(),
    ]);

    Auth::user()->notify(new AdminActivityNotification(
    title: "Expense updated: {$expense->expense_name}",
    subtitle: "৳".number_format($expense->expense_amount),
    url: url("dashboard/expense"),
    icon: "✏️"
    ));

        return to_route(
        'dashboard.expense.index',
        $slug
        )->with('success', 'Expense Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function restore($id)
    {
        Expense::where('expense_status', 0)->where('expense_id', $id)->update([
            'expense_status' => 1,
            'expense_editor' => Auth::id(),
            'updated_at' => Carbon::now()
        ]);

    return redirect()->back()->with('success', 'Main Expense restored successfully');

    }
    

    public function softdelete($id)
    {
        Expense::where('expense_status', 1)->where('expense_id', $id)->update([
            'expense_status' => 0,
            'expense_editor' => Auth::id(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'Expense moved to trash successfully');
    }

    public function permanentDelete($id)
    {
        Expense::where('expense_id', $id)->delete();

     return redirect()->back()->with('success', 'Expense permanently deleted');

    }
    
}
