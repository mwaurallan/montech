<?php

namespace App\Http\Controllers;

use App\DataTables\LoanRepaymetReceiptDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLoanRepaymetReceiptRequest;
use App\Http\Requests\UpdateLoanRepaymetReceiptRequest;
use App\Models\Loan;
use App\Models\LoanRepaymetReceipt;
use App\Repositories\LoanRepaymetReceiptRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class LoanRepaymetReceiptController extends AppBaseController
{
    /** @var  LoanRepaymetReceiptRepository */
    private $loanRepaymetReceiptRepository;

    public function __construct(LoanRepaymetReceiptRepository $loanRepaymetReceiptRepo)
    {
        $this->loanRepaymetReceiptRepository = $loanRepaymetReceiptRepo;
    }

    /**
     * Display a listing of the LoanRepaymetReceipt.
     *
     * @param LoanRepaymetReceiptDataTable $loanRepaymetReceiptDataTable
     * @return Response
     */
    public function index(LoanRepaymetReceiptDataTable $loanRepaymetReceiptDataTable)
    {

        return $loanRepaymetReceiptDataTable->render('loan_repaymet_receipts.index',[
//            'loans' =>
        ]);
    }

    public function getReceipt($id){
        $loans = Loan::where('borrower_id', $id)->orderBy('release_date', 'asc')
            ->with('loan_product')
            ->get();
        return response()->json($loans);
    }

    /**
     * Show the form for creating a new LoanRepaymetReceipt.
     *
     * @return Response
     */
    public function create()
    {
        return view('loan_repaymet_receipts.create');
    }

    /**
     * Store a newly created LoanRepaymetReceipt in storage.
     *
     * @param CreateLoanRepaymetReceiptRequest $request
     *
     * @return Response
     */
    public function store(CreateLoanRepaymetReceiptRequest $request)
    {
        $input = $request->all();

        $loanRepaymetReceipt = $this->loanRepaymetReceiptRepository->create($input);

        Flash::success('Loan Repaymet Receipt saved successfully.');

        return redirect(route('loanRepaymetReceipts.index'));
    }

    /**
     * Display the specified LoanRepaymetReceipt.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $loanRepaymetReceipt = $this->loanRepaymetReceiptRepository->find($id);

        if (empty($loanRepaymetReceipt)) {
            Flash::error('Loan Repaymet Receipt not found');

            return redirect(route('loanRepaymetReceipts.index'));
        }

        return view('loan_repaymet_receipts.show')->with('loanRepaymetReceipt', $loanRepaymetReceipt);
    }

    /**
     * Show the form for editing the specified LoanRepaymetReceipt.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $loanRepaymetReceipt = $this->loanRepaymetReceiptRepository->find($id);

        if (empty($loanRepaymetReceipt)) {
            Flash::error('Loan Repaymet Receipt not found');

            return redirect(route('loanRepaymetReceipts.index'));
        }

        return view('loan_repaymet_receipts.edit')->with('loanRepaymetReceipt', $loanRepaymetReceipt);
    }

    /**
     * Update the specified LoanRepaymetReceipt in storage.
     *
     * @param  int              $id
     * @param UpdateLoanRepaymetReceiptRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoanRepaymetReceiptRequest $request)
    {
        $loanRepaymetReceipt = $this->loanRepaymetReceiptRepository->find($id);

        if (empty($loanRepaymetReceipt)) {
            Flash::error('Loan Repaymet Receipt not found');

            return redirect(route('loanRepaymetReceipts.index'));
        }

        $loanRepaymetReceipt = $this->loanRepaymetReceiptRepository->update($request->all(), $id);

        Flash::success('Loan Repaymet Receipt updated successfully.');

        return redirect(route('loanRepaymetReceipts.index'));
    }

    /**
     * Remove the specified LoanRepaymetReceipt from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $loanRepaymetReceipt = $this->loanRepaymetReceiptRepository->find($id);

        if (empty($loanRepaymetReceipt)) {
            Flash::error('Loan Repaymet Receipt not found');

            return redirect(route('loanRepaymetReceipts.index'));
        }

        $this->loanRepaymetReceiptRepository->delete($id);

        Flash::success('Loan Repaymet Receipt deleted successfully.');

        return redirect(route('loanRepaymetReceipts.index'));
    }
}
