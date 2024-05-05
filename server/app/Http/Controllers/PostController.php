<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['comments', 'likes', 'user', 'category'])->get();
        $response = $posts->map(function ($post) {
            return [
                "data" => [
                    "id" => $post->id,
                    "slug" => $post->slug,
                    "title" => $post->title,
                    "keterangan" => $post->keterangan,
                    "image" => $post->image,
                    "published" => $post->published,
                    "user_id" => $post->user_id,
                    "category_id" => $post->category_id,
                    "created_at" => $post->created_at,
                    "updated_at" => $post->updated_at
                ],
                "comments" => $post->comments->map(function ($comment) {
                    return [
                        "id" => $comment->id,
                        "keterangan" => $comment->keterangan,
                        "user_id" => $comment->user_id,
                        "post_id" => $comment->post_id,
                        "created_at" => $comment->created_at,
                        "updated_at" => $comment->updated_at
                    ];
                }),
                "likes" => $post->likes->map(function ($like) {
                    return [
                        "id" => $like->id,
                        "user_id" => $like->user_id,
                        "post_id" => $like->post_id
                    ];
                }),
                "users" => [
                    "id" => $post->user->id,
                    "name" => $post->user->name
                ],
                "categories" => [
                    "id" => $post->category->id,
                    "title" => $post->category->title,
                    "slug" => $post->category->slug
                ]
            ];
        });

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|unique:posts,title',
            'keterangan' => 'required',
            'image' => 'required',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "error" => $validatedData->errors()->first()
            ], 422);
        }

        $slug = strtolower(str_replace(' ', '-', $request->title));
        $post = new Post([
            'title' => $request->title,
            'keterangan' => $request->keterangan,
            'image' => $request->image,
            'slug' => $slug,
            'published' => 0,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id
        ]);

        $post->save();

        return response()->json([
            "data" => [
                'id' => $post->id,
                'slug' => $post->slug,
                'title' => $post->title,
                'keterangan' => $post->keterangan,
                'image' => $post->image,
                'published' => $post->published,
                'user_id' => $post->user_id,
                'category_id' => $post->category_id,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at
            ]
        ], 201);
    }

    public function show(string $id)
    {
        $post = Post::with(['comments', 'likes', 'user', 'category'])->find($id);

        if (!$post) {
            return response()->json([
                "errors" => "Post tidak tersedia"
            ], 404);
        }

        return response()->json([
            "data" => [
                'id' => $post->id,
                'slug' => $post->slug,
                'title' => $post->title,
                'keterangan' => $post->keterangan,
                'image' => $post->image,
                'published' => $post->published,
                'user_id' => $post->user_id,
                'category_id' => $post->category_id,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at
            ],
            "comment" => $post->comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'keterangan' => $comment->keterangan,
                    'user_id' => $comment->user_id,
                    'post_id' => $comment->post_id,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at
                ];
            }),
            "like" => $post->likes->map(function ($like) {
                return [
                    'id' => $like->id,
                    'user_id' => $like->user_id,
                    'post_id' => $like->post_id
                ];
            }),
            "users" => [
                'id' => $post->user->id,
                'name' => $post->user->name
            ],
            "categories" => [
                'id' => $post->category->id,
                'title' => $post->category->title,
                'slug' => $post->category->slug
            ]
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $post = Post::find($id);

        $validatedData = Validator::make($request->all(), [
            'title' => ['required', Rule::unique('posts')->ignore($post->id)],
            'keterangan' => 'required',
            'image' => 'required',
            'published' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id'
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                "error" => $validatedData->errors()->first()
            ], 422);
        }

        $slug = strtolower(str_replace(' ', '-', $request->title));
        $post->update([
            'title' => $request->title,
            'keterangan' => $request->keterangan,
            'image' => $request->image,
            'slug' => $slug,
            'published' => $request->published,
            'user_id' => $request->user_id,
            'category_id' => $request->category_id
        ]);

        return response()->json([
            "data" => [
                'id' => $post->id,
                'slug' => $post->slug,
                'title' => $post->title,
                'keterangan' => $post->keterangan,
                'image' => $post->image,
                'published' => $post->published,
                'user_id' => $post->user_id,
                'category_id' => $post->category_id,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at
            ]
        ], 200);
    }

    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                "errors" => "Post tidak tersedia"
            ], 404);
        }

        if (auth()->user()->id !== $post->user_id) {
            return response()->json([
                "error" => "Unauthorized"
            ], 403);
        }

        $post->delete();

        return response()->json([
            "data" => "ok"
        ], 200);
    }

    public function publish(Request $request, string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(["error" => "Post not found"], 404);
        }

        $post->published = $request->published;
        $post->save();

        return response()->json([
            "data" => [
                "id" => $post->id,
                "published" => $post->published,
                "updated_at" => $post->updated_at
            ]
        ], 200);
    }

    public function comment(Request $request, string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                "error" => "postingan tidak tersedia"
            ], 404);
        }

        if (auth()->user()->id != $request->user_id) {
            return response()->json([
                "error" => "Unauthorized"
            ], 403);
        }

        $comment = new Comment();
        $comment->keterangan = $request->keterangan;
        $comment->user_id = $request->user_id;
        $comment->post_id = $id;
        $comment->save();

        return response()->json([
            "data" => [
                "id" => $comment->id,
                "keterangan" => $comment->keterangan,
                "user_id" => $comment->user_id,
                "post_id" => $comment->id,
                "created_at" => $comment->created_at,
                "updated_at" => $comment->updated_at
            ]
        ], 201);
    }

    public function like(Request $request, string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                "error" => "postingan tidak tersedia"
            ], 404);
        }

        if (auth()->user()->id != $request->user_id) {
            return response()->json([
                "error" => "Unauthorized"
            ], 403);
        }

        $like = new Like();
        $like->user_id = $request->user_id;
        $like->post_id = $id;
        $like->save();

        return response()->json([
            "data" => [
                "id" => $like->id,
                "user_id" => $like->user_id,
                "post_id" => $like->post_id
            ]
        ], 201);
    }
}
