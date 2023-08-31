<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileRow extends Model
{
	/**
	* @var int
	**/
	public const STATUS_IS_VALID = 1;

	/**
	* @var int
	**/
	public const STATUS_IS_NOT_VALID = 0;

    protected $fillable = ['file_id', 'row_number', 'is_valid'];
    
    public function file()
    {
        return $this->belongsTo(File::class);
    }
    
    public function fields()
    {
        return $this->hasMany(FileField::class, 'row_id');
    }
}