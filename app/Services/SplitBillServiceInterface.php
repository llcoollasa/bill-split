<?php
namespace App\Services;

use Illuminate\Http\UploadedFile;

interface SplitBillServiceInterface
{
    public function prepareJsonArray($request);
    public function storeJsonFile(UploadedFile $uploadedFile);
    public function isJsonSchemaValid($json);
    public function getTotalDays();
    public function getTotalSpentAmount();
    public function getTotalAmountSpentByEachFriend();
    public function getEachFriendOwesAmount();
}