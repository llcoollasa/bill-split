<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
class SplitBillService implements SplitBillServiceInterface
{
    // TODO: Handlle following methods
    // Total number of days
    // Total amount spent by all friends
    // How much each friend has spent. (If I bring someone outside of the circle, then it comes under my account )
    // How much each user owes. (If there are minus values the ignore them)
    // Automatically generated a settlement combination. 

    private $jsonArray = [];

    public function calculate($jsonContent)
    {
        // process calculation
        if ($jsonContent) {
            if ($this->isJsonSchemaValid($jsonContent)) {
                $this->jsonArray = collect(json_decode($jsonContent, true)['data']);
                return $this->jsonArray;
            }
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
    
    public function isJsonSchemaValid($json) {
        try {
            $jsonContent = json_decode($json, true);

            if (!isset($jsonContent['data'])) return false;

            $validItems = collect($jsonContent['data'])->map(function ($item) {
                // validate day
                if (!isset($item['day']) || empty($item['day'])) return false;
                
                // validate amount
                if (!isset($item['amount']) || empty($item['amount'])) return false;

                // validate paid_by
                if (!isset($item['paid_by']) || empty($item['paid_by'])) return false;

                // validate friends
                if (!isset($item['friends']) || empty($item['friends'])) return false;
 
                 
                $fValid = true;
                foreach ($item['friends'] as $friend) {
                    if (empty($friend))  { 
                        $fValid = false;  
                        break;
                    } 
                } 

                
                return ($fValid ) ? true : false;
            });

            $valid = $validItems->reduce(function ($carry, $item) {
                return $carry && $item;
            }, true);
            
            return $valid;
            
        } catch (\Exception $ex) {
            throw new \Exception('Please provide valid JSON');
        }
    }

    public function getTotalDays() { 
        return count($this->jsonArray);
    }
}