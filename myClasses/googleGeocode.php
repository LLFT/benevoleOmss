<?php
class my_googleGeocode{
    
    protected $sAdressPostal;
    protected $iNbRequetes=0;




    public function __construct(){
        $this->sAdressPostal='42000 Saint Etienne';
    }
    
    public function setAdress($sAdressPostal){
        $this->sAdressPostal=$sAdressPostal;
    }
    
    private function getLatLong(){
        
        /*
         * Le géocoadage multiple est limité par Google 5 requetes/sec.
         * On tente ici de réguler les requetes. 
         */
        
        $this->iNbRequetes++;
        if ($this->iNbRequetes>=5){
            sleep(2);
            $this->iNbRequetes=0;
        }        
        $retour=array();
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($this->sAdressPostal);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);
        curl_close($ch);
        if($response['status'] == "OK"){
            $retour['lat'] = $response['results'][0]['geometry']['location']['lat'];
            $retour['lng'] = $response['results'][0]['geometry']['location']['lng'];
            return $retour;
        }elseif($response['status'] == 'OVER_QUERY_LIMIT'){
            return $response['status'];
        }  else {
            echo "Problème : inconnu : ";
            var_dump($response);
            die();
        }
    }
    
    private function setCoordInTable($oMembreID,$tCoord=NULL){
        if(!empty($tCoord)){
            if(count($tCoord)>1){
                $oMembreEdit = model_membres::getInstance()->findById($oMembreID);
                $oMembreEdit->coord='1';
                $oMembreEdit->lat=$tCoord['lat'];
                $oMembreEdit->lng=$tCoord['lng'];
                $oMembreEdit->modifier=date('Y-m-d H:i:s',time());
                $oMembreEdit->save();
            }else{
                echo 'Problème avec le membre dont l\'ID est '.$oMembreID."\n\r . Le géocoadage multiple est limité par Google 5 requetes/sec.(OVER_QUERY_LIMIT) \n\r Je vous invite à recommencer plus tard.";
                var_dump($tCoord);
                die();
            }
        }
    }
    
    public function findLocalisationForOneMember($oMembre){
        $this->sAdressPostal = $oMembre->numero.','.$oMembre->rue.','.$oMembre->ville.','.$oMembre->codePostal;
        $tCoord = $this->getLatLong();
        $this->setCoordInTable($oMembre->idMembre, $tCoord);
    }
    
    public function findLocalisationForManyMembers($oMembres){
        ini_set('max_execution_time', 0);
        $i=0;
        foreach ($oMembres as $oMembre) {
            $this->findLocalisationForOneMember($oMembre);
            $i++;
        }
        ini_restore('max_execution_time');
        return $i;
    }
}
