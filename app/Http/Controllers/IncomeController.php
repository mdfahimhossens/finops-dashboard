<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\AdminActivityNotification;
use Illuminate\Support\Str;
use App\Models\Income;
use Carbon\Carbon;
use Auth;
use Session;
use DB;

class IncomeController extends Controller
{
    public function index()
    {
        $all = Income::where('income_status', 1)
                     ->orderBy('income_id', 'DESC')
                     ->get();
        return view('admin.income.main.all', compact('all'));
    }

    public function add()
    {
        return view('admin.income.main.add');
    }

    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'inc_name'     => 'required|max:80',
            'inc_position'   => 'required',
            'inc_office'   => 'required',
            'inc_age'      => 'required',
            'inc_salary'   => 'required',
            'inc_date'     => 'required|date',
        ], [
            'inc_name.required' => 'Please enter your income name',
            'inc_position.required' => 'Please enter your category name',
            'inc_office.required' => 'Please enter your office name',
            'inc_age.required' => 'Please enter your age',
            'inc_salary.required' => 'Please enter your amount',
            'inc_date.required' => 'Please enter your date',
        ]);

        $slug = 'IC' . uniqid(20);
        $creator = Auth::id();

       $income = Income::create([
            'income_name'    => $request->inc_name,
            'incate_id'      => $request->inc_position,
            'income_office'  => $request->inc_office,
            'income_age'     => $request->inc_age,
            'income_salary'  => $request->inc_salary,
            'income_date'    => $request->inc_date,
            'income_creator' => $creator,
            'income_slug'    => $slug,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        Auth::user()->notify(new AdminActivityNotification(
        title: "Income added: {$income->income_name}",
        subtitle: "৳".number_format($income->income_salary),
        url: url("dashboard/income"),
        icon: "💰"
        ));

        return redirect()->route('dashboard.income.index')
                         ->with('success', 'Income Successfully Inserted');
        
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
       $data = Income::where('income_slug', $slug)->firstOrFail();
        return view('admin.income.main.view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $data = Income::where('income_slug', $slug)->firstOrFail();
        return view ('admin.income.main.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
        'inc_name' => 'required',
        'inc_position' => 'required',
        'inc_office'   => 'required',
        'inc_age'      => 'required',
        'inc_salary'   => 'required',
        'inc_date'     => 'required|date',
    ]);

    $slug = 'IC' . uniqid(20);
    $editor = Auth::id();

    Income::where('income_id', $request->id)->update([
        'income_name'    => $request->inc_name,
        'incate_id'      => $request->inc_position,
        'income_office'  => $request->inc_office,
        'income_age'     => $request->inc_age,
        'income_salary'  => $request->inc_salary,
        'income_date'    => $request->inc_date,
        'income_editor' => $editor,
        'updated_at' => Carbon::now(),
    ]);

    return to_route(
        'dashboard.income.index',
        $slug
    )->with('success', 'Income Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function permanentDelete($id)
    {
        Income::where('income_id', $id)->delete();

       return redirect()->back()->with('success', 'Main income permanently deleted');

    }

    public function restore($id){
        Income::where('income_id', $id)->update([
            'income_status' => 1,
            'income_editor' => Auth::id(),
            'updated_at' => Carbon::now()
        ]);

     return redirect()->back()->with('success', 'Main income restored successfully');

    }

    public function softdelete($id)
    {
        Income::where('income_status', 1)->where('income_id', $id)->update([
            'income_status' => 0,
            'income_editor' => Auth::id(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'Income moved to trash successfully');
    }
}
