<?php

namespace Gowd\FileManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use Illuminate\Support\Facades\File;

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
       if(!is_null($request->get('file_path')) && config('FileManager.rewrite_file')){
            $this->deleteFile($request);
        }
        $directory = $request->get('directory');

//        dd([
//            'file_path'=>$request->get('file_path'),
//            'directory'=>$request->get('directory'),
//            'rewrite_file'=>config('FileManager.rewrite_file'),
//            'request'=>$request
//        ]);
        if ($request->file('file')) {
//            dd(['dd'=>'ddd']);
            $file = $this->getFile('file', $directory, $request);
//            if ($file && $file != 'error') {
//                return response()->json($file);
//
//
//            } else {
//                return response()->json('File is not valid!');
//            }
        }
    }

    /**
     * Get file
     * @param $input
     * @param $source
     * @param $request
     * @return array|bool|string
     */
    protected function getFile($input, $source, $request)
    {
//        dd(['input' => $input, 'source'=>$source, 'request'=>$request]);
        $file = $request->file($input);

        if ($file) {
//            dd(['file'=>$file]);
            return $this->processFile($file, $source);
        } else {

            return false;
        }
    }
    /**
     * Validate and save file
     * @param $file
     * @param $extraDirectory
     * @return array|string
     */
    protected function processFile($file, $extraDirectory)
    {

        $extension = $file->extension();
        $size = $file->getSize();

        $mimes = config('FileManager.mimes');
        $maxSize = config('FileManager.max_size');
        $validation = new \StdClass;
        $validation->error = false;
        $validation->errors = array();
        $validation->message = '';


        if (!in_array($extension, $mimes)) {
            $validation->error = true;
            array_push($validation->errors, 'Restricted file extension');
        }

        if ($size > $maxSize) {
            $validation->error = true;
            array_push($validation->errors, 'File size is more than 50 mb.');

        }
//        dd(['file001'=>$file,'validation'=>$validation,'file'=>$file->getSize(),'file00'=>$file->extension() ,'extraDirectory'=> $extraDirectory]);
        if ($validation->error) {
            return $validation;
        } else {
            if ($file->isValid()) {
                $destinationPath = config('FileManager.path') . $extraDirectory;
                $fileName = $extraDirectory . '_' . rand(11111, 99999) . '.' . $extension;

                $file->move($destinationPath, $fileName);
//                dd(['destinationPath'=>$destinationPath,'fileName'=>$fileName]);
                $validation->message = $destinationPath . '/' . $fileName;
                dd($validation);
                return $validation;
            } else {

                return 'error';
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->deleteFile($request);
    }

    /**
     * Delete file
     * @param Request $request
     */
    protected function deleteFile(Request $request)
    {
        $filename = $request->input('file_path');
        $fullpath = public_path() . '/' . $filename;
        File::delete($fullpath);
    }
}
