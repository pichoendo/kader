<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RKATResource extends JsonResource
{
 
    

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'kode'              => $this->kode,
            'departemen'        => $this->departemen->nama,
            'tahun_anggaran'    => $this->tahun_anggaran,
            'rencana_anggaran'  => $this->rencana_anggaran,
            'status'            => $this->status
        ];
    }
}
