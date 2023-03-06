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
}