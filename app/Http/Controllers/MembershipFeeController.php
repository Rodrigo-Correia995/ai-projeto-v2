<?php

namespace App\Http\Controllers;

use App\Models\MembershipFee;
use App\Http\Requests\MembershipFeeFormRequest;

class MembershipFeeController extends Controller
{
    public function edit()
    {
        $settings = MembershipFee::getSettings();
        return view('membership_fees.edit', compact('settings'));
    }
public function update(MembershipFeeFormRequest $request)
{
    $settings = MembershipFee::getSettings();
    $settings->update($request->validated());

    return redirect()->route('membership_fees.edit')
        ->with('alert-type', 'success')
        ->with('alert-msg', 'Membership fee updated successfully!');
}

}
