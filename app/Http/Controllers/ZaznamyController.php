<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ZaznamyController extends Controller {
    public function index() {
        $zaznamy = DB::table("zaznamy")->orderBy("datum")->get();
        return Inertia::render("zaznamy", ["zaznamy" => $zaznamy]);
    }

    public function download(Request $request) {
        $data = Http::get("https://test.3it.cz/data/json");

        if ($data->ok()) {
            $zaznamy = array_map(function ($zaznam) {
                return [
                    "id" => $zaznam["id"],
                    "jmeno" => $zaznam["jmeno"],
                    "prijmeni" => $zaznam["prijmeni"],
                    "datum" => $zaznam["date"]
                ];
            }, $data->json());

            DB::table("zaznamy")->upsert($zaznamy, ["id"], ["jmeno", "prijmeni", "datum"]);

            return response()->json(["success" => true]);
        }

        return response()->json(["success" => false], 500);
    }
}
