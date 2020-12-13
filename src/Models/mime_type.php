<?php

namespace Gowd\FileManager\Models;

use Illuminate\Database\Eloquent\Model;

class mime_type extends Model
{
    //یک فایل تایپ فقط دارد هر میمی
    public function file_type()
    {
        return $this->belongsTo(file_type::class);
    }
    // در فایلهای مختلف میتواند مورد استفاده قرار گیرد
    public function files()
    {
        return $this->belongsTo(file::class);
    }
}
