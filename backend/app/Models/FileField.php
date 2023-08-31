<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileField extends Model
{
	/**
	* @var int
	**/
	public const STATUS_IS_VALID = 1;

	/**
	* @var int
	**/
	public const STATUS_IS_NOT_VALID = 0;

    protected $fillable = ['file_id', 'row_id', 'column_number', 'field_value', 'is_valid'];
    
    public function file()
    {
        return $this->belongsTo(File::class);
    }
    
    public function row()
    {
        return $this->belongsTo(FileRow::class, 'row_id');
    }
}