<?php

class Database
{

    private PDO $db;
    private string $hostname = "localhost";
    private string $port = "3306";
    private string $dbname = "le_mot";
    private string $username = "root";
    private string $pwd = "";

    public function __construct()
    {
        $this->db = new PDO("mysql:host=$this->hostname;port=$this->port;dbname=$this->dbname", $this->username, $this->pwd);
    }

    public function createUser($userName, $password)
    {
        $stmt = $this->db->prepare("INSERT INTO utilisateurs (username, password) VALUES (:username, :password)");
        $stmt->bindParam(':username', $userName, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getUser($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByCredentials($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPoints($userId)
    {
        $stmt = $this->db->prepare("SELECT points FROM utilisateurs WHERE id_utilisateur = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addPoints($userId, $newPoints)
    {
        $stmt = $this->db->prepare("UPDATE utilisateurs SET points = points + :newPoints WHERE id_utilisateur = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':newPoints', $newPoints, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function resetPoints($userId)
    {
        $stmt = $this->db->prepare("UPDATE utilisateurs SET points = 0 WHERE id_utilisateur = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteUser($userId)
    {
        $stmt = $this->db->prepare("DELETE FROM utilisateurs WHERE id_utilisateur = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateUser($userId, $userName, $password)
    {
        $stmt = $this->db->prepare("UPDATE utilisateurs SET username = :username, password = :password WHERE id_utilisateur = :userId");
        $stmt->bindParam(':username', $userName, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function changeUsernameUser($userId, $newUsername)
    {
        $stmt = $this->db->prepare("UPDATE utilisateurs SET username = :newUsername WHERE id_utilisateur = :userId");
        $stmt->bindParam(':newUsername', $newUsername, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function changePasswordUser($userId, $newPassword)
    {
        $stmt = $this->db->prepare("UPDATE utilisateurs SET password = :newPassword WHERE id_utilisateur = :userId");
        $stmt->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updatePlayerGame($userId, $gameId)
    {
        $stmt = $this->db->prepare("UPDATE utilisateurs SET games_id_game = :gameId WHERE id_utilisateur = :userId");
        $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
        $stmt->bindParam(':gameId', $gameId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function createPublicGame($name, $hostId, $difficulty, $nbround)
    {
        $stmt = $this->db->prepare("INSERT INTO games (name, hostId, difficulty, private, status, nbRound) VALUES (:name, :hostId, :difficulty, 0, 0, :nbround)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':hostId', $hostId, PDO::PARAM_STR);
        $stmt->bindParam(':difficulty', $difficulty, PDO::PARAM_STR);
        $stmt->bindParam(':nbround', $nbround, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function createPrivateGame($name, $hostId, $difficulty, $code, $password, $nbround)
    {
        $stmt = $this->db->prepare("INSERT INTO games (name, hostId, difficulty, code, password, private, status, nbRound) VALUES (:name, :hostId, :difficulty, :code, :password, 1, 0, :nbround)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':hostId', $hostId, PDO::PARAM_STR);
        $stmt->bindParam(':difficulty', $difficulty, PDO::PARAM_STR);
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->bindParam(':nbround', $nbround, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getPublicGames()
    {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE private = 0 AND status = 0");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGameById($gameId)
    {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE id_game = :gameId AND private = 0");
        $stmt->bindParam(':gameId', $gameId, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPublicGameByHost($host)
    {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE hostId = :host AND private = 0");
        $stmt->bindParam(':host', $host, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPrivateGameByCode($code)
    {
        $stmt = $this->db->prepare("SELECT * FROM games WHERE code = :code AND private = 1");
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPlayersByGame($gameId)
    {
        $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE games_id_game = :gameId");
        $stmt->bindParam(':gameId', $gameId, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removePlayerFromGame($gameId, $userId)
    {
        $stmt = $this->db->prepare("UPDATE utilisateurs SET games_id_game = 0 WHERE id_utilisateur = :userId AND games_id_game = :gameId");
        $stmt->bindParam(':gameId', $gameId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function startGame($gameId)
    {
        $stmt = $this->db->prepare("UPDATE games SET status = 1 WHERE id_game = :gameId");
        $stmt->bindParam(':gameId', $gameId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function isStarted($gameId)
    {
        $stmt = $this->db->prepare("SELECT status FROM games WHERE id_game = :gameId");
        $stmt->bindParam(':gameId', $gameId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletegame($gameId)
    {
        $stmt = $this->db->prepare("DELETE FROM games WHERE id_game = :gameId");
        $stmt->bindParam(':gameId', $gameId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function setWord($gameId, $word)
    {
        $stmt = $this->db->prepare("UPDATE games SET mot = :word WHERE id_game = :gameId");
        $stmt->bindParam(':gameId', $gameId, PDO::PARAM_INT);
        $stmt->bindParam(':word', $word, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getWordByUser($userId)
    {
        $sql = "SELECT rounds.mot
        FROM rounds
        JOIN games ON rounds.games_id_game = games.id_game
        JOIN utilisateurs ON rounds.id_round = utilisateurs.rounds_id_round
        WHERE utilisateurs.id_utilisateur = :id_utilisateur";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_utilisateur', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRoundNumberById($roundId)
    {
        $stmt = $this->db->prepare("SELECT number FROM rounds WHERE id_round = :roundId");
        $stmt->bindParam(':roundId', $roundId, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRoundIdByUser($userId)
    {
        $sql = "SELECT rounds.id_round
        FROM rounds
        JOIN games ON rounds.games_id_game = games.id_game
        JOIN utilisateurs ON rounds.id_round = utilisateurs.rounds_id_round
        WHERE utilisateurs.id_utilisateur = :id_utilisateur";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_utilisateur', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
