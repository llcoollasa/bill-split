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

            $billSplitService->prepareJsonArray($jsonContent);
            $data['totalDays'] = $billSplitService->getTotalDays();
            $data['totalSpentAmount'] = $billSplitService->getTotalSpentAmount();
            $data['totalAmountForEach'] = $billSplitService->getTotalAmountSpentByEachFriend();
            $data['totalAmountOwesByEach'] = $billSplitService->getTotalOweAmountByEachFriend();
            $data['combinationOfTotalAmountOwesByEach'] = $billSplitService->getEachFriendOwesAmount();

            return view('bill.output', compact("data"));
        } catch (\Exception $ex) {
            return redirect('/')
                ->withErrors($ex->getMessage());
        }
    }
}
