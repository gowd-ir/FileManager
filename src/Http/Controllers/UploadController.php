<?php

namespace Gowd\FileManager\Http\Controllers;

//use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Gowd\FileManager\Models;

//use Intervention\Image\Image;
use Intervention\Image\Facades\Image;

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
//        dd([
//            'Validation'=>$Validation['file'],
//            'file_path'=>$request->get('file_path'),
//            'directory'=>$request->get('directory'),
//            'rewrite_file'=>config('FileManager.rewrite_file'),
//            'MimeType'=>$request->file('file')->getMimeType(),
//            'extension'=>$request->file('file')->extension(),
////            'FielType' => explode("/", $request->file('file')->getMimeType())[0] ,
////            'user_id'=> $request->get('user')['id'],
////            'FileName' => explode("/", $request->file('file')->getMimeType())[0].'_'.$request->get('user')['id'].'_'.time().'.'.$request->file('file')->extension(),
////            'OriginalName'=>$request->file('file')->getClientOriginalName(),
////            'Date' => date("Y-m-d"),
////            'path'=>explode("/", $request->file('file')->getMimeType())[0].'/'.$request->get('user')['id'].'/'.date("Y-m-d"),
////            'file'=>$request->file,
////            'request'=>$request
//        ]);
        $file = $Validation['file'];
        $FileType = $request->get('FileType');
        $mime_type = Models\mime_type::where('title', $file->getMimeType())->first();
        $mime_type_id = $mime_type->id;
        $type_File = $mime_type->file_type->title;
        $user_id = $request->get('user')->id;
        $extension = $file->extension();
        $NewFileName = $type_File.'_'.$user_id.'_'.time().'.'.$extension;
        $OriginalFileName = $request->file('file')->getClientOriginalName();
        $file_path = config('FileManager.UploadPath.'.$type_File).'/'.$user_id.'/'.date("Y-m-d");
//        dd([
//              'file_type'=>$type_File
//            , 'mime_type_id' => $mime_type_id
//            , 'user_id' =>$user_id
//            , 'extension'=>$extension
//            , 'NewFileName'=>$NewFileName
//            , 'OriginalFileName' =>$OriginalFileName
//            , 'file_path' => $file_path
//            , 'FileType' => $FileType
//            , 'orginal_file_path' => $file->getRealPath()
//        ] );
        try {
//            if ($type_File === 'image' and $FileType === 'Avatar')
//            {
//                $file = Image::make($file)->resize(600, null, function ($constraint) {
//                    $constraint->aspectRatio();
//                })->encode('jpg');
//                $save = Storage::put($file_path, $file->__toString());
//                $orginFiel =$file;
//                //$file = Image::make($file->getRealPath())->resize(300,300);
////                $file->move('/images/products');
//                //$file->save($file_path.'/dd.jpg');
//                dd(['orginFiel'=>$file_path]);
//            }
            Storage::disk('public')->putFileAs($file_path,$file,$NewFileName);
//            $file = Image::make($file_path.'/'.$NewFileName)->resize(300,300);
            $file_uploded = new Models\file(['user_id'=>$user_id ,'mime_type_id' => $mime_type_id, 'name'=>$NewFileName , 'original_name'=>$OriginalFileName,'ext'=>$extension,'file_path'=>$file_path]);
//            $mime_type->files()->associate($file_uploded);
            $file_uploded->save();
            $url = 'http://'.request()->getHttpHost() .'/storage/'.$file_path.'/'.$NewFileName;
            //gowd.developer/storage/audio/1/2020-12-12/audio_1_1607741096.mp3
            //gowd.developer/storage/audio/1/2020-12-12/audio_1_1607740157.mp3
            $Message =[
                'data'=> ['url' =>$url,'FileName' => $NewFileName],
                'message'=>[
                    'title'=>Lang::get('messages.Successful'),
                    'body' => Lang::get('messages.UploadSuccessful'),
                    'isSuccess'=>true
                ]];

            return $Message;
//            $download = Storage::
//            dd([
//                'file_type'=>$type_File
//                , 'mime_type_id' => $mime_type_id
//                , 'user_id' =>$user_id
//                , 'extension'=>$extension
//                , 'NewFileName'=>$NewFileName
//                , 'OriginalFileName' =>$OriginalFileName
//                , 'file_path' => $file_path
//                , 'url' => $url
//                , 'Fullurl' => $storagePath  = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix()
////                , 'cofile' => Storage::disk('public')->get($file_path.'/'.$NewFileName)
//
//            ] );
        }
        catch (Exception $e)
        {
            dd([
                   'file_type000'=>$type_File
                 , 'mime_type_id' => $mime_type_id
                 , 'user_id' =>$user_id
                 , 'extension'=>$extension
                 , 'NewFileName'=>$NewFileName
                 , 'OriginalFileName' =>$OriginalFileName
                 , 'file_path' => $file_path
                ] );
        }
    }

    /**
     * Get file
     * @param $input
     * @param $source
     * @param $request
     * @return array|bool|string
     */
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
