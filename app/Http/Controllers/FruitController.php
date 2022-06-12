<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fruit;
use App\Http\Resources\FruitResource;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;

class FruitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Artisan::call('fetch:fruit');

        return Inertia::render('Main', [
            'items' => FruitResource::collection(Fruit::all())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valid =  $valid = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $fruit = Fruit::findOrFail($id);

        $fruit->update($request->all());

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $fruit = Fruit::find($id);
        $fruit->delete();
        return response()->json("deleted");
    }
}
