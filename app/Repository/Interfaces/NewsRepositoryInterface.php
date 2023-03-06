<?php

namespace App\Repository\Interfaces;

interface NewsRepositoryInterface 
{
    public function indexNews();
    public function storeNews($title, $description, $image);
    public function showNews(string $id);
    public function destroyNews(string $id);
}