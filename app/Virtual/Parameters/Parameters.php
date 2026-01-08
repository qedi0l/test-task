<?php

namespace App\Virtual\Parameters;

use OpenApi\Attributes\PathParameter;
use OpenApi\Attributes\Schema;

#[PathParameter(
    parameter: 'id',
    name: 'id',
    description: 'ID',
    required: true,
    schema: new Schema(type: 'integer', minimum: 1),
    example: 1,
)]
class Parameters
{

}
