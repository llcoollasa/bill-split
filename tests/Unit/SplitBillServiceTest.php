<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use App\Services\SplitBillService;

class FileTest extends TestCase
{
    private function getJsonData() {
        return '
        {
          "data": [
            {
              "day": 1,
              "amount": 50,
              "paid_by": "tanu",
              "friends": [
                "kasun",
                "tanu"
              ]
            },
            {
              "day": 2,
              "amount": 100,
              "paid_by": "kasun",
              "friends": [
                "kasun",
                "tanu",
                "liam"
              ]
            },
            {
              "day": 3,
              "amount": 100,
              "paid_by": "liam",
              "friends": [
                "liam",
                "tanu",
                "liam"
              ]
            }
          ]
        }
      ';
    }

    public function test_store_json_file()
    {
        $knownDate = Carbon::create(2001, 5, 21, 12);
        Carbon::setTestNow($knownDate);

        $fileName = '990446400.json';
        $fileSize = 200;

        Storage::fake('local');
        $json = UploadedFile::fake()->create($fileName, $fileSize);
        
        $splitBillService = new SplitBillService();
        $splitBillService->storeJsonFile($json);
        Storage::disk('local')->assertExists('files/'. $fileName);
    }
}
