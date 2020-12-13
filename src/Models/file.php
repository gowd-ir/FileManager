<?php

namespace Gowd\FileManager\Models;

use Illuminate\Database\Eloquent\Model;

class file extends Model
{
//    protected $table;
//    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id'
        ,'mime_type_id'
        ,'name'
        ,'original_name'
        ,'ext'
        ,'file_path'
    ];
    protected $hidden = [];
    // هر فایل یک میمی فقط میتواند داشته باشد
    public function mime_type()
    {
        return $this->hasMany(mime_type::class);
    }
}
