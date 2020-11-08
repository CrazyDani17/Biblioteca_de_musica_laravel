<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Backpack\NewsCRUD\app\Models\Address;
use App\Models\Address;

class AddressController extends Controller
{
    public function index(Request $request)
    {
        $search_term = $request->input('q');
        $form = collect($request->input('form'))->pluck('value', 'name');
        $options = Address::query();

        if (! $form['customer_id']) {
            return [];
        }

        // if a category has been selected, only show articles in that category
        if ($form['customer_id']) {
            $options = $options->where('customer_id', $form['customer_id']);
        }

        // if a search term has been given, filter results to match the search term
        if ($search_term) {
            $results = $options->where('address', 'LIKE', '%'.$search_term.'%')->paginate(10);
        } else {
            $results = $options->paginate(10);
        }

        return $options->paginate(10);
    }

    public function show($id)
    {
        return Address::find($id);
    }
}