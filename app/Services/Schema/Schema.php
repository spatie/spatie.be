<?php

namespace App\Services\Schema;

use App\Models\Member;
use Spatie\SchemaOrg\Organization;
use Spatie\SchemaOrg\PostalAddress;
use Spatie\SchemaOrg\Schema as Builder;

class Schema
{
    public function organization(): Organization
    {
        return Builder::organization()
            ->identifier('https://spatie.be/#organization')
            ->name('Spatie')
            ->email('info@spatie.be')
            ->telephone('+32 3 292 56 79')
            ->vatID('BE0809.387.596')
            ->url('https://spatie.be')
            ->sameAs([
                'https://www.wikidata.org/wiki/Q141360524',
                'https://www.linkedin.com/company/spatie',
                'https://x.com/spatie_be',
                'https://github.com/spatie',
                'https://bsky.app/profile/spatie.be',
                'https://www.instagram.com/spatie_be',
            ])
            ->logo('https://spatie.be/images/spatie.png')
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
            ->postalCode('2060')
            ->streetAddress('Kruikstraat 22 bus 12')
            ->addressCountry('Belgium');
    }

    protected function founders(): array
    {
        return Member::founder()
            ->get()
            ->map(fn (Member $member) => $member->schema())
            ->toArray();
    }

    protected function employees(): array
    {
        return Member::employee()
            ->get()
            ->map(fn (Member $member) => $member->schema())
            ->toArray();
    }
}
