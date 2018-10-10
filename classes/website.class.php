<?php

require_once '../includes/myPDO.php';

class Website
{

    /**
     * @var int
     */
    private $id_website;

    /**
     * @var int
     */
    private $id_user;

    /**
     * @var int
     */
    private $id_certificate;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $rcs_number;

    /**
     * @var int
     *
     *  0 : free subscription
     *  1 : payment subscription
     **/

    private $subscription;

    /**
     * @var int
     */
    private $evaluation_note;

    /**
     * @var string
     */
    private $screen_website;

    /**
     * Unique Fields which allows to identify an unique row into the database
     */
    const UNIQUE_FIELDS = ['id_website', 'url'];

    /**
     * Website constructor.
     * @param $id_website
     * @param $id_user
     * @param $id_certificate
     * @param $url
     * @param $address
     * @param $phone
     * @param $rcs_number
     * @param $subscription
     * @param $evaluation_note
     * @param $screen_website
     */
    public function __construct($id_website, $id_user, $id_certificate, $url, $address, $phone, $rcs_number, $subscription, $evaluation_note, $screen_website)
    {
        $this->id_website = $id_website;
        $this->id_user = $id_user;
        $this->id_certificate = $id_certificate;
        $this->url = $url;
        $this->address = $address;
        $this->phone = $phone;
        $this->rcs_number = $rcs_number;
        $this->subscription = $subscription;
        $this->evaluation_note = $evaluation_note;
        $this->screen_website = $screen_website;
    }


    /**
     *  Update the row of the current instance with its current attributes
     */
    public function update(){
        $pdo = myPDO::getInstance();
        $statement = $pdo->prepare('
          UPDATE website 
          SET id_user = ?, id_certificate = ?, url = ?, address = ?, phone = ? , rcs_number = ?, subscription = ?, evaluation_note = ?, screen_website = ?
          WHERE id_website = '. $this->getIdWebsite() .'
            ');
        try{
            $statement->execute(array($this->getIdUser(), $this->getIdCertificate(), $this->getUrl(), $this->getAddress(), $this->getPhone(), $this->getRcsNumber(), $this->getSubscription(), $this->getEvaluationNote(), $this->getScreenWebsite()));
            echo 'pouet';
        }catch (Exception $err){
            echo($err->getMessage());
        }

    }


    /**
     * @param $id_user
     * @param $url
     * @param $address
     * @param $phone
     * @param $rcs_number
     * @param $subscription
     * @param $evaluation_note
     * @param null $screen_website
     * @return Website
     */
    public static function insertWebsite($id_user, $url, $address, $phone, $rcs_number, $subscription, $evaluation_note, $screen_website = null)
    {
        $pdo = myPDO::getInstance();
        $statement = $pdo->prepare('INSERT INTO website (id_user, url, address, phone, rcs_number, subscription, evaluation_note, screen_website) VALUES (?,?,?,?,?,?,?,?)');
        try{
            $statement->execute(array($id_user, $url, $address, $phone, $rcs_number, $subscription, $evaluation_note, $screen_website));

            return new Website($pdo->lastInsertId(),$id_user, null, $url, $address, $phone, $rcs_number, $subscription, $evaluation_note, $screen_website);

        }catch (Exception $err){
            echo($err->getMessage());
        }

    }

    /**
     * @param $field
     * @param $value
     * @return website
     * @throws Exception
     */
    public static function getWebsiteBy($field, $value){
        if(!in_array($field, self::UNIQUE_FIELDS)){
            throw new Exception('Vous ne pouvez pas obtenir un site web unique sur le critère : '.$field);

        }
        $pdo = myPDO::getInstance();
        $statement = $pdo->prepare('SELECT * FROM website WHERE '. $field .' = ?');
        try{
            $statement->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,'Website', array('id_website', 'id_user', 'id_certificate', 'url', 'address', 'phone', 'rcs_number', 'subscription', 'evaluation_note', 'screen_website'));
            $statement->execute(array($value));
            $website = $statement->fetch();
            if($website !== false) {
                return $website;
            }
            else{
                throw new Exception('Aucun site web n\'a été trouvé');
            }
        }catch (Exception $err){
            echo($err->getMessage());
        }
    }


    public function getCertificate()
    {
        $pdo = myPDO::getInstance();
        $statement = $pdo->prepare(
            <<<SQL
        SELECT * FROM certificate WHERE id_website = ?
SQL
        );
        try {
            $statement->setFetchMode(
                PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,
                'Certificate',
                array('$d_certificate', 'id_website', 'shipping_time', 'dispute', 'return_policy', 'customer_service', 'position', 'created_at', 'updated_at')
            );
            $statement->execute(array($this->getIdWebsite()));
            $certificate = $statement->fetch();
            return ($certificate !== false) ? $certificate : null;
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
    public function getIdWebsite()
    {
        return $this->id_website;
    }

    /**
     * @param int $id_website
     */
    public function setIdWebsite($id_website)
    {
        $this->id_website = $id_website;
    }

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
     * @return int
     */
    public function getIdCertificate()
    {
        return $this->id_certificate;
    }

    /**
     * @param int $id_certificate
     */
    public function setIdCertificate($id_certificate)
    {
        $this->id_certificate = $id_certificate;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getRcsNumber()
    {
        return $this->rcs_number;
    }

    /**
     * @param string $rcs_number
     */
    public function setRcsNumber($rcs_number)
    {
        $this->rcs_number = $rcs_number;
    }

    /**
     * @return int
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param int $subscription
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * @return int
     */
    public function getEvaluationNote()
    {
        return $this->evaluation_note;
    }

    /**
     * @param int $evaluation_note
     */
    public function setEvaluationNote($evaluation_note)
    {
        $this->evaluation_note = $evaluation_note;
    }

    /**
     * @return string
     */
    public function getScreenWebsite()
    {
        return $this->screen_website;
    }

    /**
     * @param string $screen_website
     */
    public function setScreenWebsite($screen_website)
    {
        $this->screen_website = $screen_website;
    }

}