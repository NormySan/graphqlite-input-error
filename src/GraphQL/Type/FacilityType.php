<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use App\Entity\Facility;
use TheCodingMachine\GraphQLite\Annotations\Field;
use TheCodingMachine\GraphQLite\Annotations\Type;
use TheCodingMachine\GraphQLite\Types\ID;

#[Type(class: Facility::class)]
class FacilityType
{
    #[Field]
    public function id(Facility $facility): ID
    {
        return new ID((string) $facility->id);
    }

    #[Field]
    public function name(Facility $facility): string
    {
        return $facility->name;
    }

    #[Field]
    public function subdomain(Facility $facility): string
    {
        return $facility->subdomain;
    }
}
