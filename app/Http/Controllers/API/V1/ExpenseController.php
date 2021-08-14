<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Expenses\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends BaseController
{

    protected $expense = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Expense $expense)
    {
        $this->middleware('auth:api');
        $this->expense = $expense;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth()->user()->isUser()) {
            $expenses = $this->expense->latest()->with('category')->where('user_id', Auth()->user()->id)->paginate(10);
        } else {
            $expenses = $this->expense->latest()->with('category')->paginate(10);
        }
        return $this->sendResponse($expenses, 'Expense list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Expenses\ExpenseRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        $expense = $this->expense->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'category_id' => $request->get('category_id'),
            'user_id' => Auth()->user()->id,
        ]);

        return $this->sendResponse($expense, 'Expense Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = $this->expense->with(['category', 'tags'])->findOrFail($id);

        return $this->sendResponse($expense, 'Expense Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */

    public function update(ExpenseRequest $request, $id)
    {
        $expense = $this->expense->findOrFail($id);

        $expense->update($request->all());

        return $this->sendResponse($expense, 'Expense Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $expense = $this->expense->findOrFail($id);

        $expense->delete();

        return $this->sendResponse($expense, 'Expense has been Deleted');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}
