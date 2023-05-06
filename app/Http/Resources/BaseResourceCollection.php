<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseResourceCollection extends ResourceCollection
{
    /**
     * Customize the pagination information for the future resource collections.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array $paginated
     * @param  array $default
     * @return array
     */
    public function paginationInformation($request, $paginated, $default)
    {
        if(empty($paginated)) {
            return [];
        }

        $default['meta'] = [
            'currentPage' => $default['meta']['current_page'],
            'totalItems' => $default['meta']['total'],
            'itemsPerPage' => $default['meta']['per_page'],
            'totalPages' => $default['meta']['last_page']
        ];
        
        $default['links'] = [
            'prev' => $default['links']['prev'],
            'next' => $default['links']['next'],
            'self' => url()->full()
        ];
    
        return $default;
    }
}