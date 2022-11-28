<?php

declare(strict_types=1);

namespace App\GraphQL\Resolver;

use App\GraphQL\Input\FacilityInput;
use App\Entity\Facility;
use TheCodingMachine\GraphQLite\Annotations\Mutation;
use TheCodingMachine\GraphQLite\Annotations\Query;
use TheCodingMachine\GraphQLite\Types\ID;

class FacilityResolver
{
    #[Query]
    public function facility(ID $id): Facility {
        return new Facility((string) $id, 'Facility', 'facility');
    }

    #[Mutation]
    public function createFacility(FacilityInput $input): Facility {
        return new Facility('1', $input->name, $input->subdomain);
    }

    #[Mutation]
    public function updateFacility(ID $id, FacilityInput $input): Facility {
        return new Facility((string) $id, $input->name, $input->subdomain);
    }
}
