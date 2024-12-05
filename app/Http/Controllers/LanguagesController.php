<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use App\Traits\Content;
use Illuminate\Support\Facades\Session;

class LanguagesController extends Controller
{
    public function languageSwitch(Request $request)
    {
        try {
            $language = $request->input('language');
            Session::put('language', $language);
            return redirect()->back()->with('language_switched' , $language);
        } catch (\Exception $e) {
            $this->criticalException($request, $e, __FILE__, __FUNCTION__, __LINE__);
            abort(404);
        }
    }
    public function responseObject($request, $status, $data = null, $errors = null, $aPage = null, $itemCount = null, $meta = null): array
    {
        $meta = empty($meta) ? [] : $meta;
        $statusValue = empty($status) ? false : $status;
        $responseObject['status'] = (int) $statusValue;

        if(is_array($meta) && !empty($meta)) {
            foreach($meta as $field => $value) {
                $responseObject[$field] = $value;
            }
        }

        if( ! empty( $aPage['page'] )){
            $responseObject['page'] = (int)$aPage['page'];
            $responseObject['page_count'] = (int) ceil( $itemCount / $aPage['recordsPerPage']);
            $responseObject['records_per_page'] = (int) $aPage['recordsPerPage'];
            if(is_numeric($itemCount)) {
                $responseObject['item_count'] = (int)$itemCount;
            }
        }

        $responseDataFormat = "V3";
        if(!empty($request)){
            if( ! empty($request->hasHeader('x-response-data-format'))){
                $responseDataFormat = $request->header('x-response-data-format');
            }
        }
        $responseErrorFormat = "V3";
        if(!empty($request)){
            if( ! empty($request->hasHeader('x-response-error-format'))){
                $responseErrorFormat = $request->header('x-response-error-format');
            }
        }
        switch(strtoupper($responseDataFormat)){
            default:
            case 'V3':
                $responseObject = $this->responseDataFormatV3($responseObject, $data);
                break;
        }
        switch(strtoupper($responseErrorFormat)){
            default:
            case 'V3':
                $responseObject = $this->responseErrorFormatV3($responseObject, $errors);
                break;
        }
        return $responseObject;

    }
    protected function responseDataFormatV3($responseObject, $data): array
    {
        if ($data instanceof Collection) {
            $responseObject['data'] = $data->toArray();
        }else if( is_array($data)){
            $responseObject['data'] = $data;
        }else if( ! is_null($data)){
            $responseObject['data'] = $data;
        }
        return $responseObject;
    }
    protected function responseErrorFormatV3($responseObject, $errors): array
    {
        if (!empty($errors)) {
            if (is_array($errors)) {
                foreach ($errors as $error) {
                    error_log($error);
                }
                $responseObject['errors'] = $errors;
            } else {
                error_log($errors);
                $responseObject['errors'] = [$errors];
            }
        }
        return $responseObject;
    }
}
