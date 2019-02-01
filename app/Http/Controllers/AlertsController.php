<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AlertCreateRequest;
use App\Http\Requests\AlertUpdateRequest;
use App\Campaign\Domain\Repositories\AlertRepository;
use App\Campaign\Domain\Validators\AlertValidator;

/**
 * Class AlertsController.
 *
 * @package namespace App\Http\Controllers;
 */
class AlertsController extends Controller
{
    /**
     * @var AlertRepository
     */
    protected $repository;

    /**
     * @var AlertValidator
     */
    protected $validator;

    /**
     * AlertsController constructor.
     *
     * @param AlertRepository $repository
     * @param AlertValidator $validator
     */
    public function __construct(AlertRepository $repository, AlertValidator $validator)
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
        $alerts = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $alerts,
            ]);
        }

        return view('alerts.index', compact('alerts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AlertCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(AlertCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $alert = $this->repository->create($request->all());

            $response = [
                'message' => 'Alert created.',
                'data'    => $alert->toArray(),
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
        $alert = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $alert,
            ]);
        }

        return view('alerts.show', compact('alert'));
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
        $alert = $this->repository->find($id);

        return view('alerts.edit', compact('alert'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AlertUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(AlertUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $alert = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Alert updated.',
                'data'    => $alert->toArray(),
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
                'message' => 'Alert deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Alert deleted.');
    }
}
