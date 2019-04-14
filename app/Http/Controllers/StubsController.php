<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\StubCreateRequest;
use App\Http\Requests\StubUpdateRequest;
use App\Campaign\Domain\Repositories\StubRepository;
use App\Campaign\Domain\Validators\StubValidator;

/**
 * Class StubsController.
 *
 * @package namespace App\Http\Controllers;
 */
class StubsController extends Controller
{
    /**
     * @var StubRepository
     */
    protected $repository;

    /**
     * @var StubValidator
     */
    protected $validator;

    /**
     * StubsController constructor.
     *
     * @param StubRepository $repository
     * @param StubValidator $validator
     */
    public function __construct(StubRepository $repository, StubValidator $validator)
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
        $stubs = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $stubs,
            ]);
        }

        return view('stubs.index', compact('stubs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StubCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(StubCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $stub = $this->repository->create($request->all());

            $response = [
                'message' => 'Stub created.',
                'data'    => $stub->toArray(),
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
        $stub = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $stub,
            ]);
        }

        return view('stubs.show', compact('stub'));
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
        $stub = $this->repository->find($id);

        return view('stubs.edit', compact('stub'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StubUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(StubUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $stub = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Stub updated.',
                'data'    => $stub->toArray(),
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
                'message' => 'Stub deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Stub deleted.');
    }
}
