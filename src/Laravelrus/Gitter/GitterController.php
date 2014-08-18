<?php namespace Laravelrus\Gitter;

use Illuminate\Routing\Controller;

class GitterController extends Controller
{
    /**
     * @var Gitter
     */
    protected $gitter;

    /**
     * Конструктор
     *
     * @param Gitter $gitter
     */
    function __construct(Gitter $gitter)
    {
        $this->gitter = $gitter;
    }

    /**
     * Красивый список пользователей комнаты
     *
     * @return mixed
     */
    public function getIndex()
    {
        return \View::make('gitter::index', [
            'users' => GitterUser::orderBy('username')->get()
        ]);
    }

    /**
     * Список пользователей чата
     *
     * @return mixed
     */
    public function getUsers()
    {
        return GitterUser::orderBy('username')->get();
    }

    /**
     * Добавление новых пользователей в базу с приветствием в чате
     *
     * @return array
     */
    public function getCheckUsers()
    {
        $t = microtime(1);

        $users = GitterUser::orderBy('username')->lists('id');

        $newUsers = array();

        foreach ($this->gitter->users() as $user)
        {
            if ( ! in_array($user['id'], $users))
            {
                // Добавляем в массив чтобы потом поприветствовать
                $newUsers[] = $user;
                // Добавляем в базу
                GitterUser::create($user);
            }
        }

        $response = array();

        $message = 'Приветствуем Вас, @%s, в нашем дружном чате';

        foreach ($newUsers as $user)
        {
            $response[] = $this->gitter->sendMessage(
                GitterMessage::newInstance(sprintf($message, $user['username']))->isStatus()
            );
        }

        return [
            'users'     => $newUsers,
            'response'  => $response,
            'timestamp' => time(),
            'timeout'   => round((microtime(1) - $t) * 1000)
        ];
    }
}
