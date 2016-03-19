<?php

namespace Masterclass\Controller;

use Masterclass\Model\User as UserModel;

/**
 * Class User
 * @package Masterclass\Controller
 */
class User
{
    /**
     * Store the model for this controller.
     * @var UserModel
     */
    protected $resource;

    /**
     * User constructor.
     * @param UserModel $user
     */
    public function __construct(UserModel $user)
    {
        $this->resource = $user;
    }

    /**
     * Create new user.
     */
    public function create()
    {
        $error = null;

        // Do the create
        if (isset($_POST['create'])) {
            try {
                $this->resource->isValid($_POST);
                $this->resource->create($_POST['email'], $_POST['username'], $_POST['password']);

                header("Location: /user/login");
                exit;
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        }
        // Show the create form

        $content = '
            <form method="post" action="/user/account/create">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="username" value="" /><br />
                <label>Email</label> <input type="text" name="email" value="" /><br />
                <label>Password</label> <input type="password" name="password" value="" /><br />
                <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
                <input type="submit" name="create" value="Create User" />
            </form>
        ';

        view('layout', $content);

    }

    /**
     * Edit account.
     */
    public function account()
    {
        $message = null;

        if (!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /user/login");
            exit;
        }

        if (isset($_POST['updatepw'])) {
            try {
                $message = $this->resource->updatePassword(
                    $_SESSION['username'],
                    $_POST['password'],
                    $_POST['password_check']
                );
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }

        }

        $user = $this->resource->getUser($_SESSION['username']);

        $content = '<br />
        
        <label>Username:</label> ' . $user['username'] . '<br />
        <label>Email:</label>' . $user['email'] . ' <br />
        
         <form method="post" action="/user/account/save">
                ' . $message . '<br />
            <label>Password</label> <input type="password" name="password" value="" /><br />
            <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
            <input type="submit" name="updatepw" value="Create User" />
        </form>';

        view('layout', $content);
    }

    /**
     * Login.
     */
    public function login()
    {
        $error = null;
        // Do the login
        if (isset($_POST['login'])) {
            try {
                $data = $this->resource->isValidLogin($_POST['user'], $_POST['pass']);
                session_regenerate_id();
                $_SESSION['username'] = $data['username'];
                $_SESSION['AUTHENTICATED'] = true;
                header("Location: /");
                exit;
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        }

        $content = '
            <form method="post" action="/user/login/check">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="user" value="" />
                <label>Password</label> <input type="password" name="pass" value="" />
                <input type="submit" name="login" value="Log In" />
            </form>
        ';

        view('layout', $content);

    }

    /**
     * Log out, redirect.
     */
    public function logout()
    {
        session_destroy();
        header("Location: /");
    }
}
