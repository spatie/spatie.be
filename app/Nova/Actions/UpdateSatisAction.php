<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Actions\Action;
use Spatie\Ssh\Ssh;

class UpdateSatisAction extends Action
{
    use InteractsWithQueue;
    use Queueable;

    public function label()
    {
        return 'Update Satis';
    }

    public function handle()
    {
        dispatch(function () {
            Ssh::create('forge', 'satis.spatie.be')->execute([
                'cd satis.spatie.be',
                './bin/satis build',
            ]);
        });
    }
}
