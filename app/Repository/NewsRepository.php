<?php

namespace App\Repository;

use App\Models\News;
use App\Repository\Interfaces\NewsRepositoryInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class NewsRepository implements NewsRepositoryInterface
{
    // constructor for News Model
    protected $newsModel;
    public function __construct(News $news)
    {
        $this->newsModel = $news->query();
    }

    // get all News
    public function indexNews()
    {
        return $this->newsModel->get();
    }

    public function storeNews($title, $description, $image)
    {
        $image_name = time() .  '.' . $image->extension();
        $image_path = $image->storeAs('uploads', $image_name, 'public');
        $file_path = '/storage/' . $image_path;

        $this->newsModel->create([
            'title' => $title,
            'description' => $description,
            'date' => now(),
            'image' => $file_path,
        ]);
    }

    public function showNews(string $id)
    {
        return $this->newsModel->where(['id' => $id])->get();
    }

    public function updateNews($title, $description, $image, $id)
    {
        $news = $this->newsModel->where('id', $id)->first();
        return $news->title;
        $news->title = $title;
        $news->description = $description;
        $news->date = now();

        if ($news->image) {
            $imageSplit = explode('/', $news->image);
            $img = $imageSplit[count($imageSplit) - 1];

            $exists = Storage::disk('public')->exists("uploads/{$img}");
            if ($exists) {
                Storage::disk('public')->delete("uploads/{$img}");
            }

            $image_name = time() .  '.' . $image->extension();
            $image_path = $image->storeAs('uploads', $image_name, 'public');
            $news->image = $image_path;
        }

        $news->update();
    }

    public function destroyNews(string $id)
    {
        $news = $this->newsModel->where(['id' => $id])->first();
        if ($news->image) {
            $imageSplit = explode('/', $news->image);
            $image = $imageSplit[count($imageSplit) - 1];

            $exists = Storage::disk('public')->exists("uploads/{$image}");
            if ($exists) {
                Storage::disk('public')->delete("uploads/{$image}");
            }
        }

        $news->delete();
    }
}
