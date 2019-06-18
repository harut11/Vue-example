<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(Request $request)
    {
        dd($request);
        $models = Post::query()->get();

        return view('welcome');
    }

    public function create()
    {
        $model = new Post();

        return response()->json(['post' => $model], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|min:3|max:30',
            'description' => 'min:5|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $model = new Post($request->only('title', 'description'));
        $model->save();
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function verify(Request $request)
    {
        dd($request->token);
    }
}
