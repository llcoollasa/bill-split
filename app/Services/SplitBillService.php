<?php
namespace App\Services;

use App\Http\Requests\HandleUploadPost;
use Carbon\Carbon;
use Storage;

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

        if ($jsonContent) {
            // process calculation
            return $jsonContent;
        } else {
            throw new \Exception('Please provide JSON formatted text using file upload or in Text area');
        }
    }
}