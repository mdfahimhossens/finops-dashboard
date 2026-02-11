<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RecycleController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});


// ===========================
// ALL AUTH USERS (admin, manager, viewer)
// ===========================
Route::middleware(['auth','role:admin,manager,viewer'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard.index');
    Route::get('dashboard/my-profile', [ProfileController::class, 'adminProfile'])->name('dashboard.profile');
    Route::post('dashboard/my-profile', [ProfileController::class, 'adminProfileUpdate'])->name('dashboard.profile.update');

    Route::get('dashboard/manage-account', [ProfileController::class, 'adminAccount'])->name('dashboard.account');
    Route::post('dashboard/manage-account/password', [ProfileController::class, 'adminPasswordUpdate'])->name('dashboard.account.password');

    // Notifications (সবাই দেখবে/clear করবে নিজের)
    Route::get('dashboard/notifications/poll', [NotificationController::class, 'poll'])
        ->name('dashboard.notifications.poll');

    Route::post('dashboard/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])
        ->name('dashboard.notifications.markAllRead');

    Route::post('dashboard/notifications/clear-all', [NotificationController::class, 'clearAll'])
        ->name('dashboard.notifications.clearAll');

    // Reports (Viewer-ও দেখতে পারবে)
    Route::get('/dashboard/report', [ReportController::class, 'expense'])->name('dashboard.report');
    Route::get('/dashboard/report/income', [ReportController::class, 'incomeReport'])->name('dashboard.report.income');

    Route::match(['get','post'],'/dashboard/report/income/monthly', [ReportController::class, 'monthlyIncomeReport'])
        ->name('dashboard.report.income.monthly');

    Route::post('/dashboard/report/income/filter', [ReportController::class, 'incomeReportFilter'])
        ->name('dashboard.report.income.filter');

    Route::post('/dashboard/report/income/pdf', [ReportController::class, 'incomeReportPdf'])
        ->name('dashboard.report.income.pdf');

    Route::post('/dashboard/report/income/monthly/pdf', [ReportController::class, 'monthlyIncomePdf'])
        ->name('dashboard.report.income.monthly.pdf');

    Route::get('/dashboard/report/expense', [ReportController::class, 'expenseReport'])
        ->name('dashboard.report.expense');

    Route::match(['get','post'],'/dashboard/report/expense/monthly', [ReportController::class, 'monthlyExpenseReport'])
        ->name('dashboard.report.expense.monthly');

    Route::match(['get','post'],'/dashboard/report/expense/monthly/pdf', [ReportController::class, 'monthlyExpensePdf'])
        ->name('dashboard.report.expense.monthly.pdf');

    Route::post('/dashboard/report/expense/filter', [ReportController::class, 'expenseReportFilter'])
        ->name('dashboard.report.expense.filter');

    Route::post('/dashboard/report/expense/pdf', [ReportController::class, 'expenseReportPdf'])
        ->name('dashboard.report.expense.pdf');

    Route::get('/dashboard/report/profit-loss', [ReportController::class, 'profitLoss'])
        ->name('dashboard.report.profit-loss');

    Route::post('/dashboard/report/profit-loss', [ReportController::class, 'profitLoss']);

    Route::post('/dashboard/report/profit-loss/monthly', [ReportController::class, 'profitLossMonthly'])
        ->name('dashboard.report.profit-loss.monthly');

    Route::get('dashboard/report/profit-loss/print', [ReportController::class, 'profitLossPrint']);
    Route::get('dashboard/report/profit-loss/pdf', [ReportController::class, 'profitLossPdf'])
        ->name('profit.loss.pdf');
});


// ===========================
// VIEW ONLY (admin, manager, viewer)
// (List + View pages only)
// ===========================
Route::middleware(['auth','role:admin,manager,viewer'])->group(function () {

    // Users list + view
    Route::get('/dashboard/user', [UserController::class, 'index'])->name('dashboard.user.index');
    Route::get('/dashboard/user/view/{slug}', [UserController::class, 'show'])->name('dashboard.user.show');

    // Income list + view
    Route::get('/dashboard/income', [IncomeController::class, 'index'])->name('dashboard.income.index');
    Route::get('/dashboard/income/view/{slug}', [IncomeController::class, 'show'])->name('dashboard.income.view');

    // Income category list + view
    Route::get('/dashboard/income/category', [IncomeCategoryController::class, 'index'])->name('dashboard.income.category.index');
    Route::get('/dashboard/income/category/view/{slug}', [IncomeCategoryController::class, 'show'])->name('dashboard.income.category.show');

    // Expense list + view
    Route::get('/dashboard/expense', [ExpenseController::class, 'index'])->name('dashboard.expense.index');
    Route::get('/dashboard/expense/view/{slug}', [ExpenseController::class, 'show'])->name('dashboard.expense.show');

    // Expense category list + view
    Route::get('/dashboard/expense/category', [ExpenseCategoryController::class, 'index'])->name('dashboard.expense.category.index');
    Route::get('/dashboard/expense/category/view/{slug}', [ExpenseCategoryController::class, 'show'])->name('dashboard.expense.category.show');
});


// ===========================
// MANAGE (admin + manager)
// (Add/Edit/Update/Store — but no permanent delete user)
// ===========================
Route::middleware(['auth','role:admin,manager'])->group(function () {

    // Users: edit/update allowed for manager (delete not)
    Route::get('/dashboard/user/edit/{slug}', [UserController::class, 'edit'])->name('dashboard.user.edit');
    Route::post('/dashboard/user/update/{slug}', [UserController::class, 'update'])->name('dashboard.user.update');

    // Income manage
    Route::get('/dashboard/income/add', [IncomeController::class, 'add'])->name('dashboard.income.add');
    Route::get('/dashboard/income/edit/{slug}', [IncomeController::class, 'edit'])->name('dashboard.income.edit');
    Route::post('/dashboard/income/store', [IncomeController::class, 'store'])->name('dashboard.income.store');
    Route::post('/dashboard/income/update', [IncomeController::class, 'update'])->name('dashboard.income.update');

    // Income Category manage
    Route::get('/dashboard/income/category/add', [IncomeCategoryController::class, 'add'])->name('dashboard.income.category.add');
    Route::get('/dashboard/income/category/edit/{slug}', [IncomeCategoryController::class, 'edit'])->name('dashboard.income.category.edit');
    Route::post('/dashboard/income/category/update', [IncomeCategoryController::class, 'update'])->name('dashboard.income.category.update');

    // Expense manage
    Route::get('/dashboard/expense/add', [ExpenseController::class, 'add'])->name('dashboard.expense.add');
    Route::get('/dashboard/expense/edit/{slug}', [ExpenseController::class, 'edit'])->name('dashboard.expense.edit');
    Route::post('/dashboard/expense/store', [ExpenseController::class, 'store'])->name('dashboard.expense.store');
    Route::post('/dashboard/expense/update', [ExpenseController::class, 'update'])->name('dashboard.expense.update');

    // Expense Category manage
    Route::get('/dashboard/expense/category/add', [ExpenseCategoryController::class, 'add'])->name('dashboard.expense.category.add');
    Route::get('/dashboard/expense/category/edit/{slug}', [ExpenseCategoryController::class, 'edit'])->name('dashboard.expense.category.edit');
    Route::post('/dashboard/expense/category/update', [ExpenseCategoryController::class, 'update'])->name('dashboard.expense.category.update');

    // Recycle (Manager দেখতে/restore করতে পারবে)
    Route::get('/dashboard/recycle', [RecycleController::class, 'index']);
    Route::get('/dashboard/recycle/user', [RecycleController::class, 'user']);
    Route::get('/dashboard/recycle/income', [RecycleController::class, 'income']);
    Route::get('/dashboard/recycle/expense', [RecycleController::class, 'expense']);
    Route::get('/dashboard/recycle/income/category', [RecycleController::class, 'income_category']);
    Route::get('/dashboard/recycle/expense/category', [RecycleController::class, 'expense_category']);
});


// ===========================
// ADMIN ONLY
// (User add/delete + category delete/restore + income/expense delete/restore)
// ===========================
Route::middleware(['auth','role:admin'])->group(function () {

    // Users admin actions
    Route::get('/dashboard/user/add', [UserController::class, 'add'])->name('dashboard.user.add');
    Route::post('/dashboard/user/store', [UserController::class, 'store'])->name('dashboard.user.store');
    Route::delete('/dashboard/user/delete/{id}', [UserController::class, 'destroy'])->name('dashboard.user.destroy');
    Route::post('/dashboard/user/softdelete', [UserController::class, 'softdelete'])->name('dashboard.user.softdelete');

    // Income delete/restore (admin only)
    Route::get('/dashboard/income/delete/{id}', [IncomeController::class, 'permanentDelete'])->name('dashboard.income.permanentDelete');
    Route::get('/dashboard/income/restore/{id}', [IncomeController::class, 'restore'])->name('dashboard.income.restore');
    Route::get('/dashboard/income/softdelete/{id}', [IncomeController::class, 'softdelete'])->name('dashboard.income.softdelete');

    // Income category delete/restore (admin only)
    Route::get('/dashboard/income/category/delete/{id}', [IncomeCategoryController::class, 'permanentDelete'])->name('dashboard.income.category.permanentDelete');
    Route::get('/dashboard/income/category/restore/{id}', [IncomeCategoryController::class, 'restore'])->name('dashboard.income.category.restore');
    Route::get('/dashboard/income/category/softdelete/{id}', [IncomeCategoryController::class, 'softdelete'])->name('dashboard.income.category.softdelete');

    // Expense delete/restore (admin only)
    Route::get('/dashboard/expense/delete/{id}', [ExpenseController::class, 'permanentDelete'])->name('dashboard.expense.permanentDelete');
    Route::get('/dashboard/expense/restore/{id}', [ExpenseController::class, 'restore'])->name('dashboard.expense.restore');
    Route::get('/dashboard/expense/softdelete/{id}', [ExpenseController::class, 'softdelete'])->name('dashboard.expense.softdelete');

    // Expense category delete/restore (admin only)
    Route::get('/dashboard/expense/category/delete/{id}', [ExpenseCategoryController::class, 'permanentDelete'])->name('dashboard.expense.category.permanentDelete');
    Route::get('/dashboard/expense/category/restore/{id}', [ExpenseCategoryController::class, 'restore'])->name('dashboard.expense.category.restore');
    Route::get('/dashboard/expense/category/softdelete/{id}', [ExpenseCategoryController::class, 'softdelete'])->name('dashboard.expense.category.softdelete');
});

require __DIR__.'/auth.php';
