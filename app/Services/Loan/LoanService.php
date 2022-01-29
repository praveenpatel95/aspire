<?php


namespace App\Services\Loan;


use App\Exceptions\BadRequestException;
use App\Helpers\JsonResponse;
use App\Repositories\Loan\LoanRepository;
use App\Repositories\Loan\PaymentRepository;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

class LoanService
{
    private $loanRepository, $paymentRepository;

    public function __construct(LoanRepository $loanRepositroy, PaymentRepository $paymentRepository)
    {
        $this->loanRepository = $loanRepositroy;
        $this->paymentRepository = $paymentRepository;
    }


    public function create($data){
        try{
            return $this->loanRepository->create($data, Auth::id());
        }catch (\Exception $e){
            throw new BadRequestException($e->getMessage());
        }
    }

    public function getByLoanNo($loanNo)
    {
        return $this->loanRepository->getByLoanNo($loanNo);
    }

    public function approve($loanNo)
    {
        $loan = $this->loanRepository->getApprovedByLoanNo($loanNo);
        if (!$loan) {
            return $this->loanRepository->approve($loanNo);
        }

        throw new BadRequestException('Loan has been already approved');
    }

    public function getStatus($loanNo)
    {
        $loan = $this->loanRepository->getCustomerLoan($loanNo, Auth::id());
        if ($loan) {
            return $loan->status;
        }
        throw new BadRequestException('Invalid loan no.');
    }

    public function rePay($loanNo)
    {
        $loanData = $this->loanRepository->getCustomerLoan($loanNo, Auth::id());
        if ($loanData && $loanData->status == 'approved') {
            $payment = $this->paymentRepository->create($loanData->id);
            //check if all payment done
            $paidCount = $this->paymentRepository->paymentListByLoanNo($loanData->id)->count();
            if($paidCount == $loanData->loan_term){
                //close the loan
                $this->loanRepository->close($loanData->id);
                return "congratulations! Your loan has been closed";
            }
            return "Payment has been paid successfully.";
        }
        throw new BadRequestException('Loan is not approved yet.');
    }

}
