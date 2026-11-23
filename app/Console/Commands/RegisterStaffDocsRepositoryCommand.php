<?php

namespace App\Console\Commands;

use App\Models\Repository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class RegisterStaffDocsRepositoryCommand extends Command
{
    protected $signature = 'docs:register-staff {name} {--branch=main} {--alias=v1} {--category=Other}';

    protected $description = 'Register a staff-only package and its documentation without changing public configuration';

    public function handle(): void
    {
        $attributes = Validator::make([
            'name' => $this->argument('name'),
            'branch' => $this->option('branch'),
            'version' => $this->option('alias'),
            'category' => $this->option('category'),
        ], [
            'name' => ['required', 'string', 'regex:/^[a-zA-Z0-9_.-]+$/', 'not_in:.,..'],
            'branch' => ['required', 'string'],
            'version' => ['required', 'regex:/^v[0-9]+$/'],
            'category' => ['required', 'string'],
        ])->validate();

        Repository::updateOrCreate(['name' => $attributes['name']], [
            'visibility' => 'staff',
            'visible' => true,
            'type' => 'package',
            'docs_branches' => [$attributes['branch'] => $attributes['version']],
            'docs_category' => $attributes['category'],
            'language' => $attributes['category'],
            'documentation_url' => url("docs/{$attributes['name']}/{$attributes['version']}/introduction"),
            'ad_should_be_randomized' => false,
        ]);

        $this->info('Staff-only repository registered. Import its docs with docs:import --repo=spatie/' . $attributes['name']);
    }
}
