{!! '<'.'?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ route('home') }}</loc></url>
    <url><loc>{{ route('about') }}</loc></url>
    <url><loc>{{ route('services.index') }}</loc></url>
    <url><loc>{{ route('posts.index') }}</loc></url>
    <url><loc>{{ route('projects.index') }}</loc></url>
    <url><loc>{{ route('recruitment.index') }}</loc></url>
    <url><loc>{{ route('contact.index') }}</loc></url>
    @foreach ($pages as $page)
        <url><loc>{{ $page->canonical_url ?: route('pages.show', $page->slug) }}</loc><lastmod>{{ $page->updated_at->toAtomString() }}</lastmod></url>
    @endforeach
    @foreach ($services as $service)
        <url><loc>{{ $service->canonical_url ?: route('services.show', $service->slug) }}</loc><lastmod>{{ $service->updated_at->toAtomString() }}</lastmod></url>
    @endforeach
    @foreach ($posts as $post)
        <url><loc>{{ $post->canonical_url ?: route('posts.show', $post->slug) }}</loc><lastmod>{{ $post->updated_at->toAtomString() }}</lastmod></url>
    @endforeach
    @foreach ($projects as $project)
        <url><loc>{{ $project->canonical_url ?: route('projects.show', $project->slug) }}</loc><lastmod>{{ $project->updated_at->toAtomString() }}</lastmod></url>
    @endforeach
    @foreach ($jobs as $job)
        <url><loc>{{ $job->canonical_url ?: route('recruitment.show', $job->slug) }}</loc><lastmod>{{ $job->updated_at->toAtomString() }}</lastmod></url>
    @endforeach
</urlset>