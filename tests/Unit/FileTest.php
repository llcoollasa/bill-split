<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;

class FileTest extends TestCase
{
    public function testFileUpload()
    {
        $knownDate = Carbon::create(2001, 5, 21, 12);
        Carbon::setTestNow($knownDate);

        $fileName = '990446400.json';
        $fileSize = 200;

        Storage::fake('local');
        $json = UploadedFile::fake()->create($fileName, $fileSize);
        
        $response = $this->json('POST', '/upload', [
            'jsonFile' => $json
        ]);
        
        Storage::disk('local')->assertExists('files/'. $fileName);
    }

    public function validateJsonText()
    {
        $knownDate = Carbon::create(2001, 5, 21, 12);
        Carbon::setTestNow($knownDate);

        $fileName = '990446400.json';
        $fileSize = 200;

        Storage::fake('local');
        $json = UploadedFile::fake()->create($fileName, $fileSize);
        
        $response = $this->json('POST', '/upload', [
            'jsonFile' => $json
        ]);
        
        Storage::disk('local')->assertExists('files/'. $fileName);
    }
}
