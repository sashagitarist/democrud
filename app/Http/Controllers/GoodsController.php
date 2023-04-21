<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goods = Goods::paginate(10);
        return view('goods.index')->with('goods', $goods);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('goods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric|min:0',
        ]);

        $goods = new Goods();
        $goods->product_name = $validatedData['name'];
        $goods->product_price = $validatedData['price'];
        $goods->save();

        return redirect()->route('goods.index')->with('success', 'Товар успешно добавлен.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Goods $goods)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($goods)
    {
        $goods = Goods::find($goods);
        return view('goods.edit', compact('goods'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $goods)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric|min:0',
        ]);
        $goods = Goods::find($goods);
        $goods->product_name = $validatedData['name'];
        $goods->product_price = $validatedData['price'];
        $goods->save();
        return redirect()->route('goods.index')->with('success', 'Товар успешно обновлен!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($goods)
    {
        $goods = Goods::find($goods);
        $goods->delete();
        return redirect()->route('goods.index')->with('success', 'Товар удален.');
    }
}
