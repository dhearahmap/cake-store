<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Validator, Redirect};
use Inertia\Inertia;
use Carbon\Carbon;

class CakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query("search");
        if (empty($search)) {
            $cakes = DB::table("cakes")
                ->select(
                    DB::raw("
                cakes.id as id, cakes.name as name, cake_types.id as cake_type_id,
                cake_types.name as cake_type_name, stores.id as cake_store_id,
                stores.name as cake_store_name, cakes.stock as stock, cakes.deleted_at as deleted_at
            ")
                )
                ->where("cakes.deleted_at", "=", null)
                ->join("cake_types", "cake_types.id", "=", "cakes.type_id")
                ->join("stores", "stores.id", "=", "cakes.store_id")
                ->get();
        } else {
            $cakes = DB::table("cakes")
                ->select(
                    DB::raw("
                    cakes.id as id, cakes.name as name, cake_types.id as cake_type_id,
                    cake_types.name as cake_type_name, stores.id as cake_store_id,
                    stores.name as cake_store_name, cakes.stock as stock, cakes.deleted_at as deleted_at
                ")
                )
                ->where("cakes.deleted_at", "=", null)
                ->where("cakes.name", "like", "%$search%")
                ->join("cake_types", "cake_types.id", "=", "cakes.type_id")
                ->join("stores", "stores.id", "=", "cakes.store_id")
                ->get();
        }
        return Inertia::render("Cakes/Index", [
            "cakes" => $cakes,
        ]);
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function trashed(Request $request)
    {
        $trashedCakes = DB::table("cakes")
            ->select(
                DB::raw("
                cakes.id as id, cakes.name as name, cake_types.id as cake_type_id,
                cake_types.name as cake_type_name, stores.id as cake_store_id,
                stores.name as cake_store_name, cakes.stock as stock, cakes.deleted_at as deleted_at
            ")
            )
            ->where("cakes.deleted_at", "!=", null)
            ->join("cake_types", "cake_types.id", "=", "cakes.type_id")
            ->join("stores", "stores.id", "=", "cakes.store_id")
            ->get();
        return Inertia::render("Cakes/Trashed", [
            "trashed_cakes" => $trashedCakes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cakeTypes = DB::table("cake_types")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $cakeStores = DB::table("stores")
            ->select(DB::raw("id, name, address, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        return Inertia::render("Cakes/Create", [
            "cake_types" => $cakeTypes,
            "cake_stores" => $cakeStores,
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
        Validator::validate(
            $request->all(),
            [
                "type" => ["required", "integer", "exists:cake_types,id"],
                "store" => ["required", "integer", "exists:stores,id"],
                "name" => ["required", "string", "max:255"],
                "stock" => ["required", "integer", "min:0"],
            ],
            [],
            [
                "type" => "cake type",
                "store" => "cake store",
                "name" => "cake name",
                "stock" => "cake stock",
            ]
        );
        DB::table("cakes")->insert([
            "type_id" => $request->type,
            "store_id" => $request->store,
            "name" => $request->name,
            "stock" => $request->stock,
        ]);
        return Redirect::route("cakes.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cakeTypes = DB::table("cake_types")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $cakeStores = DB::table("stores")
            ->select(DB::raw("id, name, address, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $cake = DB::table("cakes")
            ->select(
                DB::raw("
                cakes.id as id, cakes.name as name, cake_types.id as cake_type_id,
                cake_types.name as cake_type_name, stores.id as cake_store_id,
                stores.name as cake_store_name, cakes.stock as stock, cakes.deleted_at as deleted_at
            ")
            )
            ->where("cakes.id", "=", $id)
            ->where("cakes.deleted_at", "=", null)
            ->join("cake_types", "cake_types.id", "=", "cakes.type_id")
            ->join("stores", "stores.id", "=", "cakes.store_id")
            ->get();
        return Inertia::render("Cakes/Edit", [
            "cake_types" => $cakeTypes,
            "cake_stores" => $cakeStores,
            "cake" => $cake[0],
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
                "type" => ["required", "integer", "exists:cake_types,id"],
                "store" => ["required", "integer", "exists:stores,id"],
                "name" => ["required", "string", "max:255"],
                "stock" => ["required", "integer", "min:0"],
            ],
            [],
            [
                "type" => "cake type",
                "store" => "cake store",
                "name" => "cake name",
                "stock" => "cake stock",
            ]
        );
        DB::table("cakes")
            ->where("id", "=", $id)
            ->update([
                "type_id" => $request->type,
                "store_id" => $request->store,
                "name" => $request->name,
                "stock" => $request->stock,
                "updated_at" => Carbon::now(),
            ]);
        return Redirect::route("cakes.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("cakes")
            ->where("id", "=", $id)
            ->update([
                "deleted_at" => Carbon::now(),
            ]);
        return back();
    }

    /**
     * Permanently remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_permanent($id)
    {
        DB::table("cakes")
            ->where("id", "=", $id)
            ->delete();
        return back();
    }

    /**
     * Restore the specified trashed resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        DB::table("cakes")
            ->where("id", "=", $id)
            ->where("deleted_at", "!=", null)
            ->update([
                "deleted_at" => null,
            ]);
        return back();
    }
}
