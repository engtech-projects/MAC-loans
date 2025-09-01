<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Center;

class MaintenanceController extends Controller
{
    public function productSetup()
    {
        $this->checkAccess('view product setup');
        return view('maintenance.product_setup')->with([
            'nav' => ['maintenance', 'product setup'],
            'title' => 'MAC | Product Setup',
        ]);
    }

    public function cancelPayments()
    {
        $this->checkAccess('view cancelled payments');
        return view('maintenance.cancel_payments')->with([
            'nav' => ['maintenance', 'cancel payments'],
            'title' => 'MAC | Cancel Payments',
        ]);
    }

    public function centerAo()
    {
        $this->checkAccess('view center');
        return view('maintenance.center_ao')->with([
            'nav' => ['maintenance', 'center ao'],
            'title' => 'MAC | Center - Account Officer Setup',
        ]);
    }

    public function userSettings()
    {
        $this->checkAccess('view users');
        return view('maintenance.user_settings')->with([
            'nav' => ['maintenance', 'user settings'],
            'title' => 'MAC | User Settings',
        ]);
    }

    public function glSetup()
    {
        $this->checkAccess('view gl setup');
        return view('maintenance.gl_setup')->with([
            'nav' => ['maintenance', 'gl setup'],
            'title' => 'MAC | General Ledger Setup',
        ]);
    }

    public function accountRetagging()
    {
        $this->checkAccess('view account retagging');
        return view('maintenance.account_retagging')->with([
            'nav' => ['maintenance', 'account retagging'],
            'title' => 'MAC | Account Retagging',
        ]);
    }

    public function deductionRates()
    {
        $this->checkAccess('view deduction rate');
        return view('maintenance.deductions')->with([
            'nav' => ['maintenance', 'deduction rates'],
            'title' => 'MAC | Deduction Rate',
        ]);
    }

    public function activityLogs()
    {
        $this->checkAccess('view activity logs');
        return view('maintenance.activity_logs')->with([
            'nav' => ['maintenance', 'activity logs'],
            'title' => 'MAC | Activity Logs',
        ]);
    }

    public function retagList()
    {
        $accounts =  \App\Models\LoanAccount::where('loan_status', '<>', 'Paid')->get();
        foreach ($accounts as $key => $value) {
            $accounts[$key]->borrower->photo = $value->borrower->getPhoto();
            $accounts[$key]->checked = false;
        }
        return $accounts;
    }
}
