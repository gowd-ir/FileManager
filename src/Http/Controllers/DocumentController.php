<?php

namespace Gowd\FileManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class DocumentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test(Request $request)
    {
        $Message =[
           // 'data'=> $request->get('user'),
            'message'=>[
                'title'=>Lang::get('messages.Successful'),
                'body' => Lang::get('messages.Signin'),
                'isSuccess'=>true
            ]];

        return $Message;
    }

}
