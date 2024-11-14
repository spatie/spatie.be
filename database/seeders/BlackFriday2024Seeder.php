<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlackFriday2024Seeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 5) as $day) {
            DB::table('bf24_questions')->insert([
                'day' => $day,
                'question' => 'Fvb dpss slhyu aol zljyla vm ovd Z.W.H.A.P.L. zljylasf ybslz aol dvysk if jylhapun whjrhnlz.',
                'answer' => 'You will learn the secret of how S.P.A.T.I.E. secretly rules the world by creating packages.',
            ]);
        }
    }
}
