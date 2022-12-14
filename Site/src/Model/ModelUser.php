<?php

require_once __DIR__ . "/DataBaseConnection.php";

use PDOException;

class ModelUser
{

    private string $login;
    private string $password;
    private string $email;

    // un constructeur
    public function __construct(string $login, string $password, string $email)
    {
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
    }

    public function afficher() : void
    {
        echo "<div> login = $this->login </div> <br>\n";
        echo "<div> password = $this->password </div> <br>\n";
        echo "<div> email = $this->email </div> <br>\n";
    }

    private static function construire(array $userFormatTableau): ModelUser
    {
        $login = $userFormatTableau['login'];
        $password = $userFormatTableau['password'];
        $email = $userFormatTableau['email'];
        return new static ($login, $password, $email);
    }

    public static function selectAll(): array
    {
        try {
            $pdo = DataBaseConnection::getPdo();
            $query = "SELECT * FROM user;";
            $pdoStatement = $pdo->query($query);
            $tab = array();
            foreach ($pdoStatement as $userTab) {
                $tab[] = self::construire($userTab);
            }
            return $tab;
        } catch (PDOException $e) {
            return [];
        }

    }

    public static function select(string $login): ?ModelUser
    {
        try {
            $pdo = DataBaseConnection::getPdo();
            $sql = "SELECT * from user WHERE login=:login";
            $rep = $pdo->prepare($sql);
            $rep->execute(array("login" => $login,));
            $user = $rep->fetch();

            if (!$user) {
                return null;
            }
            return static::construire($user);
        } catch (PDOException $e) {
            return null;
        }

    }

    public function sauvegarder(): bool
    {
        try {
            $pdo = DataBaseConnection::getPdo();
            $sql = "INSERT INTO user (login, password, email) VALUES (:login, :password, :email)";
            $rep = $pdo->prepare($sql);
            $data = array(
                'login' => $this->login,
                'password' => $this->password,
                'email' => $this->email,
            );
            $rep->execute($data);
            return true;
        } catch (PDOException $e) {
            // echo $e->getMessage();
            return false;
        }
    }

    public static function delete(string $login): bool
    {
        try {
            $pdo = DataBaseConnection::getPDO();
            $sql = "DELETE FROM user
                    WHERE login = :login";
            $rep = $pdo->prepare($sql);
            $rep->execute(array(
                'login' => $login,
            ));
            if ($rep->rowCount() == 0) {
                return false;
            }
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public static function getHashMdp(string $login) : bool|string {
        try {
            $pdo = DatabaseConnection::getPdo();
            $sql = "SELECT mdpHache FROM tp_user WHERE login = :login ;";
            $statement = $pdo->prepare($sql);
            $statement->execute(["login" => $login]);
            $res = $statement->fetch();
            return !$res ? false : $res["mdpHache"];
        } catch (PDOException $e) {
            return false;
        }
    }


}
