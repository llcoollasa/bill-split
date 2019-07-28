<?php

namespace App\Http\Controllers;

use App\Http\Requests\HandleUploadPost;
use App\Services\SplitBillServiceInterface;

class BillController extends Controller
{
    public function handleUpload(HandleUploadPost $request, SplitBillServiceInterface $billSplitService) {
        try {
            $response = $billSplitService->calculate($request);

            // test
            return ($response);
        } catch (\Exception $ex) {
            return redirect('/')
                ->withErrors($ex->getMessage());
        }
    }
}
