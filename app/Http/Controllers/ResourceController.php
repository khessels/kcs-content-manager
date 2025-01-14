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
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function upload(Request $request): RedirectResponse
    {
        // https://www.itsolutionstuff.com/post/laravel-11-drag-and-drop-file-upload-with-dropzone-jsexample.html

        //        $request->validate([
        //            'file' => 'required|mimes:jpg,png,pdf|max:2048',
        //        ]);

        // Process each uploaded image
        foreach($request->file('files') as $image) {
            // Generate a unique name for the image
            $imageName = time() . '_' . $image->getClientOriginalName();

            $response = Storage::disk('spaces')->put( "experimental/" . $imageName, file_get_contents( $image), 'public');
            $json = json_encode( [
                'mimetype' => $image->getMimeType(),
                'name' => $image->getClientOriginalName(),
                'size' => $image->getSize(),
                'dimensions' => $image->dimensions(),
                'alt' => '',
                'title' => '']);
            $response = Storage::disk('spaces')->put( "experimental/" . $imageName . '.json', $json, 'public');
        }
        return back();
    }
    public function view( Request $request): View
    {
        $filters = $request->all();
        $url = Storage::disk('spaces')->url('experimental/');
        $storageAllResources = Storage::disk('spaces')->allFiles("experimental/");
        $resources = [];
        foreach( $storageAllResources as $resource){
            $filename = explode('/', $resource)[1];
            $exploded = explode('.', $filename);
            if( $exploded[count($exploded) -1] == 'json'){
                unset($exploded[count($exploded) -1]);

                $filename = implode('.',  $exploded);
                $imageObject = json_decode(file_get_contents( $url . $filename), true);
                $imageObject['url'] = $url;
                $imageObject['storage-name'] = $filename;
                $resources[] = $imageObject;
            }
        }
        return view('resources')
            ->with('resources', $resources)
            ->with(compact('filters'));
    }
}
