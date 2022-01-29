<?php


namespace App\Repositories\Loan;


use App\Models\Loan;
use App\Models\LoanPayment;

class LoanRepository
{

    public function create($data, $userId){
        //Calculate emi basis of  7% interest
        $emi =  $data['loan_amount'] * 7 * (pow(8, $data['loan_term'])
                / (pow(8, $data['loan_term']) - 1));
        $loan = new Loan();
        $loan->user_id = $userId;
        $loan->loan_no = rand(99999, 999999);
        $loan->loan_amount = $data['loan_amount'];
        $loan->loan_term = $data['loan_term'];
        $loan->loan_emi = number_format($emi, 2, '.', '');
        $loan->save();
        return $loan;
    }

    public function getByLoanNo($loanNo){
        return Loan::where('loan_no', $loanNo)->first();
    }

    public function getApprovedByLoanNo($loanNo){
        return Loan::where(['loan_no' => $loanNo, 'status'=>'approved'])->first();
    }

    public function approve($loanNo){
        return Loan::where('loan_no', $loanNo)->update(['status'=>'approved']);
    }

    public function getCustomerLoan($loanNo, $userId){
        return Loan::where(['loan_no' => $loanNo, 'user_id'=>$userId])->first();
    }

    public function close($loanId)
    {
        $loanData = Loan::find($loanId);
        $loanData->status = "closed";
        $loanData->save();
        return $loanData;
    }

}
