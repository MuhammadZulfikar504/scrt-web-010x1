<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Collection;
use App\Models\DetailTransaction;
use App\Models\Transaction;

use Carbon\Carbon;
use DB;
use DataTables;

class DetailTransactionController extends Controller
{
    public function getDetailTransactions($id)
    {
        $data   = DB::table('detail_transactions')
                    ->select(
                        'detail_transactions.id',
                        'transactions.start_date as start_date',
                        'detail_transactions.end_date as end_date',
                        'detail_transactions.status as status_type',
                        DB::raw(
                            '(CASE
                                WHEN detail_transactions.status=1 THEN "Pinjam"
                                WHEN detail_transactions.status=2 THEN "Kembali"
                                WHEN detail_transactions.status=3 THEN "Hilang"
                            END)
                            as status'
                        ),
                        'collections.title as collection'
                    )
                    ->join('transactions', 'transactions.id', '=', 'detail_transactions.transaction_id')
                    ->join('collections', 'collections.id', '=', 'detail_transactions.collection_id')
                    ->where('transactions.id', '=', $id)
                    ->get();        

        return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function ($row){
                            if ($row->status_type == 1)
                            {
                                $actionBtn = '<a href="' . url('transactions/edit/' . $row->id) . '" class="btn btn-sm btn-info">Edit</a>';
                                return $actionBtn;
                            }
                        })
                        ->rawColumns(['action'])
                        ->make(true);
    }

    public function edit($id)
    {
        $data   = DB::table('detail_transactions')
                    ->select(
                        'transactions.id as transaction_id',
                        'detail_transactions.id as detail_transaction_id',
                        'transactions.start_date as start_date',
                        'detail_transactions.end_date as end_date',
                        'detail_transactions.status as status',
                        'user.fullname as user',
                        'employee.fullname as employee',
                        'collections.title as collection'
                    )
                    ->join('transactions', 'transactions.id', '=', 'detail_transactions.transaction_id')
                    ->join('collections', 'collections.id', '=', 'detail_transactions.collection_id')
                    ->join('users as user', 'transactions.user_id', '=', 'user.id')
                    ->join('users as employee', 'transactions.employee_id', '=', 'employee.id')
                    ->where('detail_transactions.id', '=', $id)
                    ->first();
                    
        return view('transactions.edit', compact('data'));
    }

    public function update(Request $req)
    {
        if ($req->status == 1) return redirect()->back();

        if ($req->status != 1)
        {
            DB::table('detail_transactions')
                ->where('id', $req->detail_transaction_id)
                ->update([
                    'status'    => $req->status,
                    'end_date'  => Carbon::now()->toDateString()
                ]);

            if ($req->status == 2)
            {
                DB::table('collections')->increment('remain_amount');
                DB::table('collections')->decrement('amount_borrowed');
            }
            else
            {
                DB::table('collections')->increment('remain_amount');
            }
        }

        $transaction = Transaction::where('id', '=', $req->transaction_id)->first();

        return redirect('transactions/show/' . $transaction->id)->with('transaction', $transaction);
    }
}
