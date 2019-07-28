<?php
namespace App\Services;

use App\Http\Requests\HandleUploadPost;
use Carbon\Carbon;
use Storage;
use Illuminate\Http\UploadedFile;
class SplitBillService implements SplitBillServiceInterface
{
    // TODO: Handlle following methods
    // Total number of days
    // Total amount spent by all friends
    // How much each friend has spent. (If I bring someone outside of the circle, then it comes under my account )
    // How much each user owes. (If there are minus values the ignore them)
    // Automatically generated a settlement combination. 

    public function calculate(HandleUploadPost $request)
    {
        $jsonContent = null;
        // File preparation
        if ($request->hasFile('jsonFile')) {
            $fileContent = Storage::get($this->storeJsonFile($request->file('jsonFile')));
            $jsonContent = json_decode($fileContent, true);
        }

        // Text preparation
        if (!empty($request->jsonText)) {
            $jsonContent = json_decode($fileContent, true);
        }

        if ($jsonContent) {
            // process calculation
            return $jsonContent;
        } else {
            throw new \Exception('Please provide JSON formatted text using file upload or in Text area');
        }
    }

    public function storeJsonFile(UploadedFile $uploadedFile) {
        $fileName = Carbon::now()->timestamp . '.json';

        return $uploadedFile->storeAs(
            'files', $fileName, 'local'
        );
    }
    
    public function validateJsonSchema($jsonArray) {
        $multiplied = $collection->map(function ($item, $key) {
            return $item * 2;
        });
    }
}