<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Spatie\Ssh\Ssh;

class UpdateSatisAction extends DetachedAction
{
    use InteractsWithQueue;
    use Queueable;

    public function label()
    {
        return __('Update Satis');
    }

    public function handle(ActionFields $fields, Collection $models)
    {
        dispatch(function () {
            Ssh::create('forge', 'satis.spatie.be')->execute([
                'cd satis.spatie.be',
                './bin/satis build',
            ]);
        });
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
