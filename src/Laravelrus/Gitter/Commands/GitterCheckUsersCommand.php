<?php namespace Laravelrus\Gitter\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GitterCheckUsersCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'gitter:check_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check users in Gitter Room';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        /** @var Gitter $gitter */
        $gitter = $this->laravel->make('gitter');

        $users = GitterUser::orderBy('username')->lists('id');

        $newUsers = array();

        foreach ($gitter->users() as $user)
        {
            if ( ! in_array($user['id'], $users))
            {
                // Добавляем в массив чтобы потом поприветствовать
                $newUsers[] = $user;
                // Добавляем в базу
                GitterUser::create($user);
            }
        }

        $message = 'Приветствуем Вас, @%s, в нашем дружном чате';

        foreach ($newUsers as $user)
        {
            $gitter->sendMessage(
                GitterMessage::newInstance(sprintf($message, $user['username']))->isStatus()
            );
        }

        $this->info(sprintf('New Users: %d', count($newUsers)));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

}
