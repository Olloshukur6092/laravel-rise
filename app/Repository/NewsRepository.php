<?php

namespace App\Repository;

use App\Models\News;
use App\Repository\Interfaces\NewsRepositoryInterface;

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

    public function destroyNews(string $id)
    {
        $this->newsModel->where(['id' => $id])->delete();
    }
}