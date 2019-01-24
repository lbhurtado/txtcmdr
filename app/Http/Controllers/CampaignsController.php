<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CampaignCreateRequest;
use App\Http\Requests\CampaignUpdateRequest;
use App\Campaign\Domain\Repositories\CampaignRepository;
use App\Campaign\Domain\Validators\CampaignValidator;

/**
 * Class CampaignsController.
 *
 * @package namespace App\Http\Controllers;
 */
class CampaignsController extends Controller
{
    /**
     * @var CampaignRepository
     */
    protected $repository;

    /**
     * @var CampaignValidator
     */
    protected $validator;

    /**
     * CampaignsController constructor.
     *
     * @param CampaignRepository $repository
     * @param CampaignValidator $validator
     */
    public function __construct(CampaignRepository $repository, CampaignValidator $validator)
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
        $campaigns = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $campaigns,
            ]);
        }

        return view('campaigns.index', compact('campaigns'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CampaignCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CampaignCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $campaign = $this->repository->create($request->all());

            $response = [
                'message' => 'Campaign created.',
                'data'    => $campaign->toArray(),
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
        $campaign = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $campaign,
            ]);
        }

        return view('campaigns.show', compact('campaign'));
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
        $campaign = $this->repository->find($id);

        return view('campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CampaignUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CampaignUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $campaign = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Campaign updated.',
                'data'    => $campaign->toArray(),
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
                'message' => 'Campaign deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Campaign deleted.');
    }
}
