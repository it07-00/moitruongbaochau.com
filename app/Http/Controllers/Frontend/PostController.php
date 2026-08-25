<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $currentCategorySlug = $request->query('category');
        $currentCategory = $currentCategorySlug
            ? PostCategory::query()->where('slug', $currentCategorySlug)->first()
            : null;

        $postCategories = PostCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $posts = Post::query()
            ->published()
            ->when($currentCategory, fn ($query) => $query->where('post_category_id', $currentCategory->id))
            ->with(['category', 'author'])
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        $page = Page::query()->where('slug', 'tin-tuc')->orWhere('template', 'posts')->first();

        $title = $currentCategory
            ? $currentCategory->name.' - Tin tức Môi Trường Bảo Châu'
            : ($page?->meta_title ?: 'Tin tức môi trường, pháp luật và ESG');

        $seoDescription = $page?->meta_description ?: 'Cập nhật pháp luật bảo vệ môi trường, giấy phép môi trường, kiểm kê khí nhà kính và ESG.';

        $seo = SeoData::forPage(
            $title,
            $seoDescription,
            route('posts.index'),
            [],
            $page?->og_image ? asset($page->og_image) : null,
        );

        return view('frontend.posts.index', compact('page', 'posts', 'postCategories', 'currentCategory', 'seo'));
    }

    public function show(string $slug): View
    {
        $post = Post::query()
            ->published()
            ->with(['category', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();
        $relatedPosts = Post::query()
            ->published()
            ->whereKeyNot($post->getKey())
            ->when($post->post_category_id, fn ($query) => $query->where('post_category_id', $post->post_category_id))
            ->with(['category', 'author'])
            ->latest('published_at')
            ->limit(3)
            ->get();
        $seo = SeoData::forContent($post, route('posts.show', $post->slug), 'Article');

        return view('frontend.posts.show', compact('post', 'relatedPosts', 'seo'));
    }
}
