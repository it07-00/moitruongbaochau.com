<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->published()
            ->with(['category:id,name,slug', 'author:id,name'])
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();
        $seo = SeoData::forPage(
            'Tin tức môi trường, pháp luật và ESG',
            'Cập nhật pháp luật bảo vệ môi trường, giấy phép môi trường, kiểm kê khí nhà kính và ESG.',
            route('posts.index'),
        );

        return view('frontend.posts.index', compact('posts', 'seo'));
    }

    public function show(string $slug): View
    {
        $post = Post::query()
            ->published()
            ->with(['category:id,name,slug', 'author:id,name'])
            ->where('slug', $slug)
            ->firstOrFail();
        $relatedPosts = Post::query()
            ->published()
            ->whereKeyNot($post->getKey())
            ->when($post->post_category_id, fn ($query) => $query->where('post_category_id', $post->post_category_id))
            ->select(['id', 'title', 'slug', 'excerpt', 'thumbnail', 'published_at'])
            ->latest('published_at')
            ->limit(3)
            ->get();
        $seo = SeoData::forContent($post, route('posts.show', $post->slug), 'Article');

        return view('frontend.posts.show', compact('post', 'relatedPosts', 'seo'));
    }
}
