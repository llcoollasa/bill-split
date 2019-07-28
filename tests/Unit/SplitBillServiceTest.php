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
    private function getJsonData($rest = '') {
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
            '. $rest .'
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
    
    public function test_validate_json_schema_should_be_valid() {
      $splitBillService = new SplitBillService();
      $this->assertTrue($splitBillService->isJsonSchemaValid($this->getJsonData()));
    }

    public function test_validate_json_schema_should_be_invalid() {
      $splitBillService = new SplitBillService();      
      $this->assertFalse($splitBillService->isJsonSchemaValid('{}'));
    }

    public function test_get_total_days() {
      $splitBillService = new SplitBillService(); 
      $splitBillService->prepareJsonArray($this->getJsonData());
      $this->assertEquals($splitBillService->getTotalDays(), 3);
    }

    public function test_get_total_amount_spent() {
      $splitBillService = new SplitBillService(); 
      $splitBillService->prepareJsonArray($this->getJsonData());
      $this->assertEquals($splitBillService->getTotalSpentAmount(), 250);
    }

    public function test_get_total_amount_spent_by_each_friend() {
      $splitBillService = new SplitBillService(); 
      $splitBillService->prepareJsonArray($this->getJsonData());

      $expectedArray = [
        "tanu" => 50,
        "kasun" => 100,
        "liam" => 100
      ];
      
      $this->assertEquals($splitBillService->getTotalAmountSpentByEachFriend(), $expectedArray);
    }
    
    public function test_get_total_amount_spent_by_each_friend_with_duplicate_names() {
      $splitBillService = new SplitBillService(); 
      $splitBillService->prepareJsonArray($this->getJsonData(', {
        "day": 4,
        "amount": 150,
        "paid_by": "liam",
        "friends": [
          "liam",
          "tanu",
          "liam"
        ]
      }'));

      $expectedArray = [
        "tanu" => 50,
        "kasun" => 100,
        "liam" => 250
      ];
      
      $this->assertEquals($splitBillService->getTotalAmountSpentByEachFriend(), $expectedArray);
    }

    public function test_combination_of_each_friend_owes_amount() {
      $splitBillService = new SplitBillService(); 
      $splitBillService->prepareJsonArray($this->getJsonData());

      $expectedArray = [
        "kasun" => [
          "tanu" => 25.0
        ],
        "tanu" => [
          "kasun" => 33.33,
          "liam" => 33.33
        ],
        "liam" => [
          "kasun" => 33.33
        ]  
      ];

      $this->assertEquals($splitBillService->getEachFriendOwesAmount(), $expectedArray);
    }

    public function test_each_friend_owes_amount() {
      $splitBillService = new SplitBillService(); 
      $splitBillService->prepareJsonArray($this->getJsonData());

      $expectedArray = [
        "kasun" => 25.0,
        "tanu" => 66.66,
        "liam" => 33.33 
      ];

      $this->assertEquals($splitBillService->getTotalOweAmountByEachFriend(), $expectedArray);
    }
}
