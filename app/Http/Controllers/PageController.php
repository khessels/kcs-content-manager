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
        try{
            $all = $request->all();
            if( ! $request->headers->has('app')) {
                return 'ERROR: No app specified';
            }
            $xDev = $request->header('x-dev');
            $xApp = $request->header('x-app');

            $all['app'] = $xApp;
            $all['env_source'] = $xDev;
            $all['env'] = 'local';
            if( $request->has('env')){
                $all['env'] = $request->env;
            }
            $all['status'] = 'ACTIVE';
            if( $request->has('status')){
                $all['status'] = $request->status;
            }
            Page::create( $all);
            return 'OK';
        }catch(\Exception $e){
            error_log($e->getMessage());
            return 'ERROR: ' . $e->getMessage();
        }
    }
    public function remove_page(Request $request, $page)
    {
        if( ! $request->headers->has('app')) {
            return 'ERROR: No app specified';
        }
        $xApp = $request->header('x-app');

        if( isNumeric( $page)){
            Page::where('id', $page)->where('app', $xApp)->delete();
        }else{
            Page::where('page', $page)->where('app', $xApp)->delete();
        }
        return 'OK';
    }
    public function get_page(Request $request, $page)
    {
        if( ! $request->headers->has('app')) {
            return 'ERROR: No app specified';
        }
        $xApp = $request->header('x-app');
        if( isNumeric( $page)){
            return Page::where('id', $page)->where('app', $xApp)->first();
        }
        return Page::where('page', $page)->where('app', $xApp)->first();
    }
    public function list(Request $request, $filter = 'ALL')
    {
        if( ! $request->headers->has('app')) {
            return 'ERROR: No app specified';
        }
        $xApp = $request->header('x-app');
        if( strtoupper($filter) === 'ALL' ){
            return Page::where( 'app', $xApp)->get();
        }
        return Page::where( 'status', $filter)->where( 'app', $xApp)->get();
    }
    public function active_state(Request $request, $page, $state)
    {
        if( ! $request->headers->has('app')) {
            return 'ERROR: No app specified';
        }
        $xApp = $request->header('x-app');
        if( isNumeric( $page)){
            $o = Page::where('id', $page)->where('app', $xApp)->first();
        }else{
            $o = Page::where('page', $page)->where('app', $xApp)->first();
        }
        $o->status = $state;
        $o->save();

        return 'OK';
    }
}
