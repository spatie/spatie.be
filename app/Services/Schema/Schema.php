<?php

namespace App\Services\Schema;

use App\Models\Member;
use Spatie\SchemaOrg\LocalBusiness;
use Spatie\SchemaOrg\PostalAddress;
use Spatie\SchemaOrg\Schema as Builder;

class Schema
{
    public function localBusiness(): LocalBusiness
    {
        return Builder::localBusiness()
            ->name('Spatie')
            ->email('info@spatie.be')
            ->telephone('+32 3 292 56 79')
            ->vatID('BE0809.387.596')
            ->url([
                'https://spatie.be',
                'https://twitter.com/spatie_be',
            ])
            ->image('https://spatie.be/images/og-image.jpg')
            ->address($this->address())
            ->founders($this->founders())
            ->employees($this->employees());
    }

    protected function address(): PostalAddress
    {
        return Builder::postalAddress()
            ->addressLocality('Antwerp')
            ->addressRegion('Antwerp')
            ->postalCode(2060)
            ->streetAddress('Kruikstraat 22 bus 12')
            ->addressCountry('Belgium');
    }

    protected function founders(): array
    {
        return Member::founder()->get()->map->schema()->toArray();
    }

    protected function employees(): array
    {
        return Member::employee()->get()->map->schema()->toArray();
    }
}
