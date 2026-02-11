<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\IncomeCategory;
use App\Http\Controllers\IncomeCategoryController;
use Carbon\Carbon;
use Auth;
use Session;
use DB;

class IncomeCategoryController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allData = DB::table('income_categories')->where('incate_status',1)->orderBy('incate_id', 'DESC')->get();
        return view('admin.income.category.all', compact('allData'));

    }

    public function add()
    {
        return view('admin.income.category.add');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:25|unique:income_categories,incate_name',
            'remarks'=>'required|max:500'
        ], [
        //    'incate_name' => 'Please inter your category name'
        ]);

        $slug = Str::slug($request['name'], '-');
        $creator = Auth::user()->id;
       IncomeCategory::insert([
        'incate_name' => $request['name'],
        'incate_remarks' => $request['remarks'],
        'incate_creator' => $creator,
        'incate_slug' => $slug,
        'created_at' => Carbon::now()->toDateTimeString(),
       ]);

        return to_route('dashboard.income.category.index')->with('success', 'Income Category Successfully Inserted');
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function restore($id)
    {
        IncomeCategory::where('incate_id', $id)->update([
            'incate_status' => 1,
            'incate_editor' => Auth::id(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'Category restored successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $data = IncomeCategory::where('incate_status',1)->where('incate_slug',$slug)->firstOrFail();
        return view('admin.income.category.view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
       $data = IncomeCategory::where('incate_status', 1)->where('incate_slug', $slug)->firstOrFail();
       return view('admin.income.category.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request)
{
    $request->validate([
        'name' => 'required|max:25|unique:income_categories,incate_name,' . $request->id . ',incate_id',
        'remarks' => 'required|max:500'
    ]);

    $slug = Str::slug($request->name);
    $editor = Auth::id();

    IncomeCategory::where('incate_id', $request->id)->update([
        'incate_name' => $request->name,
        'incate_remarks' => $request->remarks,
        'incate_slug' => $slug,
        'incate_editor' => $editor,
        'updated_at' => Carbon::now(),
    ]);

return to_route(
    'dashboard.income.category.show',
    $slug
)->with('success', 'Income Category Updated Successfully');

}

    /**
     * Remove the specified resource from storage.
     */
    public function permanentDelete(string $id)
    {
        IncomeCategory::where('incate_id', $id)->delete();

        return redirect()->back()->with('success', 'Category permanently deleted');
    }

    public function softdelete($id)
    {
        IncomeCategory::where('incate_status', 1)->where('incate_id', $id)->update([
            'incate_status' => 0,
            'incate_editor' => Auth::id(),
            'updated_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'Category moved to trash successfully');
    }
}
