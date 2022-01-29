<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use App\Helpers\JsonResponse;
use App\Services\Loan\LoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    private $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    function create(Request $request){
        $validator = Validator::make($request->all(), [
            'loan_amount' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'loan_term' => 'required|integer|min:2'
        ]);
        if ($validator->fails()) {
            throw new BadRequestException($validator->errors()->first());
        }
        $loan = $this->loanService->create($request->all());
        return JsonResponse::success($loan);
    }


    public function statusByLoanNo(Request $request)
    {
        $this->validation($request->all());
        $status = $this->loanService->getStatus($request->loan_no);
        return JsonResponse::success($status);
    }

    public function detailByLoanNo(Request $request)
    {
        $this->validation($request->all());
        $loanData = $this->loanService->getByLoanNo($request->loan_no);
        if ($loanData) {
            return JsonResponse::success($loanData);
        }
        throw new BadRequestException("Loan no. doesn't matched or invalid.");
    }

    public function approve(Request $request)
    {
        $this->validation($request->all());
        $loanData = $this->loanService->approve($request->loan_no);
        if ($loanData) {
            return JsonResponse::success('Loan has been approved successfully.');
        }
        throw new BadRequestException("Could not approve loan at this moment, please try again later.");
    }


    public function loanPay(Request $request)
    {
        $this->validation($request->all());
        $repay = $this->loanService->rePay($request->loan_no);
        return JsonResponse::success($repay);
    }

    function validation($requestData)
    {
        $validator = Validator::make($requestData, [
            'loan_no' => 'required'
        ]);
        if ($validator->fails()) {
            throw new BadRequestException($validator->errors()->first());
        }
        return !$validator->fails();
    }


}
