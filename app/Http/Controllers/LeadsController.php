<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\LeadCreateRequest;
use App\Http\Requests\LeadUpdateRequest;
use App\Campaign\Domain\Repositories\LeadRepository;
use App\Campaign\Domain\Validators\LeadValidator;

/**
 * Class LeadsController.
 *
 * @package namespace App\Http\Controllers;
 */
class LeadsController extends Controller
{
    /**
     * @var LeadRepository
     */
    protected $repository;

    /**
     * @var LeadValidator
     */
    protected $validator;

    /**
     * LeadsController constructor.
     *
     * @param LeadRepository $repository
     * @param LeadValidator $validator
     */
    public function __construct(LeadRepository $repository, LeadValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $appCampaignDomainModelsLeads = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $appCampaignDomainModelsLeads,
            ]);
        }

        return view('appCampaignDomainModelsLeads.index', compact('appCampaignDomainModelsLeads'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LeadCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(LeadCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $appCampaignDomainModelsLead = $this->repository->create($request->all());

            $response = [
                'message' => 'Lead created.',
                'data'    => $appCampaignDomainModelsLead->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appCampaignDomainModelsLead = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $appCampaignDomainModelsLead,
            ]);
        }

        return view('appCampaignDomainModelsLeads.show', compact('appCampaignDomainModelsLead'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $appCampaignDomainModelsLead = $this->repository->find($id);

        return view('appCampaignDomainModelsLeads.edit', compact('appCampaignDomainModelsLead'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LeadUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(LeadUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $appCampaignDomainModelsLead = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Lead updated.',
                'data'    => $appCampaignDomainModelsLead->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Lead deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Lead deleted.');
    }
}
