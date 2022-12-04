<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Validator, Redirect};
use Inertia\Inertia;
use Carbon\Carbon;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = DB::table("stores")
            ->select(DB::raw("id, name, address, deleted_at"))
            ->where("stores.deleted_at", "=", null)
            ->get();
        return Inertia::render("Stores/Index", [
            "stores" => $stores,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Stores/Create");
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
                "address" => ["required", "string"],
            ],
            [],
            [
                "name" => "store name",
                "address" => "store address",
            ]
        );
        DB::table("stores")->insert([
            "name" => $request->name,
            "address" => $request->address,
        ]);
        return Redirect::route("cakes.stores.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $store = DB::table("stores")
            ->where("id", "=", $id)
            ->get();
        return Inertia::render("Stores/Edit", [
            "store" => $store[0],
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
                "address" => ["required", "string"],
            ],
            [],
            [
                "name" => "store name",
                "address" => "store address",
            ]
        );
        DB::table("stores")
            ->where("id", "=", $id)
            ->update([
                "name" => $request->name,
                "address" => $request->address,
                "updated_at" => Carbon::now(),
            ]);
        return Redirect::route("cakes.stores.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("stores")
            ->where("id", "=", $id)
            ->update([
                "deleted_at" => Carbon::now(),
            ]);
        return back();
    }
}
