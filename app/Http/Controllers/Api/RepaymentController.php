<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Loan;
use App\Http\Resources\LoanResource;
use App\Repayment;

class RepaymentController extends Controller
{
    public function store(Request $request, Repayment $repay){
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        // check if current authenticated user is the owner of the loan
        if ($request->user()->id !== $repay->user_id){
            return response()->json(['message' => 'You can only repay your own loans.'], 403);
        }
        $loan = $repay->loan;
        if ($loan->status == 'Paid'){
            return response()->json(['message' => 'Your loan already paid.'], 403);
        }
        $repayment_amount =  $loan->amount - $loan->repayment()->sum('paid_amount');
        if ($repayment_amount < $request->amount){
            return response()->json(['message' => 'Your loan repayment amount should less than or equal to '.$repayment_amount], 403);
        }
        if ($repay->status != 'Paid'){
            $repay->paid_amount = $request->amount;
            if ($repay->amount <= $request->amount){
                // update repayment status to paid
                $repay->status = 'Paid';
            }
            $repay->save();
            $loan->paid_amount = $loan->repayment()->sum('paid_amount');
            $loan->save();

            if ($loan->repayment()->sum('paid_amount') >= $loan->amount){
                // update loan & all replyment status to paid
                $loan->repayment()->update(['status' => 'Paid']);
                $loan->status = 'Paid';
                $loan->paid_amount = $loan->repayment()->sum('paid_amount');
                $loan->save();
            }
            return new LoanResource($loan);
        }
        return response()->json(['message' => 'Your repayment is Paid.'], 403);
    }
}
