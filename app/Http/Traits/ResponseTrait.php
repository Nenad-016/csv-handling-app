<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

trait ResponseTrait
{

    /**
     * @param int $code
     * @param string $message
     * @param JsonResource|Collection|null $data
     * @param LengthAwarePaginator|null $metaData
     * @param array $headers
     * @return Response
     */
    private function response(
        int $code,
        string $message = '',
        JsonResource|Collection $data = null,
        LengthAwarePaginator $metaData = null,
        array $headers = []
    ): Response
    {
        $response = [
            'message' => $message,
            'data' => $data
        ];

        if ($metaData) {
            $response['metadata'] = [
                'current_page' => $metaData->currentPage(),
                'per_page' => $metaData->perPage(),
                'total' => $metaData->total(),
                'last_page' => $metaData->lastPage(),
            ];
        }

        return response(json_encode($response), $code, $headers);
    }
}
