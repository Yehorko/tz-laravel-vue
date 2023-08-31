<?php

namespace App\Tasks;
use App\Models\{File, FileRow, FileField};

class ParseFileTask
{
    public static function parse(array $fileData)
    {
        $fileRecord = File::find($fileData['file_id']);
        if (!$fileRecord) {
            $errMsg = "There is no reccord about file with id {$fileData['file_id']}" . PHP_EOL;
            $errMsg .= "No record - No problems. :)";

            echo $errMsg;

            return;
        }

        $fileRecord->status = File::FILE_STATUS_IN_PARSING;
        $fileRecord->save();

        if (file_exists($fileData['filepath'])) {

            $file = fopen($fileData['filepath'], 'r');

            if ($file) {
                $rowNumber = 1;
                while (($line = fgets($file)) !== false) {
                    $row = $fileRecord->rows()->create([
                        'row_number' => $rowNumber,
                        'is_valid' => FileRow::STATUS_IS_VALID,
                    ]);
                    $rowValues = explode(',', $line);

                    $valuesBatch = [];
                    $columnNumber = 1;

                    foreach ($rowValues as $columnPosition => $columnValue) {
                        $valueIsValid = ctype_digit($columnValue) || empty($columnValue) ? false : true;
                        $valuesBatch[] = [
                            'file_id' => $fileRecord->id,
                            'column_number' => $columnNumber, 
                            'field_value' => $columnValue,
                            'is_valid' =>  $valueIsValid ? FileField::STATUS_IS_VALID : FileField::STATUS_IS_NOT_VALID,
                        ];
                        if (!$valueIsValid) {
                            $row->is_valid = FileRow::STATUS_IS_NOT_VALID;
                            $row->save();
                        }
                        $columnNumber++;
                    }

                    $row->fields()->createMany($valuesBatch);

                    $rowNumber++;
                }
                fclose($file);

                $fileRecord->status = File::FILE_STATUS_PROCESSED;
            } else {
                $fileRecord->status = File::FILE_STATUS_ERROR;
            }
        } else {
            $fileRecord->status = File::FILE_STATUS_ERROR;
        }
        $fileRecord->save();
    }
}