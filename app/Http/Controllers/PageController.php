<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Content;
use App\Models\Page;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use function PHPUnit\Framework\isNumeric;

class PageController extends Controller
{
    public function dashboard(): View
    {
        return view('dashboard');
    }
    public function applications(): View
    {
        return view('applications');
    }
    public function add_page(Request $request)
    {
        if( ! $request->headers->has('app')) {
            return 'ERROR: No app specified';
        }
        $app = $request->headers->get('app');
        $all = $request->all();
        $all['app'] = $app;
        Page::create( $all);
        return 'OK';
    }
    public function remove_page(Request $request, $page)
    {
        if( ! $request->headers->has('app')) {
            return 'ERROR: No app specified';
        }
        $app = $request->headers->get('app');
        if( isNumeric( $page)){
            Page::where('id', $page)->where('app', $app)->delete();
        }else{
            Page::where('page', $page)->where('app', $app)->delete();
        }
        return 'OK';
    }
    public function get_page(Request $request, $page)
    {
        if( ! $request->headers->has('app')) {
            return 'ERROR: No app specified';
        }
        $app = $request->headers->get('app');
        if( isNumeric( $page)){
            return Page::where('id', $page)->where('app', $app)->first();
        }
        return Page::where('page', $page)->where('app', $app)->first();
    }
    public function list(Request $request, $filter = 'ALL')
    {
        if( ! $request->headers->has('app')) {
            return 'ERROR: No app specified';
        }
        $app = $request->headers->get('app');
        if( strtoupper($filter) === 'ALL' ){
            return Page::where( 'app', $app)->get();
        }
        return Page::where( 'status', $filter)->where( 'app', $app)->get();
    }
    public function active_state(Request $request, $page, $state)
    {
        if( ! $request->headers->has('app')) {
            return 'ERROR: No app specified';
        }
        $app = $request->headers->get('app');
        if( isNumeric( $page)){
            $o = Page::where('id', $page)->where('app', $app)->first();
        }else{
            $o = Page::where('page', $page)->where('app', $app)->first();
        }
        $o->status = $state;
        $o->save();

        return 'OK';
    }
}
