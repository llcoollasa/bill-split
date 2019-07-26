<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class FileTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFileUpload()
    {
        Storage::fake('avatars');
        $json = UploadedFile::fake()->create('document.json', 10);
        
        $response = $this->json('POST', '/upload', [
            'file' => $json
        ]);

        // Assert the file was stored...
        Storage::disk('local')->assertExists('/files/document.json');

        // Assert a file does not exist...
        Storage::disk('local')->assertMissing('/files/document.json');
    }
}
