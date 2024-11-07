<?php

namespace App\Http\Controllers;

use App\Models\ChurchGood;
use App\Models\Category;
use Illuminate\Http\Request;

class ChurchGoodController extends Controller
{
    public function index()
    {
        $churchGoods = ChurchGood::with('category')->get();
        return view('church_goods.index', compact('churchGoods'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('church_goods.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        ChurchGood::create($request->all());

        return redirect()->route('church_goods.index')->with('success', 'Church good created successfully.');
    }

    public function show($id)
    {
        $churchGood = ChurchGood::with('category')->findOrFail($id);
        return view('church_goods.show', compact('churchGood'));
    }

    public function edit($id)
    {
        $churchGood = ChurchGood::findOrFail($id);
        $categories = Category::all();
        return view('church_goods.edit', compact('churchGood', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $churchGood = ChurchGood::findOrFail($id);
        $churchGood->update($request->all());

        return redirect()->route('church_goods.index')->with('success', 'Church good updated successfully.');
    }

    public function destroy($id)
    {
        $churchGood = ChurchGood::findOrFail($id);
        $churchGood->delete();

        return redirect()->route('church_goods.index')->with('success', 'Church good deleted successfully.');
    }
}

