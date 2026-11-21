<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TribuneNewsService
{
    protected function request(string $table, array $query = []): array
    {
        $baseUrl = rtrim((string) config('services.supabase.url'), '/');
        $apiKey = (string) config('services.supabase.publishable_key');

        if ($baseUrl === '' || $apiKey === '') {
            Log::warning('TribuneBangla Supabase configuration is incomplete.');
            return [];
        }

        try {
            $response = Http::withHeaders([
                'apikey' => $apiKey,
                'Accept' => 'application/json',
            ])->timeout((int) config('services.supabase.rest_timeout', 8))
              ->get($baseUrl . '/rest/v1/' . $table, $query);

            if (!$response->successful()) {
                Log::error('TribuneBangla Supabase request failed.', [
                    'table' => $table,
                    'status' => $response->status(),
                ]);
                return [];
            }

            $data = $response->json();
            return is_array($data) ? $data : [];
        } catch (\Throwable $exception) {
            Log::error('TribuneBangla Supabase connection failed.', [
                'table' => $table,
                'message' => $exception->getMessage(),
            ]);
            return [];
        }
    }

    public function categories()
    {
        return collect($this->request('categories', [
            'select' => 'id,name,slug,description,sort_order,is_active',
            'is_active' => 'eq.true',
            'order' => 'sort_order.asc,name.asc',
            'limit' => 50,
        ]))->map(function ($row) {
            return (object) $row;
        });
    }

    public function publishedNews(int $limit = 100)
    {
        $categories = $this->categories()->keyBy('id');

        return collect($this->request('news', [
            'select' => 'id,title,slug,excerpt,body,featured_image,image_alt,category_id,source_name,source_url,published_at,created_at,view_count,seo_title,seo_description',
            'status' => 'eq.published',
            'published_at' => 'not.is.null',
            'order' => 'published_at.desc',
            'limit' => max(1, min($limit, 200)),
        ]))->map(function ($row) use ($categories) {
            $category = $categories->get($row['category_id'] ?? null);
            $author = (object) [
                'name' => 'TribuneBangla ডেস্ক',
                'image' => 'frontend/assets/images/logo1.png',
            ];

            return (object) [
                'id' => $row['id'] ?? null,
                'title' => $row['title'] ?? '',
                'slug' => $row['slug'] ?? '',
                'excerpt' => $row['excerpt'] ?? '',
                'content' => $row['body'] ?? '',
                'body' => $row['body'] ?? '',
                'image' => $row['featured_image'] ?? '',
                'image_alt' => $row['image_alt'] ?? ($row['title'] ?? ''),
                'category_id' => $row['category_id'] ?? null,
                'category' => $category ?: (object) ['name' => 'অন্যান্য', 'slug' => 'other'],
                'auther' => $author,
                'tags' => collect(),
                'comments' => collect(),
                'created_at' => $row['published_at'] ?? ($row['created_at'] ?? now()),
                'published_at' => $row['published_at'] ?? null,
                'views' => (int) ($row['view_count'] ?? 0),
                'meta_title' => $row['seo_title'] ?? ($row['title'] ?? ''),
                'meta_description' => $row['seo_description'] ?? ($row['excerpt'] ?? ''),
                'source_name' => $row['source_name'] ?? '',
                'source_url' => $row['source_url'] ?? '',
            ];
        });
    }
}
