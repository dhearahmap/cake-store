<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Validator, Redirect};
use Inertia\Inertia;
use Carbon\Carbon;

class CakeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cakeTypes = DB::table("cake_types")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("cake_types.deleted_at", "=", null)
            ->get();
        return Inertia::render("CakeTypes/Index", [
            "cake_types" => $cakeTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("CakeTypes/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::validate(
            $request->all(),
            [
                "name" => ["required", "string", "max:255"],
            ],
            [],
            [
                "name" => "cake type name",
            ]
        );
        DB::table("cake_types")->insert([
            "name" => $request->name,
        ]);
        return Redirect::route("cakes.types.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cakeType = DB::table("cake_types")
            ->where("id", "=", $id)
            ->get();
        return Inertia::render("CakeTypes/Edit", [
            "cake_type" => $cakeType[0],
        ]);
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
        Validator::validate(
            $request->all(),
            [
                "name" => ["required", "string", "max:255"],
            ],
            [],
            [
                "name" => "cake type name",
            ]
        );
        DB::table("cake_types")
            ->where("id", "=", $id)
            ->update([
                "name" => $request->name,
                "updated_at" => Carbon::now(),
            ]);
        return Redirect::route("cakes.types.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("cake_types")
            ->where("id", "=", $id)
            ->update([
                "deleted_at" => Carbon::now(),
            ]);
        return back();
    }
}
