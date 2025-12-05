<?php

namespace App\Repositories\News;
use App\Models\News;

class AdminNewsRepository
{
    public function create(array $data)
    {
        return News::create($data);
    }   

    public function update(News $news, array $data)
    {
        return $news->update($data);
    }

    public function delete(News $news)
    {
        return $news->delete();
    }
}
