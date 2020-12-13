<?php

namespace Gowd\FileManager\Models;

use Illuminate\Database\Eloquent\Model;

class file_type extends Model
{
    public function mime_types()
    {
        return $this->hasMany(mime_type::class);
    }
}
