<?php

namespace App\Controllers\Admin;


use App\Core\Request;
use App\Models\Developer;
use App\Controllers\Controller;

class DeveloperController extends Controller
{
    public function index()
    {
        return view('admin.developer')->output();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|trim',
            'website' => 'required',
            'description' => 'string'
        ]);

        if ($request->isError() || ! $request->ajax()) {
            return json(['message' => 'Bad Request'], 422);
        }

        (new Developer)->create([
            'name' => __e($request->name),
            'website' => $request->website,
            'description' => $request->description
        ]);

        return json(['message' => 'Developer berhasil ditambahkan!'], 201);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|int',
            'name' => 'required|trim',
            'website' => 'required|trim',
            'description' => 'string'
        ]);

        if ($request->isError() || ! $request->ajax()) {
            return json(['message' => 'Bad Request'], 422);
        }

        $developer = Developer::firstOrFail(['id' => $request->id]);
        $developer->update([
            'name' => __e($request->name),
            'website' => $request->website,
            'description' => $request->description
        ]);

        return json(['message' => 'Developer berhasil dirubah'], 200);
    }

    public function delete(Request $request)
    {
        $request->validate(['id' => 'required|int']);

        if ($request->isError() || ! $request->ajax()) {
            return json(['message' => 'Bad Request'], 422);
        }

        Developer::firstOrFail(['id' => $request->id])->delete();

        return json([], 204);
    }

    public function api()
    {
        return json([
            'data' => Developer::all(-1, 0, false)
        ]);
    }
}
