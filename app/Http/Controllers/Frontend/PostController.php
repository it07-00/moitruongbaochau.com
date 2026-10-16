<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostCategory;
use App\Support\SeoData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PostController extends Controller
{
    public function pdf(Request $request, string $slug): StreamedResponse
    {
        $post = Post::query()->published()->where('slug', $slug)->firstOrFail();
        $path = preg_replace('#^/?storage/#', '', $post->pdf_file ?? '');

        abort_unless(
            str_starts_with($path, 'uploads/posts/documents/')
            && ! preg_match('#(^|/)\.\.?(/|$)|[\\\\%]#', $path)
            && strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf',
            404,
        );

        foreach (['public', 'local'] as $diskName) {
            $disk = Storage::disk($diskName);

            if ($disk->exists($path)) {
                return $disk->response(
                    $path,
                    basename($path),
                    ['Content-Type' => 'application/pdf', 'X-Content-Type-Options' => 'nosniff'],
                    $request->boolean('download') ? 'attachment' : 'inline',
                );
            }
        }

        abort(404);
    }

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
            route('posts.index', $currentCategory ? ['category' => $currentCategory->slug] : []),
            [],
            $page?->og_image,
        );
        $seo = SeoData::withPagination($seo, $posts);

        return view('frontend.posts.index', compact('page', 'posts', 'postCategories', 'currentCategory', 'seo'));
    }

    public function show(string $slug): View
    {
        $post = Post::query()
            ->published()
            ->with(['category', 'author'])
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('view_count');

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
