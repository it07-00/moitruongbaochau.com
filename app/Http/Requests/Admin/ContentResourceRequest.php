<?php

namespace App\Http\Requests\Admin;

use App\ContentStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContentResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $resource = (string) $this->route('resource');
        $table = match ($resource) {
            'pages' => 'pages',
            'services' => 'services',
            'posts' => 'posts',
            'projects' => 'projects',
            'jobs' => 'job_postings',
            default => abort(404),
        };
        $titleField = $resource === 'services' ? 'name' : 'title';

        return [
            $titleField => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique($table, 'slug')->ignore($this->route('item'))],
            'excerpt' => ['nullable', 'string', 'max:2000'],
            'short_description' => ['nullable', 'string', 'max:2000'],
            'summary' => ['nullable', 'string', 'max:2000'],
            'content' => ['nullable', 'string', 'max:100000'],
            'requirements' => ['nullable', 'string', 'max:50000'],
            'benefits' => ['nullable', 'string', 'max:50000'],
            'thumbnail' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:120'],
            'client' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:64'],
            'status' => ['required', Rule::enum(ContentStatus::class)],
            'is_featured' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:published_at'],
            'completed_at' => ['nullable', 'date'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:320'],
            'canonical_url' => ['nullable', 'url:http,https', 'max:255'],
            'robots' => ['nullable', Rule::in(['index,follow', 'noindex,follow', 'noindex,nofollow'])],
            'og_title' => ['nullable', 'string', 'max:255'],
            'og_description' => ['nullable', 'string', 'max:320'],
            'og_image' => ['nullable', 'string', 'max:255'],
            'twitter_title' => ['nullable', 'string', 'max:255'],
            'twitter_description' => ['nullable', 'string', 'max:320'],
            'twitter_image' => ['nullable', 'string', 'max:255'],
        ];
    }
}
