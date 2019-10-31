<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;
use App\Http\Request\ChangeUserInformationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends AbstractController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changeInformation()
    {
        return view('change-user-information');
    }

    /**
     * @param ChangeUserInformationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function editInformation(ChangeUserInformationRequest $request)
    {
        $isUpdated = auth()->user()->update($request->all());

        if (!$isUpdated) {
            return redirect(route('user.change-information'))->with('error', __('Not Saved!'));
        }

        return redirect(route('user.change-information'))->with('success', __('Saved!'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePassword()
    {
        return view('change-user-password');
    }

    /**
     * @param ChangeUserInformationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function editPassword(Request $request)
    {
        $password = $request->get('password');
        $password = Hash::make($password);
        $isUpdated = auth()->user()->update(['password' => $password]);

        if (!$isUpdated) {
            return redirect(route('user.change-password'))->with('error', __('Not Saved!'));
        }

        return redirect(route('user.change-password'))->with('success', __('Saved!'));
    }
}
