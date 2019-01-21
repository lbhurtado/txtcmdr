<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AirtimeCreateRequest;
use App\Http\Requests\AirtimeUpdateRequest;
use App\Charging\Domain\Repositories\AirtimeRepository;
use App\Charging\Domain\Validators\AirtimeValidator;

/**
 * Class AirtimesController.
 *
 * @package namespace App\Http\Controllers;
 */
class AirtimesController extends Controller
{
    /**
     * @var AirtimeRepository
     */
    protected $repository;

    /**
     * @var AirtimeValidator
     */
    protected $validator;

    /**
     * AirtimesController constructor.
     *
     * @param AirtimeRepository $repository
     * @param AirtimeValidator $validator
     */
    public function __construct(AirtimeRepository $repository, AirtimeValidator $validator)
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
        $airtimes = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $airtimes,
            ]);
        }

        return view('airtimes.index', compact('airtimes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AirtimeCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(AirtimeCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $airtime = $this->repository->create($request->all());

            $response = [
                'message' => 'Airtime created.',
                'data'    => $airtime->toArray(),
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
        $airtime = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $airtime,
            ]);
        }

        return view('airtimes.show', compact('airtime'));
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
        $airtime = $this->repository->find($id);

        return view('airtimes.edit', compact('airtime'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AirtimeUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(AirtimeUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $airtime = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Airtime updated.',
                'data'    => $airtime->toArray(),
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
                'message' => 'Airtime deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Airtime deleted.');
    }
}
