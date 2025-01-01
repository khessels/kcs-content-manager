<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\App;
use App\Models\Content;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function upload(): RedirectResponse
    {
        return back();
    }
    public function view( Request $request): View
    {
        $filters = $request->all();
        return view('resources')
            ->with(compact('filters'));
    }
}
