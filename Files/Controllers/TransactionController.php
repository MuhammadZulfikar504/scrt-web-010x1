<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Collection;
use App\Models\DetailTransaction;
use App\Models\Transaction;
use App\Models\User;

use Carbon\Carbon;
use DB;
use DataTables;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transactions.index');
    }

    public function getTransactions(Request $req)
    {
        if ($req->ajax())
        {
            $transactions   = DB::table('transactions')
                                ->select(
                                    'transactions.id as id',
                                    'user.fullname as user',
                                    'employee.fullname as employee',
                                    'transactions.start_date as start_date',
                                    'transactions.end_date as end_date',
                                )
                                ->join('users as employee', 'employee_id', '=', 'employee.id')
                                ->join('users as user', 'user_id', '=', 'user.id')
                                ->orderBy('transactions.start_date', 'asc')
                                ->get();

            return Datatables::of($transactions)
                            ->addIndexColumn()
                            ->addColumn('action', function ($row){
                                $actionBtn = '<a href="transactions/show/' . $row->id . '" class="btn btn-sm btn-info">Detail</a>';
                                return $actionBtn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
        }
    }

    public function create()
    {
        $collections    = Collection::orderBy('title', 'asc')->get();
        $users          = User::orderBy('fullname', 'asc')->get();

        return view('transactions.create', compact('collections', 'users'));
    }

    public function store(Request $req)
    {
        $req->validate(
        [
            'user_id'               => 'required|integer',
            'collection_0'          => 'required|integer',
            'collection_1'          => 'integer',
            'collection_2'          => 'integer',
        ],
        [
            'user_id.required'      => 'Select at least one user.',
            'collection_0.required' => 'Select at least one collection.'
        ]);

        $transaction                        = new Transaction();
        $transaction->employee_id           = $req->employee_id;
        $transaction->user_id               = $req->user_id;
        $transaction->start_date            = Carbon::now()->toDateString();
        $transaction->employee_id           = $req->employee_id;
        $transaction->save();

        $detailTransaction0                 = new DetailTransaction();
        $detailTransaction0->transaction_id = $transaction->id;
        $detailTransaction0->collection_id  = $req->collection_0;
        $detailTransaction0->status         = 1;
        $detailTransaction0->save();

        DB::table('collections')->where('id', $req->collection_0)->decrement('remain_amount');
        DB::table('collections')->where('id', $req->collection_0)->increment('amount_borrowed');

        if ($req->collection_1 > 0)
        {
            $detailTransaction1                 = new DetailTransaction();
            $detailTransaction1->transaction_id = $transaction->id;
            $detailTransaction1->collection_id  = $req->collection_1;
            $detailTransaction1->status         = 1;
            $detailTransaction1->save();

            DB::table('collections')->where('id', $req->collection_1)->decrement('remain_amount');
            DB::table('collections')->where('id', $req->collection_1)->increment('amount_borrowed');
        }

        if ($req->collection_2 > 0)
        {
            $detailTransaction2                 = new DetailTransaction();
            $detailTransaction2->transaction_id = $transaction->id;
            $detailTransaction2->collection_id  = $req->collection_2;
            $detailTransaction2->status         = 1;
            $detailTransaction2->save();

            DB::table('collections')->where('id', $req->collection_2)->decrement('remain_amount');
            DB::table('collections')->where('id', $req->collection_2)->increment('amount_borrowed');
        }

        return redirect('transactions');
    }

    public function show($id)
    {
        $transaction = DB::table('transactions')
                        ->select(
                            'transactions.id as id',
                            'user.fullname as user',
                            'employee.fullname as employee',
                            'transactions.start_date as start_date',
                            'transactions.end_date as end_date',
                        )
                        ->join('users as employee', 'employee_id', '=', 'employee.id')
                        ->join('users as user', 'user_id', '=', 'user.id')
                        ->where('transactions.id', '=', $id)
                        ->orderBy('transactions.start_date', 'asc')
                        ->first();
        
        return view('transactions.show', compact('transaction'));
    }
}
