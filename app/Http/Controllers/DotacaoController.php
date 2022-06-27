<?php

namespace App\Http\Controllers;

use App\Models\Dotacao;
use App\Http\Requests\StoreDotacaoRequest;
use App\Http\Requests\UpdateDotacaoRequest;

class DotacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDotacaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDotacaoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dotacao  $dotacao
     * @return \Illuminate\Http\Response
     */
    public function show(Dotacao $dotacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dotacao  $dotacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Dotacao $dotacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDotacaoRequest  $request
     * @param  \App\Models\Dotacao  $dotacao
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDotacaoRequest $request, Dotacao $dotacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dotacao  $dotacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dotacao $dotacao)
    {
        //
    }
}
