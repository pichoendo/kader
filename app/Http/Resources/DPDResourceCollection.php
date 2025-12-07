<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DPDResourceCollection extends ResourceCollection
{
    public $page = 0;
    public $length = 0;

    public function __construct($page, $length, $collection)
    {
        parent::__construct($collection);
        $this->page = $page;
        $this->length = $length;
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'page' => $this->page,
            'length' => $this->length,
        ];
    }
}
