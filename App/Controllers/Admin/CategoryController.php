<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Core\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category')->output();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|trim',
            'slug'        => 'required',
            'description' => 'string',
        ]);

        if ($request->isError() || !$request->ajax()) {
            return json(['message' => 'Bad Request'], 422);
        }

        $data = [
            'name'        => __e($request->name),
            'slug'        => slugify($request->slug),
            'description' => $request->description,
        ];

        $upload = $this->tryUpload();

        if ($upload['success']) {
            $data['image'] = 'img/categories/'.$upload['fileName'];
        }

        (new Category())->create($data);

        return json(['message' => 'Kategori berhasil ditambahkan!'], 201);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'          => 'required|int',
            'name'        => 'required|trim',
            'slug'        => 'required|trim',
            'description' => 'string',
        ]);

        if ($request->isError() || !$request->ajax()) {
            return json(['message' => 'Bad Request'], 422);
        }

        $upload = $this->tryUpload($request->id);

        $category = Category::firstOrFail(['id' => $request->id]);

        if ($upload['success']) {
            $category->image = 'img/categories/'.$upload['fileName'];
        }

        $category->update([
            'name'        => __e($request->name),
            'slug'        => slugify($request->slug),
            'description' => $request->description,
        ]);

        return json(['message' => 'Kategori berhasil dirubah'], 200);
    }

    public function delete(Request $request)
    {
        $request->validate(['id' => 'required|int']);

        if ($request->isError() || !$request->ajax()) {
            return json(['message' => 'Bad Request'], 422);
        }

        Category::firstOrFail(['id' => $request->id])->delete();

        return json([], 204);
    }

    public function api()
    {
        return json([
            'data' => Category::all(-1, 0, false),
        ]);
    }

    private function tryUpload($id = 0)
    {
        $success = false;
        $fileName = '';
        $id = $id == 0 ? rand(1e4, 9e4) : $id;

        $uploadDir = implode(DS, [FRONT_PATH, 'assets', 'img', 'categories']);

        if (isset($_FILES['image']) && $_FILES['image']['size'] <= 2048000) {
            $image = $_FILES['image'];
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            if ($this->isAllowedExtension($ext)) {
                $fileName = sprintf('cat-%d.%s', $id, $ext);
                if (is_writable($uploadDir)) {
                    $success = move_uploaded_file($image['tmp_name'], $uploadDir.DS.$fileName);
                }
            }
        }

        return compact('success', 'fileName');
    }

    private function isAllowedExtension($ext)
    {
        return in_array($ext, ['jpg', 'jpeg', 'png']);
    }
}
