<?php

namespace App\Nebula\Resources;

use Larsklopstra\Nebula\Contracts\NebulaResource;

class UserResource extends NebulaResource
{
    protected $searchable = [];

    public function icon()
    {
        return 'user-group';
    }

    public function singularName()
    {
        return 'user';
    }

    public function pluralName()
    {
        return 'users';
    }


    public function fields(): array
    {
        return [
            InputField::make('name'),
            InputField::make('email'),
        ];
    }
}
