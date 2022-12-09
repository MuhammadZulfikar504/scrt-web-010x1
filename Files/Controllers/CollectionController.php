<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Collection;

use DataTables;

class CollectionController extends Controller
{
    public function index()
    {
        return view('collections.index');
    }

    public function getCollections(Request $req)
    {
        if ($req->ajax())
        {
            $data = Collection::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row)
                    {
                        $actionBtn = '<a href="collections/show/' . $row->id . '" class="btn btn-sm btn-info">Info</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function create()
    {
        return view('collections.create');
    }

    public function store(Request $req)
    {
        $req->validate([
            'title' => ['required', 'string', 'max:100'],
            'type' => ['required'],
            'quantity' => ['required', 'numeric'],
        ],
        [
            'title.required' => 'Username must be filled.',
            'type.required' => 'Type must be filled.',
            'quantity.required' => 'Quantity must be filled.',
        ]);

        Collection::create([
            'title' => $req->title,
            'type' => $req->type,
            'initial_amount' => $req->quantity,
            'remain_amount' => $req->quantity,
            'amount_borrowed' => 0,
        ]);

        return redirect('collections');
    }

    public function show($id)
    {
        $collection = Collection::findOrFail($id);

        return view('collections.show', compact('collection'));
    }

    public function update(Request $req)
    {
        $req->validate([
            'type' => ['required'],
            'remain_amount' => ['required', 'numeric', 'gt:0'],
            'amount_borrowed' => ['required', 'numeric', 'gt:0'],
        ],
        [
            'title.required' => 'Username must be filled.',
            'type.required' => 'Type must be filled.',
        ]);

        $collection                     = Collection::findOrFail($req->id);
        $collection->type               = $req->type;
        $collection->remain_amount      = $req->remain_amount;
        $collection->amount_borrowed    = $req->amount_borrowed;
        $collection->save();

        return redirect('collections');
    }
}
