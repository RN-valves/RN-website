<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedFileLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function importable(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class, 'auth_id');
    }
}
