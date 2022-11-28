<?php

declare(strict_types=1);

namespace App\GraphQL\Input;

use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Input;

#[Input]
class FacilityInput
{
    #[Field]
    public string $name;

    #[Field]
    public string $subdomain;
}
