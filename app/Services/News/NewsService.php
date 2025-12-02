<?php

namespace App\Services\News;

use App\Repositories\News\NewsRepository;

class NewsService
{
  protected $repo;

  public function __construct(NewsRepository $repo)
  {
    $this->repo = $repo;
  }

  public function list($category = null)
  {
    return $this->repo->list($category);
  }

  public function detail($slug)
  {
    return $this->repo->findBySlug($slug);
  }
}
