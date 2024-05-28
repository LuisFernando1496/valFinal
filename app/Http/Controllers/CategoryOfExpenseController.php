<?php

namespace App\Http\Controllers;

use App\Models\CategoryOfExpense;
use App\Http\Requests\StoreCategoryOfExpenseRequest;
use App\Http\Requests\UpdateCategoryOfExpenseRequest;

class CategoryOfExpenseController extends Controller
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
     * @param  \App\Http\Requests\StoreCategoryOfExpenseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryOfExpenseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryOfExpense  $categoryOfExpense
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryOfExpense $categoryOfExpense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryOfExpense  $categoryOfExpense
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryOfExpense $categoryOfExpense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryOfExpenseRequest  $request
     * @param  \App\Models\CategoryOfExpense  $categoryOfExpense
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryOfExpenseRequest $request, CategoryOfExpense $categoryOfExpense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryOfExpense  $categoryOfExpense
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryOfExpense $categoryOfExpense)
    {
        //
    }
}
