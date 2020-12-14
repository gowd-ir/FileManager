<?php

namespace Gowd\FileManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Gowd\FileManager\Models;

class UploadController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $Validation = $request->validate([
            'file'=> 'required|file|mimes:webm,webp,jpg,jpeg,png,mp4,mp3'
        ]);
        $file = $Validation['file'];
        $mime_type = Models\mime_type::where('title', $file->getMimeType())->first();
        $mime_type_id = $mime_type->id;
        $FileType = $mime_type->file_type->title;
        $user_id = $request->get('user')->id;
        $extension = $file->extension();
        $NewFileName = $FileType.'_'.$user_id.'_'.time().'.'.$extension;
        $OriginalFileName = $request->file('file')->getClientOriginalName();
        $file_path = config('FileManager.UploadPath.'.$FileType).'/'.$user_id.'/'.date("Y-m-d");

        try {
            Storage::disk('public')->putFileAs($file_path,$file,$NewFileName);
            $file_uploded = new Models\file(['user_id'=>$user_id ,'mime_type_id' => $mime_type_id, 'name'=>$NewFileName , 'original_name'=>$OriginalFileName,'ext'=>$extension,'file_path'=>$file_path]);
            $file_uploded->save();
            $url = 'http://'.request()->getHttpHost() .'/storage/'.$file_path.'/'.$NewFileName;
            $Message =[
                'data'=> ['url' =>$url,'FileName' => $NewFileName],
                'message'=>[
                    'title'=>Lang::get('messages.Successful'),
                    'body' => Lang::get('messages.UploadSuccessful'),
                    'isSuccess'=>true
                ]];
            return $Message;
        }
        catch (Exception $e)
        {
            $Message =[
                'data'=> null,
                'message'=>[
                    'title'=>Lang::get('messages.UnSuccessful'),
                    'body' => Lang::get('messages.UploadUnSuccessful'),
                    'isSuccess'=>false
                ]];
            return $Message;
        }
    }

    /**
     * Get file
     * @param $input
     * @param $source
     * @param $request
     * @return array|bool|string
     */
    //TODO این بخش در اینده تکمیل خواهد شد
    protected function getFile(Request $request)
    {
        $FileName = $request->FileName;
        $file = Models\file::where('name', $FileName)->first();
        //dd([
        //    'request'=>$request->FileName
        //    ,'file' => $file
        //    ,'file_content' => $file->file_path.'/'.$file->name
        //    ,'cofile' => Storage::disk('public')->get($file->file_path.'/'.$file->name)
        //]);
 return  Storage::disk('public')->get($file->file_path.'/'.$file->name);
    }

}
