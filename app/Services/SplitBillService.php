<?php
namespace App\Services;

use App\Http\Requests\HandleUploadPost;
use Carbon\Carbon;
use Storage;

class SplitBillService implements SplitBillServiceInterface
{
    public function calculate(HandleUploadPost $request)
    {
        $jsonContent = null;
        // File preparation
        if ($request->hasFile('jsonFile')) { 
            $fileName   = Carbon::now()->timestamp . '.json';
             
            $path = $request->file('jsonFile')->storeAs(
                'files', $fileName, 'local'
            );
            
            $fileContent = Storage::get($path);

            $jsonContent = json_decode($fileContent, true);

            
        }

        // Text preparation
        if (!empty($request->jsonText)) {
            $jsonContent = json_decode($fileContent, true);
        }

        if (empty($jsonContent)) {
            throw new \Exception('Please provide JSON formatted text using file upload or in Text area');
        }
    }
}