<?php
namespace App\Repositories\Loan;

use App\Models\LoanPayment;
class PaymentRepository
{

    public function paymentListByLoanNo($loanNo)
    {
        return LoanPayment::where('loan_id', $loanNo)->get();
    }

    public function create($loanId){
        $repPay = new LoanPayment();
        $repPay->loan_id = $loanId;
        $repPay->tid = rand(999999, 9999999);
        $repPay->save();
        return $repPay;
    }
}
