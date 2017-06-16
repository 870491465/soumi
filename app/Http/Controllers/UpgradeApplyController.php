<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Upgrade;
use App\Models\UpgradeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpgradeApplyController extends Controller
{
    //
    public function index()
    {
        $account_id = Auth::user()->account_id;
        $upgrades = Upgrade::where('account_id', $account_id)->get();
        $upgrade_types = UpgradeType::all();

        return view('upgrade.index', ['upgrades' => $upgrades, 'upgrade_types' => $upgrades]);

    }
}
