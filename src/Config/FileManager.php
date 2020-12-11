<?php
return [

    /*
|--------------------------------------------------------------------------
| Route Settings
|--------------------------------------------------------------------------
|Here you can set up your file upload routes.
|
*/
    "route_prefix" => 'ehelfileupload',
    "route_name"   => 'upload',
    /*
|--------------------------------------------------------------------------
| File Validation and directory.
|--------------------------------------------------------------------------
|Here you can select file size, file extension and directory.
|
*/
    "max_size" => 52428800, // 50 mb 11503452
    "path"    => 'uploads/',
    "mimes"   => ['pdf','doc','docx','odf','png','jpg','jpeg','mp4','mpeg','mp3'],



    /*
|--------------------------------------------------------------------------
| Rewrite File
|--------------------------------------------------------------------------
|Set to true if you want to rewrite existing file
|or set to false if you want to store the new file
|without delete existing (on re-upload).
|
*/
    "rewrite_file" => true
];
