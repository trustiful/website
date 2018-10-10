<?php

require_once '../includes/myPDO.php';

class User
{

    /**
     * @var int
     */
    private $id_user;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * enum H / F
     *
     * @var string
     */
    private $gender;

    /**
     * can be null
     *
     * @var string
     */
    private $role;

    /**
     * can be null
     *
     * @var string
     */
    private $avatar;

    /**
     * Unique Fields which allows to identify an unique row into the database
     */
    const UNIQUE_FIELDS = ['id_user', 'email'];

    /**
     * user.class constructor.
     *
     * @param $id_user
     * @param $email
     * @param $password
     * @param $firstname
     * @param $lastname
     * @param $gender
     * @param $role
     * @param $avatar
     */
    public function __construct($id_user, $email, $password, $firstname, $lastname, $gender, $role = null, $avatar = null)
    {
        $this->setIdUser($id_user);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setGender($gender);
        $this->setRole($role);
        $this->setAvatar($avatar);
    }

    /**
     * Insert the user.class into the database
     *
     * @param $email
     * @param $password
     * @param $firstname
     * @param $lastname
     * @param $gender
     * @param $role
     * @param $avatar
     *
     * @return User
     */
    public static function insertUser($email, $password, $firstname, $lastname, $gender, $role = null, $avatar = null)
    {
        $pdo = myPDO::getInstance();
        $statement = $pdo->prepare(
            <<<SQL
          INSERT INTO user (email, password, firstname, lastname, gender, role, avatar) VALUES (?,?,?,?,?,?,?)

SQL
        );
        try {
            $statement->execute(array($email, password_hash($password, PASSWORD_DEFAULT), $firstname, $lastname, $gender, $role, $avatar));

            return new User($pdo->lastInsertId(), $email, password_hash($password, PASSWORD_DEFAULT), $firstname, $lastname, $gender, $role, $avatar);
        } catch (Exception $err) {
            echo($err->getMessage());
        }

    }

    /**
     * Try to connect user by using his email / password
     *
     * @param $email
     * @param $password
     *
     * @throws Exception
     */
    public static function login($email, $password)
    {
        $user = self::getUserBy('email', $email);
        if (password_verify($password, $user->getPassword())) {
            session_start();
            $_SESSION['user'] = $user;
        }
    }


    /**
     * @param $field
     * @param $value
     *
     * @return user
     * @throws Exception
     */
    public static function getUserBy($field, $value)
    {
        if (!in_array($field, self::UNIQUE_FIELDS)) {
            throw new Exception('Vous ne pouvez pas obtenir un utilisateur unique sur le critère : ' . $field);

        }
        $pdo = myPDO::getInstance();
        $statement = $pdo->prepare('SELECT * FROM user WHERE ' . $field . ' = ?');
        try {
            $statement->setFetchMode(
                PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,
                'User',
                array('id_user', 'email', 'password', 'firstname', 'lastname', 'gender', 'role', 'avatar')
            );
            $statement->execute(array($value));
            $user = $statement->fetch();
            if ($user !== false) {
                return $user;
            } else {
                throw new Exception('Aucun utilisateur n\'a été trouvé');
            }
        } catch (Exception $err) {
            echo($err->getMessage());
        }
    }

    public static function getAllUsers()
    {
        $pdo = myPDO::getInstance();
        $statement = $pdo->prepare('SELECT * FROM user WHERE role != ');
        try {
            $statement->setFetchMode(
                PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,
                'User',
                array('id_user', 'email', 'password', 'firstname', 'lastname', 'gender', 'role', 'avatar')
            );
            $statement->execute();
            $user = $statement->fetch();
            if ($user !== false) {
                return $user;
            } else {
                throw new Exception('Aucun utilisateur n\'a été trouvé');
            }
        } catch (Exception $err) {
            echo($err->getMessage());
        }
    }


    public function getWebsites()
    {
        $pdo = myPDO::getInstance();
        $statement = $pdo->prepare(
            <<<SQL
        SELECT * FROM websites WHERE id_user = ?
SQL
        );
        try {
            $statement->setFetchMode(
                PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,
                'Website',
                array('id_website', 'id_user', 'id_certificate', 'url', 'address', 'phone', 'rcs_number', 'subscription', 'evaluation_note', 'screen_website')
            );
            $statement->execute(array($this->getIdUser()));
            $websites = $statement->fetchAll();
            return $websites;
        } catch (Exception $err) {
            echo($err->getMessage());
        }
    }

#################################################
#################################################
#############  Getters and Setters  #############
#################################################
#################################################


    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param int $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }
}