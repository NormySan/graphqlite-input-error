<?php

declare(strict_types=1);

namespace App\Entity;

class Facility
{
    public string $id;

    public string $name;

    public string $subdomain;

    public function __construct(string $id, string $name, string $subdomain)
    {
      $this->id = $id;
      $this->name = $name;
      $this->subdomain = $subdomain;
    }
}
