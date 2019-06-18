<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Post::query()->paginate(9);

        return response()->json(['posts' => $models], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $model = new Post();

        return response()->json(['post' => $model], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|min:3|max:30',
            'description' => 'min:5|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }
        $model = new Post();
        $model->create([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'user_id' => Auth::id()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $model = Post::query()->findOrFail($id);

        return response()->json(['post' => $model], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Post::query()
            ->where('user_id', auth()->id())
            ->firstOrFail($id);

        return response()->json(['post' => $model], 200);
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
        $validator = Validator::make($request->all(), [
            'title' => 'string|min:3|max:30',
            'description' => 'min:5|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $model = Post::query()
            ->where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($model) {
            $model->update([
                'title' => $request->get('title'),
                'description' => $request->get('description')
            ]);
        } else {
            return response()->json(['message' => 'Please update only your created post!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Post::query()
            ->where('id', $id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();
        $model->delete();

        return response()->json(['message' => 'Post are deleted'], 200);
    }
}
