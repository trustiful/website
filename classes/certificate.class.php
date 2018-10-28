<?php

require_once '../includes/myPDO.php';

class Certificate implements JsonSerializable
{

    /**
     * @var int
     */
    private $id_certificate;

    /**
     * @var int
     */
    private $id_website;

    /**
     * @var int
     */
    private $shipping_time;

    /**
     * @var int
     */
    private $dispute;

    /**
     * @var int
     */
    private $return_policy;

    /**
     * @var int
     */
    private $customer_service;

    /**
     * @var int
     *
     *  0 : vertical
     *  1 : horizontal
     */
    private $position;

    /**
     * @var DateTime
     */
    private $created_at;

    /**
     * @var DateTime
     */
    private $updated_at;

    const UNIQUE_FIELDS = ['id_website', 'id_certificate'];

    /**
     * Certificate constructor.
     * @param $id_certificate
     * @param $id_website
     * @param int $shipping_time
     * @param int $dispute
     * @param int $return_policy
     * @param int $customer_service
     * @param $position
     * @param DateTime $created_at
     * @param DateTime $updated_at
     */
    public function __construct($id_certificate, $id_website, $shipping_time, $dispute, $return_policy, $customer_service, $position, $created_at, $updated_at)
    {
        $this->id_certificate = $id_certificate;
        $this->id_website = $id_website;
        $this->shipping_time = $shipping_time;
        $this->dispute = $dispute;
        $this->return_policy = $return_policy;
        $this->customer_service = $customer_service;
        $this->position = $position;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function insertCertificate($id_website, $shipping_time, $dispute, $return_policy, $customer_service, $position)
    {
        $pdo = myPDO::getInstance();
        $statement = $pdo->prepare(<<<SQL
          INSERT INTO certificate (id_website, shipping_time, dispute, return_policy, customer_service, position) VALUES (?,?,?,?,?,?)
SQL
        );
        try {
            $statement->execute(array($id_website, $shipping_time, $dispute, $return_policy, $customer_service, $position));
            return new Certificate($pdo->lastInsertId(), $id_website, $shipping_time, $dispute, $return_policy, $customer_service, $position, new DateTime(), new DateTime());

        } catch (PDOException $err) {
            throw new PDOException($err->getMessage());
        }
    }

    public static function updateCertificate($id_certificate, $shipping_time , $dispute, $return_policy, $customer_service, $position)
    {
        $pdo = myPDO::getInstance();
        $statement = $pdo->prepare('UPDATE certificate SET shipping_time = ?, dispute = ?, return_policy = ?, customer_service = ?, position = ? WHERE id_certificate = ?');
        try {
            $statement->execute(array($shipping_time, $dispute, $return_policy, $customer_service, $position, $id_certificate));

            return self::getCerficate($id_certificate);

        } catch (PDOException $err) {
            throw new PDOException($err->getMessage());
        }
    }

    /**
     * @param $id_certificate
     * @return website
     */
    public static function getCerficate($id_certificate)
    {

        $pdo = myPDO::getInstance();
        $statement = $pdo->prepare('SELECT * FROM certificate WHERE id_certificate = ?');
        try {
            $statement->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Certificate', array('id_certificate', 'id_website', 'shipping_time', 'dispute', 'return_policy', 'customer_service', 'position', 'created_at', 'updated_at'));
            $statement->execute(array($id_certificate));
            $certificate = $statement->fetch();
            return $certificate;

        } catch (PDOException $err) {
            throw new PDOException($err->getMessage());
        }
    }


    public static function deleteCertificate($field, $value){
        if(!in_array($field, self::UNIQUE_FIELDS)){
            throw new Exception('Vous ne pouvez pas supprimer un certificat sur le critère : '.$field);

        }
        $pdo = myPDO::getInstance();
        $statement = $pdo->prepare('DELETE FROM certificate WHERE '. $field .' = ?');
        try {
            $statement->execute(array($value));
        } catch (PDOException $err) {
            throw new PDOException($err->getMessage());
        }
    }
    /**
     * Return the certificate and the script as the HTML modal wanted
     */
    public function toHTML($subscription)
    {
        $html = '';
        $html .= ($subscription == 1) ? '<div class="trustiful" id="trustiful">' : '<div class="trustiful_free" id="trustiful">';
        $html .= '
        <div class="first-body">
            <img src="../src/img/logo.png" class="img-fluid"/><br>
            <p class="trusted tf-p" >Achat confiance</p>
            <p class="evaluated tf-p">Commerçant &eacutevalu&eacute</p>
            <p class="last-evaluation tf-p">Derni&egravere &eacutevaluation : '. $this->getUpdatedAtFormated() .'</p>
            <div class="tf-banner">
                <span class="tf-span-black">trust</span><span class="white">iful</span>
            </div>
        </div>
    </div>
    <div class="modal fade" id="certificate" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header" >
                <span class="text-header"> Achetez en toute confiance</span>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="container col-md-12">
                    <div class="row bg-grey" >
                        <div class="col-md-4" id="nbDispute">' .
                $this->getDispute() . '
                        </div>
                        <div class="col-md-4" id="dispute">
                            ' . ($this->getDispute() > 1 ? 'Litiges' : 'Litige') . ' en cours 
                        </div>
                        <div class="col-md-4">
                            <img src="../src/img/tick.png"/>
                        </div>
                    </div>
                </div>
                <div class="container col-md-12">
                    <div class="row bg-grey" >
                        <div class="col-md-4">
                            <img src="../src/img/shipped.png" style="width: 30%; height: auto;">
                        </div>
                        <div class="col-md-4" id="shipped">
                            <p class="tf-p black">Chez vous </p>
                            <p class="tf-p green">rapidement</p>
                        </div>
                        <div class="col-md-4" id="last_column_info">
                            ' . $this->getShippingTime() . ' h
                        </div>
                    </div>
                </div>
                <div class="container col-md-12">
                    <div class="row bg-grey" >
                        <div class="col-md-4">
                            <img src="../src/img/return.png" style="width: 30%; height: auto;">
                        </div>
                        <div class="col-md-4" id="shipped">
                            <p class="tf-p black">Vous pouvez </p>
                            <p class="tf-p green">changer d\'avis</p>
                        </div>
                        <div class="col-md-4" id="last_column_info">
                            ' . $this->getReturnPolicy() . ' j
                        </div>
                    </div>
                </div>
                <div class="container col-md-12">
                    <div class="row bg-grey" >
                        <div class="col-md-4">
                            <img src="../src/img/operator.png" style="width: 30%; height: auto;">
                        </div>
                        <div class="col-md-4" id="shipped">
                            <p class="tf-p black">R&eacuteactivit&eacute </p>
                            <p class="tf-p green">service client</p>
                        </div>
                        <div class="col-md-4" id="last_column_info">
                            ' . $this->getCustomerService() . ' h
                        </div>
                    </div>
                </div>
                 <div class="modal-footer">
                <div class="container col-md-12">
                    <div class="row">
                        <div class="col-md-6" id="text-footer">
                            <p class="bestExp tf-p">La meilleure exp&eacuterience </p>
                            <p class="bestExp tf-p">d\'achat possible</p>
                        </div>
                        <div class="col-md-6" id="img-footer">
                            <img src="../src/img/withTick.png" style="width: 70%; height: auto;">
                        </div>
                    </div>
              </div>
            </div>
            </div>
         </div>     
     </div>
';
        return $html;
    }

    public function jsonSerialize() {
        return [
            'id_certificate' => $this->getIdCertificate(),
            'id_website' => $this->getIdWebsite(),
            'shipping_time' => $this->getShippingTime(),
            'dispute' => $this->getDispute(),
            'return_policy' => $this->getReturnPolicy(),
            'customer_service' => $this->getCustomerService(),
            'position' => $this->getPosition(),
            'created_at' => $this->getCreatedAtFormated(),
            'updated_at' => $this->getUpdatedAtFormated()
        ];
    }


#################################################
#################################################
#############  Getters and Setters  #############
#################################################
#################################################

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
     * @return int
     */
    public function getShippingTime()
    {
        return $this->shipping_time;
    }

    /**
     * @param int $shipping_time
     */
    public function setShippingTime($shipping_time)
    {
        $this->shipping_time = $shipping_time;
    }

    /**
     * @return int
     */
    public function getDispute()
    {
        return $this->dispute;
    }

    /**
     * @param int $dispute
     */
    public function setDispute($dispute)
    {
        $this->dispute = $dispute;
    }

    /**
     * @return int
     */
    public function getReturnPolicy()
    {
        return $this->return_policy;
    }

    /**
     * @param int $return_policy
     */
    public function setReturnPolicy($return_policy)
    {
        $this->return_policy = $return_policy;
    }

    /**
     * @return int
     */
    public function getCustomerService()
    {
        return $this->customer_service;
    }

    /**
     * @param int $customer_service
     */
    public function setCustomerService($customer_service)
    {
        $this->customer_service = $customer_service;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param DateTime $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

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
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getUpdatedAtFormated(){
        $formatedDate = new DateTime($this->getUpdatedAt());
        return $formatedDate->format('d/m/y');
    }

    /**
     * @return string
     */
    public function getCreatedAtFormated(){
        $formatedDate = new DateTime($this->getCreatedAt());
        return $formatedDate->format('d/m/y');
    }
}