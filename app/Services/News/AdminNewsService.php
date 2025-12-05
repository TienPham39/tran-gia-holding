<?php

namespace App\Services\News;

use App\Models\News;
use App\Repositories\News\AdminNewsRepository;

class AdminNewsService
{
    protected $repo;

    public function __construct(AdminNewsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update(News $news, array $data)
    {
        return $this->repo->update($news, $data);
    }

    public function delete(News $news)
    {
        return $this->repo->delete($news);
    }
}
