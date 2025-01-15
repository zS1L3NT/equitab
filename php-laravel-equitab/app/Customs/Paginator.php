<?php

namespace App\Customs;

class Paginator extends \Illuminate\Pagination\LengthAwarePaginator
{
    public function toArray() {
        return [
            'items' => parent::items(),
            'page' => parent::currentPage(),
            'pages' => parent::lastPage(),
            'per_page' => parent::perPage(),
        ];
    }
}