<?php

namespace App\Model\Common;
use Illuminate\Database\Eloquent\Model;

/**
 * Class File
 * @package App\Model\Common
 */
class ObjectFile extends Model
{
    protected $fillable = ['objectable_id', 'objectable_type', 'original_name', 'file_name', 'mime', 'size'];
    public function model()
    {
        return $this->morphTo();
    }
}
