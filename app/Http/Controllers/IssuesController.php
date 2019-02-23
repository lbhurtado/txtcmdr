<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\IssueCreateRequest;
use App\Http\Requests\IssueUpdateRequest;
use App\Campaign\Domain\Repositories\IssueRepository;
use App\Campaign\Domain\Validators\IssueValidator;

/**
 * Class IssuesController.
 *
 * @package namespace App\Http\Controllers;
 */
class IssuesController extends Controller
{
    /**
     * @var IssueRepository
     */
    protected $repository;

    /**
     * @var IssueValidator
     */
    protected $validator;

    /**
     * IssuesController constructor.
     *
     * @param IssueRepository $repository
     * @param IssueValidator $validator
     */
    public function __construct(IssueRepository $repository, IssueValidator $validator)
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
        $issues = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $issues,
            ]);
        }

        return view('issues.index', compact('issues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  IssueCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(IssueCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $issue = $this->repository->create($request->all());

            $response = [
                'message' => 'Issue created.',
                'data'    => $issue->toArray(),
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
        $issue = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $issue,
            ]);
        }

        return view('issues.show', compact('issue'));
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
        $issue = $this->repository->find($id);

        return view('issues.edit', compact('issue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  IssueUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(IssueUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $issue = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Issue updated.',
                'data'    => $issue->toArray(),
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
                'message' => 'Issue deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Issue deleted.');
    }
}
