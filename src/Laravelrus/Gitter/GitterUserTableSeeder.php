<?php namespace Laravelrus\Gitter;

use Illuminate\Database\Seeder;

class GitterUserTableSeeder extends Seeder
{
    public function run()
    {
        $gitter = $this->container->make('gitter');

        foreach ($gitter->users() as $user)
        {
            GitterUser::create($user);
        }
    }
}
