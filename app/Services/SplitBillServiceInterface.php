<?php
namespace App\Services;
use App\Http\Requests\HandleUploadPost;
interface SplitBillServiceInterface
{
    public function calculate(HandleUploadPost $request);
}