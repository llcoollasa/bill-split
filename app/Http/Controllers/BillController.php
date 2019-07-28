<?php

namespace App\Http\Controllers;

use App\Http\Requests\HandleUploadPost;
use App\Services\SplitBillServiceInterface;
use Storage;

class BillController extends Controller
{
    public function handleUpload(HandleUploadPost $request, SplitBillServiceInterface $billSplitService) {
        try {
            $jsonContent = null;
            // File preparation
            if ($request->hasFile('jsonFile')) {
                $jsonContent = Storage::get($billSplitService->storeJsonFile($request->file('jsonFile')));
            }

            // Assumption: For the moment File upload get override by Text Area.
            // Text preparation
            if (!empty($request->jsonText)) {
                $jsonContent = $request->jsonText;
            }
            $response = $billSplitService->calculate($jsonContent);

            // test
            return \Response::json($response);
        } catch (\Exception $ex) {
            return redirect('/')
                ->withErrors($ex->getMessage());
        }
    }
}
