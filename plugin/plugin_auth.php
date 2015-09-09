<?php
/*
This file is part of Mkframework.

Mkframework is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 3 of the License.

Mkframework is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with Mkframework.  If not, see <http://www.gnu.org/licenses/>.

*/
/** 
* plugin_auth classe pour gerer l'authentification
* @author Mika
* @link http://mkf.mkdevs.com/
*/
class plugin_auth extends abstract_auth{
	
	private $oAccount=null;

	public function setAccount($oAccount){
		$_SESSION['oAccount']=serialize($oAccount);
		$this->oAccount=$oAccount;
	}

	public function getAccount(){
		return $this->oAccount;
	}

	/**
	* methode appele a la connexion
	* @access public
	* @return bool retourne true/false selon que la personne est ou non authentifiee
	*/
	public function isConnected(){
		if(!$this->_isConnected()){
			return false;
		}

		$this->setAccount(unserialize($_SESSION['oAccount']));

		//ajouter critere supp pour verification de l'authentification
		return true;
	}
	/**
	* verifie si le couple login/pass est present dans le tableau
	* @access public
	* @param array $tElements tableau respectant la structure suivante: $array[login][pass]
	* @param string $sLogin login a verifier
	* @param string $sPass mot de passe a verifier
	* @return bool retourne true/false selong le couple login/mot de passe est correcte ou non
	*/
	public function checkLoginPass($tElements,$sLogin,$sPass){
		return $this->verifLoginPass($tElements,$sLogin,$sPass);
	}
	/**
	* verifie si le couple login/pass est present dans le tableau
	* @access public
	* @param array $tElements tableau respectant la structure suivante: $array[login][pass]
	* @param string $sLogin login a verifier
	* @param string $sPass mot de passe a verifier
	* @return bool retourne true/false selong le couple login/mot de passe est correcte ou non
	*/
	public function verifLoginPass($tElements,$sLogin,$sPass){
		if(isset($tElements[$sLogin][$sPass])){
			$this->_connect();
			$this->setAccount($tElements[$sLogin][$sPass]);
			
			return true;
		}
		return false;
	}
	
        /**
         * comptabilise les tentatives de connexion échues sur un compte existant
         * @param array $tElements tableau respectant la structure suivante: $array[login][pass]
         * @param string $sLogin login a verifier
         * @param int $maxLoginEchec valeur exprimant le de tentative minimum pour vérouiller un compte.
         * @return boolean retourne true/false selon si le compte est actif ou pas.
         */
        
        public function verifLoginError($tElements,$sLogin,$maxLoginEchec){
            
		if(isset($tElements[$sLogin])) {
                    $oUserReconnu=model_account::getInstance()->findByLogin($sLogin);
                    $oUserReconnu->ipLogin=$_SERVER["REMOTE_ADDR"];
                    $oUserReconnu->echecLogin=$oUserReconnu->echecLogin+1;
                        $oUserReconnu->save();
                        if ($oUserReconnu->echecLogin >= $maxLoginEchec ){
                            $oUserReconnu->ipLogin=$_SERVER["REMOTE_ADDR"];
                            $oUserReconnu->active=0;
                            $oUserReconnu->save(); 
                            return true;   
                    }
                } return false;
	}
        
        /**
         * On vérifie que le compte est toujours actif.
         * S'il l'est on remet le compteur echec à zéro et on enregistre sa connexion.
         * @param string $sLogin login a verifier
         * @return boolean retourne true/false selon si le compte est actif ou pas.
         */
        public function verifLoginActiv($sLogin) {
            $oUserReconnu=model_account::getInstance()->findByLogin($sLogin); 
            if($oUserReconnu->active != 0){
                $oUserReconnu->ipLogin=$_SERVER["REMOTE_ADDR"];
                $oUserReconnu->lastLogin=$oUserReconnu->presentLogin;
                $oUserReconnu->echecLogin=0;
                $oUserReconnu->presentLogin=date('Y-m-d H:i:s',time());
                $oUserReconnu->save();
                return true;
            }
            return false;
        }
        
	/**
	* methode appele a la deconnexion
	* @access public
	*/
	public function logout(){
		$this->_disconnect();
		_root::redirect('auth::login');
	}
	
}
