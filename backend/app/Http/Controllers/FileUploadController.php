<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Queue;
use Illuminate\Http\Request;
use App\Tasks\ParseFileTask;
use App\Models\File;

class FileUploadController extends Controller
{
    public function uploadChunk(Request $request)
    {
        $fileChunk = $request->file('fileChunk');
        $offset = (int) $request->input('offset');
        $isLastChunk = (bool) $request->input('is_last_chunk');
        $originalFileName = $request->input('original_file_name');
        $uniqueId = $request->input('unique_id');

        if (!$uniqueId) {
        	$uniqueId = uniqid();
        }

        $tempFileName = 'temp-file_' . $uniqueId;
        $filePath = storage_path('app/uploads/' . $tempFileName);
        $fileChunk->storeAs('uploads', $tempFileName, 'local');

        if ($isLastChunk) {
        	$file = File::create([
                'original_filename' => $originalFileName,
                'status' => File::FILE_STATUS_NEW,
                'file_path' => $filePath
            ]);

        	$message = [
			    'filepath' => $filePath,
			    'file_id' => $file->id
			];

			Queue::push(function ($job) use ($message) {
				ParseFileTask::parse($message);
			    $job->delete();
			});
        }

        return ['ok' => true, 'unique_id' => $uniqueId];
    }
}