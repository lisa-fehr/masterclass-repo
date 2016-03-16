<?php

namespace Masterclass\Model;

use PDO;

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
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
    }

    public function updatePassword($username, $password, $password_check)
    {
        if ($this->isValidPassword($password, $password_check)) {
            $sql = 'UPDATE user SET password = ? WHERE username = ?';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                md5($username . $password), // THIS IS NOT SECURE.
                $username,
            ));
            return 'Your password was changed.';
        } else {
            throw new \Exception('The password fields were blank or they did not match. Please try again.');
        }
    }

    public function getUser($username)
    {
        $dsql = 'SELECT * FROM user WHERE username = ?';
        $stmt = $this->db->prepare($dsql);
        $stmt->execute(array($username));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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

        $check_sql = 'SELECT * FROM user WHERE username = ?';
        $check_stmt = $this->db->prepare($check_sql);
        $check_stmt->execute(array($post['username']));
        if ($check_stmt->rowCount() > 0) {
            throw new \Exception('Your chosen username already exists. Please choose another.');
        }

        return true;
    }

    public function isValidPassword($password, $password_check)
    {
        return (!empty($password) && !empty($password_check) &&
            $password == $password_check);
    }

    public function isValidLogin($username, $password)
    {
        $password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
        $sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($username, $password));
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            session_regenerate_id();
            $_SESSION['username'] = $data['username'];
            $_SESSION['AUTHENTICATED'] = true;
            return true;
        } else {
            throw new \Exception('Your username/password did not match.');
        }
    }

}
