<?php

namespace App\Http\Controllers;

use App\DataTables\SaccoDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSaccoRequest;
use App\Http\Requests\UpdateSaccoRequest;
use App\Repositories\SaccoRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SaccoController extends AppBaseController
{
    /** @var  SaccoRepository */
    private $saccoRepository;

    public function __construct(SaccoRepository $saccoRepo)
    {
        $this->middleware(['sentinel', 'branch']);
        $this->saccoRepository = $saccoRepo;
    }

    /**
     * Display a listing of the Sacco.
     *
     * @param SaccoDataTable $saccoDataTable
     * @return Response
     */
    public function index(SaccoDataTable $saccoDataTable)
    {
        return $saccoDataTable->render('saccos.index');
    }

    /**
     * Show the form for creating a new Sacco.
     *
     * @return Response
     */
    public function create()
    {
        return view('saccos.create');
    }

    /**
     * Store a newly created Sacco in storage.
     *
     * @param CreateSaccoRequest $request
     *
     * @return Response
     */
    public function store(CreateSaccoRequest $request)
    {
        $input = $request->all();

        $sacco = $this->saccoRepository->create($input);

        Flash::success('Sacco saved successfully.');

        return redirect(route('saccos.index'));
    }

    /**
     * Display the specified Sacco.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $sacco = $this->saccoRepository->findWithoutFail($id);

        if (empty($sacco)) {
            Flash::error('Sacco not found');

            return redirect(route('saccos.index'));
        }

        return view('saccos.show')->with('sacco', $sacco);
    }

    /**
     * Show the form for editing the specified Sacco.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $sacco = $this->saccoRepository->findWithoutFail($id);

        if (empty($sacco)) {
            Flash::error('Sacco not found');

            return redirect(route('saccos.index'));
        }

        return view('saccos.edit')->with('sacco', $sacco);
    }

    /**
     * Update the specified Sacco in storage.
     *
     * @param  int              $id
     * @param UpdateSaccoRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSaccoRequest $request)
    {
        $sacco = $this->saccoRepository->findWithoutFail($id);

        if (empty($sacco)) {
            Flash::error('Sacco not found');

            return redirect(route('saccos.index'));
        }

        $sacco = $this->saccoRepository->update($request->all(), $id);

        Flash::success('Sacco updated successfully.');

        return redirect(route('saccos.index'));
    }

    /**
     * Remove the specified Sacco from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $sacco = $this->saccoRepository->findWithoutFail($id);

        if (empty($sacco)) {
            Flash::error('Sacco not found');

            return redirect(route('saccos.index'));
        }

        $this->saccoRepository->delete($id);

        Flash::success('Sacco deleted successfully.');

        return redirect(route('saccos.index'));
    }
}
