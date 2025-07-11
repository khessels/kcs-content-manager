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
    public function upload( Request $request): RedirectResponse
    {
        // https://www.itsolutionstuff.com/post/laravel-11-drag-and-drop-file-upload-with-dropzone-jsexample.html

        //        $request->validate([
        //            'file' => 'required|mimes:jpg,png,pdf|max:2048',
        //        ]);

        // Process each uploaded image
        foreach($request->file('files') as $image) {
            // $response = Storage::disk( config("filesystems.images_disk"))
            //     ->put( config("filesystems.images_directory") . $imageName, file_get_contents( $image), 'public');

            $imageName = time() . '_' . $image->getClientOriginalName();
            $imageName = config("filesystems.images_directory") . $imageName;
            // store the image
            $image->storeAs( config("filesystems.images_disk"), $imageName, 'public');
            // get the image
            $filePath = Storage::disk( config("filesystems.images_disk"))
                ->path($imageName);
            try{
                $mime_type = $image->getMimeType();
            }catch(\Exception $e){
                $mime_type = mime_content_type( $filePath);
            }

            $name = $image->getClientOriginalName();
            $size = $image->getSize();
            $dimensions = $image->dimensions();

            $json = json_encode( [
                'mimetype' => $mime_type,
                'name' => $name,
                'size' => $size,
                'dimensions' => $dimensions,
                'alt' => '',
                'title' => '']);
            $response = Storage::disk( config("filesystems.images_disk"))
                ->put( config("filesystems.images_directory") . $imageName . '.json', $json, 'public');
        }
        return back();
    }
    public function view( Request $request): View
    {
        $filters = $request->all();
        $url = Storage::disk( config("filesystems.images_disk"))
            ->url( config("filesystems.images_directory"));
        $storageAllResources = Storage::disk( config("filesystems.images_disk"))
            ->allFiles( config("filesystems.images_directory"));
        $resources = [];
        foreach( $storageAllResources as $resource){
            $filename = explode('/', $resource);
            $filename = $filename[count($filename) - 1];

            $exploded = explode('.', $filename);
            if( $exploded[count($exploded) -1] == 'json'){
                unset($exploded[count($exploded) -1]);

                $filename = implode('.',  $exploded);
                $imageObject = json_decode( file_get_contents( $url . $filename.'.json'), true);
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
