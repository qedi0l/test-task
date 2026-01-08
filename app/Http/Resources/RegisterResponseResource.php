<?php

namespace App\Http\Resources;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    schema: 'ActivityResource',
    title: 'ActivityResource',
    properties: [
        new Property(
            property: 'data',
            title: 'data',
            type: 'array',
            items: new Items(ref: RegisterResponseResource::class)
        )
    ],
)]#

/** @mixin Activity */
class RegisterResponseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
