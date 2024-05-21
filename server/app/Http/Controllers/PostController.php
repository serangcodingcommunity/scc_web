<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
// Post
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
        $user = Auth::user();
        $validatedData = $request->validate([
            'title' => 'required|string',
            'keterangan' => 'required|string',
            'image' => 'file|mimes:jpg,jpeg,png,webp|max:512',
            'published' => 'required|integer',
            'category_id' => 'required|integer'
        ],[
            'image.max' => 'File harus berukuran 500 kb',
            'image.mimes' => 'File harus berformat jpg, jpeg, png & webp'
        ]);

        if (Post::where('title', $request->title)->first()) {
            return response()->json([
                "message" => "Judul sudah digunakan"
            ], 422);
        } elseif (!Category::where('id', $request->category_id)->exists()) {
            return response()->json([
                "message" => "Kategori tidak ditemukan"
            ], 404);
        }

        if($request->hasFile('image')) {
            $userName = $user->name;
            $timestamp = now()->timestamp;
            $image = 'post-' . $userName . '-' . $timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $filePath = 'images/post/' . $image; 
            Storage::disk('public')->put($filePath, file_get_contents($request->file('image')));
        }

        $validatedData['image'] = $image;
        $validatedData['user_id'] = $user->id;
        $validatedData['slug'] = slugify($request->title);
        $post = new Post($validatedData);
        $post->save();

        return response()->json([
            "data" => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
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
                "errors" => "Postingan tidak tersedia"
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
        $user = Auth::user();

        $validatedData = $request->validate([
            'title' => 'string',
            'keterangan' => 'string',
            'image' => 'file|mimes:jpg,jpeg,png,webp|max:512',
            'category_id' => 'exists:categories,id'
        ],[
            'image.max' => 'File harus berukuran 500 kb',
            'image.mimes' => 'File harus berformat jpg, jpeg, png & webp'
        ]);

        if (!$post) {
            return response()->json([
                "message" => "Postingan tidak tersedia"
            ], 404);
        } elseif ($post->user_id !== $user->id) {
            return response()->json([
                "message" => "Tidak bisa mengedit postingan ini"
            ], 403);
        } elseif (Post::where('title', $request->title)->where('id', '!=', $id)->exists()) {
            return response()->json([
                "message" => "Judul sudah digunakan"
            ], 422);
        } elseif (!Category::where('id', $request->category_id)->exists()) {
            return response()->json([
                "message" => "Kategori tidak ditemukan"
            ], 404);
        }

        if($request->hasFile('image')) {
            if ($post->image) {
                $profilePhotoPath = 'images/post/' . $post->image;
                Storage::disk('public')->delete($profilePhotoPath);
            }
            $userName = $user->name;
            $timestamp = now()->timestamp;
            $image = 'post-' . $userName . '-' . $timestamp . '.' . $request->file('image')->getClientOriginalExtension();
            $filePath = 'images/post/' . $image; 
            Storage::disk('public')->put($filePath, file_get_contents($request->file('image')));
            $validatedData['image'] = $image;
        }

        $validatedData['user_id'] = $user->id;
        $validatedData['slug'] = slugify($request->title);

        $post->update($validatedData);

        return response()->json([
            "data" => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'keterangan' => $post->keterangan,
                'image' => $post->image,
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
        $user = Auth::user();

        if (!$post) {
            return response()->json([
                "errors" => "Postingan tidak tersedia"
            ], 404);
        } elseif($post->user_id !== $user->id) {
            return response()->json([
                "message" => "Tidak bisa menghapus postingan ini"
            ], 403);
        }

        $comments = Comment::where('post_id', $id)->get();
        foreach ($comments as $comment) {
            $comment->delete();
        }

        $likes = Like::where('post_id', $id)->get();
        foreach ($likes as $like) {
            $like->delete();
        }

        $post->delete();

        return response()->json([
            "message" => "Postingan berhasil dihapus",
            "data" => "ok"
        ], 200);
    }

// Publish
    public function publish(Request $request, string $id)
    {
        $post = Post::find($id);
        $user = Auth::user();

        if (!$post) {
            return response()->json([
                "message" => "Postingan tidak tersedia"
            ], 404);
        } elseif($post->user_id !== $user->id) {
            return response()->json([
                "message" => "Tidak bisa mengunggah postingan ini"
            ], 403);
        } elseif($post->published == 1) {
            return response()->json([
                "message" => "Postingan sudah dipublikasi"
            ], 404);
        }

        $post->published = $request->published;
        $post->save();

        return response()->json([
            "message" => "Post berhasil dipublikasi",
            "data" => [
                "id" => $post->id,
                "published" => $post->published,
                "updated_at" => $post->updated_at
            ]
        ], 200);
    }

// Comment
    public function comment(Request $request, string $id)
    {
        $post = Post::find($id);
        $user = Auth::user();

        if (!$post) {
            return response()->json([
                "message" => "Postingan tidak tersedia"
            ], 404);
        } elseif($post->published == 0) {
            return response()->json([
                "message" => "Post tidak dipublikasi"
            ], 404);
        } elseif ($post->published == 1) {
            $comment = new Comment();
            $comment->keterangan = $request->keterangan;
            $comment->user_id = $user->id;
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
    }

// Like
    public function like(Request $request, string $id)
    {
        $post = Post::find($id);
        $user = Auth::user();

        if (!$post) {
            return response()->json([
                "message" => "Postingan tidak tersedia"
            ], 404);
        }

        if($post->published == 0)
        {
            return response()->json([
                "message" => "Post tidak dipublikasi"
            ], 404);
        } elseif ($post->published == 1) {
            if (Like::where('user_id', $request->user_id)->where('post_id', $id)->first()) {
                return response()->json([
                    "message" => "User sudah like post ini"
                ], 409);
            }

            $like = new Like();
            $like->user_id = $user->id;
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

    public function unlike(Request $request, string $id)
    {
        $post = Post::find($id);
        $user = Auth::user();

        if (!$post) {
            return response()->json([
                "message" => "Postingan tidak tersedia"
            ], 404);
        }

        $like = Like::where('post_id', $id)->where('user_id', $user->id)->first();

        if (!$like) {
            return response()->json([
                "message" => "Tidak like post ini"
            ], 404);
        }

        $like->delete();

        return response()->json([
            "message" => "Unlike berhasil",
            "data" => "ok"
        ], 200);
    }
}
