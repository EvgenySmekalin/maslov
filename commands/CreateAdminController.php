<?php
/**
 * Created by PhpStorm.
 * User: Батареечка
 * Date: 20.03.2018
 * Time: 1:01
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;

class CreateAdminController extends Controller
{
    protected $username;
    protected $password;

    public function options($actionID)
    {
        return ['username', 'password'];
    }

    public function optionAliases()
    {
        return [
            'u' => 'username',
            'p' => 'password'
        ];
    }

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        $user = new User(['username' => $this->username, 'password' => $this->password]);

        if (!$user->save()) {
            echo "New admin was not crated!\n";
            $errors = $user->getErrors();

            foreach ($errors as $error) {
                foreach ($error as $message) {
                    echo $message . "\n";
                }
            }

            return ExitCode::UNSPECIFIED_ERROR;
        }

        echo "Successfully created new admin: username: $this->username password: $this->password";
        return ExitCode::OK;
    }
}