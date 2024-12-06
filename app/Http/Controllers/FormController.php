<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function show()
    {
        return view('forms.form');
    }

    public function getResults() {
        return Result::all();
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        Result::create([
            'company_id' => $user->company_id,
            'properties' => $request->all(),
        ]);

        DB::table('users')
            ->where('id', $user->id)
            ->update(['form_sent' => true]);
    }
}
