<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	/**
	* @var int
	**/
	public const FILE_STATUS_NEW = 1;

	/**
	* @var int
	**/
	public const FILE_STATUS_IN_PARSING = 2;

	/**
	* @var int
	**/
	public const FILE_STATUS_PROCESSED = 3;

	/**
	* @var int
	**/
	public const FILE_STATUS_ERROR = 4;

    protected $fillable = ['original_filename', 'status', 'file_path'];
    
    public function rows()
    {
        return $this->hasMany(FileRow::class);
    }
    
    public function fields()
    {
        return $this->hasManyThrough(FileField::class, FileRow::class);
    }
}