<?php

namespace App\Http\Controllers;

use App\Models\Goods;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Factory|Application|View|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $orders = Order::query();

        if ($request->has('date')) {
            $orders->whereDate('order_date', $request->get('date'));
        }

        if (request()->ajax()) {
            $orders = $orders->select(['id', 'order_date', 'email', 'address', 'location', 'order_amount'])->get();
            return Datatables::of($orders)
                ->editColumn('order_date', function ($order) {
                    return Carbon::parse($order->order_date)->format('d.m.Y');
                })
                ->make(true);
        }

        if ($request->wantsJson()) {
            $perPage = $request->input('per_page', 10); // количество заказов на странице
            $page = $request->input('page', 1); // номер страницы

            $orders = $orders->select(['id', 'order_date', 'email', 'address', 'location', 'order_amount'])
                ->paginate($perPage, ['*'], 'page', $page);

            return response()->json($orders->all());
        }

        return view('orders.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $products = Goods::all(['id', 'product_name', 'product_price']);
        return view('orders.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        try {
            $this->validate($request, [
                "order_date" => "required|date_format:d.m.Y",
                "email"  => "required|email"
            ]);

            $order = new Order([
                'order_date' => Carbon::createFromFormat('d.m.Y', $request->order_date)->toDateString(),
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'location' => $request->location,
                'order_amount' => 0,
            ]);

            $order->save();

            $goods = [];

            for ($i = 0; $i < count($request->products); $i++) {
                $goods[$request->products[$i]] = ['quantity' => $request->quantities[$i]];
            }

            $order->goods()->attach($goods);

            $orderAmount = 0;
            foreach ($order->goods as $goods) {
                $orderAmount += $goods->pivot->quantity * $goods->product_price;
            }
            if ($orderAmount < 3000){
                $order->delete();
                return redirect()->back()->withErrors('Минимальная сумма заказа: 3000');
            }else{
            $order->update(['order_amount' => $orderAmount]);
            }

            if ($request->wantsJson()) {
                return response()->json($order, 201);
            }

            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        } catch (ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->errors()], 422);
            }

            return redirect()->back()->withErrors($e->errors());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): JsonResponse
    {
        try {
            $order = Order::findOrFail($id);
            return response()->json($order, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Order not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order): Factory|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        $goods = $order->goods()->get();
        $products = Goods::all(['id', 'product_name']);
        $date = Carbon::parse($order->order_date)->format('d.m.Y');

        return view('orders.edit')
            ->with('order', $order)
            ->with('goods', $goods)
            ->with('products', $products)
            ->with('date', $date);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse|RedirectResponse
    {
        try {

            $order = Order::findOrFail($id);

            $order->update([
                'order_date' => Carbon::createFromFormat('d.m.Y', $request->order_date)->toDateString(),
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'location' => $request->location,
            ]);

            $goods = [];
            for ($i = 0; $i < count($request->products); $i++) {
                $goods[$request->products[$i]] = ['quantity' => $request->quantities[$i]];
            }
            $order->goods()->sync($goods);

            $orderAmount = 0;
            foreach ($order->goods as $goods) {
                $orderAmount += $goods->pivot->quantity * $goods->product_price;
            }
            if ($orderAmount < 3000){

                return redirect()->back()->withErrors('Минимальная сумма заказа: 3000');
            }else{
                $order->update(['order_amount' => $orderAmount]);
            }


            if ($request->wantsJson()) {
                return response()->json($order, 200);
            }

            return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
        } catch (ValidationException $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => $e->errors()], 422);
            }

            return redirect()->back()->withErrors($e->errors());
        } catch (ModelNotFoundException $e) {
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Order not found'], 404);
            }

            return redirect()->back()->withErrors('Order not found');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): JsonResponse|RedirectResponse
    {
        $order->delete();

        if(request()->wantsJson()) {
            return response()->json(['message' => 'Order deleted']);
        }
        return redirect()->back()->with('success', 'Order deleted successfully.');
    }


}
