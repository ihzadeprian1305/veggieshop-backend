<?php

namespace App\Http\Controllers;

use App\Models\Vegetable;
use Illuminate\Http\Request;
use App\Http\Requests\VegetableRequest;

class VegetableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vegetable = Vegetable::paginate(10);

        return view('vegetables.index', [
            'vegetable' => $vegetable
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vegetables.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VegetableRequest $request)
    {
        $data = $request->all();

        if($request->file('picturePath')){
            $data['picturePath'] = $request->file('picturePath')->store('assets.vegetable','public');
        }

        Vegetable::create($data);

        return redirect()->route('vegetables.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Vegetable $vegetable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vegetable $vegetable)
    {
        return view('vegetables.edit', [
            'item' => $vegetable
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VegetableRequest $request, Vegetable $vegetable)
    {
        $data = $request->all();

        if($request->file('picturePath')){
            $data['picturePath'] = $request->file('picturePath')->store('assets.vegetable','public');
        }

        $vegetable->update($data);

        return redirect()->route('vegetables.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vegetable $vegetable)
    {
        $vegetable->delete();

        return redirect()->route('vegetables.index');
    }
}
