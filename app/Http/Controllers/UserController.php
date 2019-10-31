<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractController;

class UserController extends AbstractController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changeInformation()
    {
        return view('change-user-information');
    }
}
