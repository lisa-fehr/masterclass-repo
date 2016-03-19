<?php

namespace Masterclass\Model;

/**
 * Class User
 * @package Masterclass\Model
 */
class User extends BaseModel
{
    /**
     * Create a new user.
     * @param string $email
     * @param string $username
     * @param string $password
     */
    public function create($email, $username, $password)
    {
        $params = array(
            $username,
            $email,
            md5($username . $password),
        );

        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
        $stmt = $this->db->execute($sql, $params);
    }

    /**
     * Change password.
     * @param string $username
     * @param string $password
     * @param string $password_check
     * @return string
     * @throws \Exception
     */
    public function updatePassword($username, $password, $password_check)
    {
        if ($this->isValidPassword($password, $password_check)) {
            $sql = 'UPDATE user SET password = ? WHERE username = ?';
            $stmt = $this->db->execute($sql, array(
                md5($username . $password), // THIS IS NOT SECURE.
                $username,
            ));
            return 'Your password was changed.';
        } else {
            throw new \Exception('The password fields were blank or they did not match. Please try again.');
        }
    }

    /**
     * Get the user by their username.
     * @param string $username
     * @return array
     */
    public function getUser($username)
    {
        $dsql = 'SELECT * FROM user WHERE username = ?';
        return $this->db->fetchOne($dsql, [$username]);
    }

    /**
     * Check if the form is valid for a new user.
     * @param array $post
     * @return bool
     * @throws \Exception
     */
    public function isValid($post)
    {
        if (empty($post['username']) || empty($post['email']) ||
            empty($post['password']) || empty($post['password_check'])
        ) {
            throw new \Exception('You did not fill in all required fields.');
        }

        if (filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false) {
            throw new \Exception('Your email address is invalid');
        }

        if ($post['password'] != $post['password_check']) {
            throw new \Exception("Your passwords didn't match.");
        }

        $check_sql = 'SELECT COUNT(*) as count FROM user WHERE username = ?';
        $check_stmt = $this->db->fetchOne($check_sql, array($post['username']));

        if ($check_stmt['count'] > 0) {
            throw new \Exception('Your chosen username already exists. Please choose another.');
        }

        return true;
    }

    /**
     * Check if the password was filled in and matches the confirmation field.
     * @param string $password
     * @param string $password_check
     * @return bool
     */
    public function isValidPassword($password, $password_check)
    {
        return (!empty($password) && !empty($password_check) &&
            $password == $password_check);
    }

    /**
     * Check that the username and password are valid.
     * @param string $username
     * @param string $password
     * @return array|bool
     * @throws \Exception
     */
    public function isValidLogin($username, $password)
    {
        $password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
        $sql = 'SELECT *, COUNT(*) as count FROM user WHERE username = ? AND password = ? LIMIT 1';
        $stmt = $this->db->fetchOne($sql, [$username, $password]);

        if ($stmt['count'] > 0) {
            return $stmt;
        } else {
            throw new \Exception('Your username/password did not match.');
        }
    }

}
