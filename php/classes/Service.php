<?php
/**
 * @author VincentBab vincentbab@gmail.com
 * 
 *  @version : 1.0.0
 *  @date : 2020-10-10
 */
class Service
{
    /*
     * Votre demande d'accés à l'API de la FFTT a été acceptée.
     *
     *  Identifiant : SW596
     *  Mot de passe : 1Z2wDrhRP6
     *
     *  Pour chaque connexion à un script, il sera passé systématiquement:
     *      -serie: numéro de série de l'utilisateur qui émet la demande
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     */
    const _Identifiant = 'SW596';
    const _MotdePasse = '1Z2wDrhRP6';
        
    /**
     * @var string $serial Serial de l'utilisateur
     */
    protected $serial;
    
    /**
     * @var object $cache
     */
    protected $cache = false;
    
    /**
     * @var string $ipSource
     */
    protected $ipSource;
          
    public function __construct($database) {
        
        // Le licencier a t'il un numéro de serie
        // Recherche si le joueur existe
        $sql = sprintf('SELECT Serie FROM res_fftt WHERE id_licencier = "%d";', $_SESSION['id_licencier'] );
        $database->query($sql);
        $result = $database->single();
        
        // Le code ne correspond pas !
        // Non, création
        if( $result === false)
        {
            $this->setSerial();
            
            // Sauvegarde dans la table
            $database->query('INSERT INTO `res_fftt` (`id_licencier`, `Serie`) VALUES ( :id_licencier, :serie);');
            $database->bind(':id_licencier', $_SESSION['id_licencier']);
            $database->bind(':serie', $this->getSerial());
            $database->execute();
        }
        else
        {     
            //  Oui, sauvegarde
            $this->serial = $result['Serie'];
        }
        
        $this->setIpSource( gethostbyname(gethostname()) );
        
        libxml_use_internal_errors(true);
    }
    
    public function getAppId() { return self::_Identifiant; }
    
    public function getAppKey() { return self::_MotdePasse; }
    
    // $size : longueur du mot passe voulue
    public function setSerial() {
        // Initialisation des caractéres utilisables
        $chaine = str_shuffle("TPUSC5FH6E7J80VP9WXYZRN41GKQA2D3LBIM");
        
        srand((double)microtime()*1000000);
        $serial = '';
        
        for($i=0; $i<15; $i++)
            $serial .= $chaine[rand()%36];
            
        $this->serial = $serial;
    }
    
    public function getSerial() { return $this->serial; }
    
    public function setCache($cache)
    {
        $this->cache = $cache;
        
        return $this;
    }
    
    public function getCache() { return $this->cache; }
    
    public function setIpSource($ipSource)
    {
        $this->ipSource = $ipSource;
        
        return $this;
    }
    
    public function getIpSource() { return $this->ipSource; }
           
    /*
     * Paramètres d'entrée: 
     *  -serie: numéro de série attribué par l'application (15 caractéres: [A..Z] [0..9]). 
     *      Ce numéro de série doitétre initialisé 1 seule fois par utilisateur (application installée)et fait partie de toutes les requétes ultérieures
     *  -tm: Timestamp en clair
     *  -tmc: Timestamp crypté
     *  -id: ID de l'application qui émet la demande
     */   
    public function initialization()
    {
        return self::getObject($this->getData('http://www.fftt.com/mobile/pxml/xml_initialisation.php', array()));
    }
    
    /*
     * Fonction: Renvoieune liste de clubs pour un département
     * 
     * Paramétres d'entrée: 
     *  -serie: numéro de série de l'utilisateur qui émet la demande
     *  -tm: Timestamp en clair
     *  -tmc: Timestamp crypté
     *  -id: ID de l'application qui émet la demande-dep: numéro du département recherché selon la codification de la table organisme
     */
    public function getClubsByDepartement($departement)
    {
        return $this->getCachedData("clubs_{$departement}", 3600*24*7, function($service) use ($departement) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_club_dep2.php', array('dep' => $departement)), 'club');
        });
    }
    
    /*
     * Fonction: 
     *  Renvoie une liste de clubs en faisant la recherche sur: le département (en clair) ou la ville ou le nom du club ou len uméro du club ou le code postal. 
     *  Il ne faut passer qu'un seul de ces paramètres.
     *  
     *  Paramétres d'entrée: 
     *      -serie: numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *      -dep: numéro du département (75, 92, 44 ...) OU
     *      -ville: Ville de recherche ou nom du club OU
     *      -numero: numero du club (12751450, 12920066 ...) OU
     *      -code: code postal
     */
    public function getClub($numero)
    {
        return $this->getCachedData("club_{$numero}", 3600*24*7, function($service) use ($numero) {
            return Service::getObject($service->getData('http://www.fftt.com/mobile/pxml/xml_club_detail.php', array('club' => $numero)), 'club');
        });
    }
    
    public function cleanClub($numero)
    {
        if (!$this->cache) {
            return;
        }
        
        $this->cache->delete("club_{$numero}");
        $this->cache->delete("clubjoueurs_{$numero}");
        $this->cache->delete("clubequipes_{$numero}_M");
        $this->cache->delete("clubequipes_{$numero}_F");
        $this->cache->delete("clubequipes_{$numero}_");
    }
    
    /*
     * Fonction: 
     *  Renvoie un joueur provenant de la base classement
     *  
     *  Paramétres d'entrée: 
     *      -serie: numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *      -licence: numero de licence
     */
    public function getJoueur($licence)
    {
        $joueur = $this->getCachedData("joueur_{$licence}", 3600*24*7, function($service) use ($licence) {
            return Service::getObject($service->getData('http://www.fftt.com/mobile/pxml/xml_joueur.php', array('licence' => $licence, 'auto' => 1)), 'joueur');
        });
            
            if (!isset($joueur['licence'])) {
                return null;
            }
            
            if (empty($joueur['natio'])) {
                $joueur['natio'] = 'F';
            }
            
            $joueur['photo'] = "http://www.fftt.com/espacelicencie/photolicencie/{$joueur['licence']}_.jpg";
            $joueur['progmois'] = round($joueur['point'] - $joueur['apoint'], 2); // Progression mensuelle
            $joueur['progann'] = round($joueur['point'] - $joueur['valinit'], 2); // Progression annuelle
            
            return $joueur;
    }
    
    public function cleanJoueur($licence)
    {
        if (!$this->cache) {
            return;
        }
        
        $this->cache->delete("joueur_{$licence}");
        $this->cache->delete("joueurparties_{$licence}");
        $this->cache->delete("joueurspid_{$licence}");
    }
    
    /*
     * Fonction: 
     *  Renvoie une liste des parties déun joueur de la base des classements mysql
     *  
     *  Paramétres d'entrée: 
     *      -serie: numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: IDde l'application qui émet la demande
     *      -licence: numero de licence
     */
    public function getJoueurParties($licence)
    {
        return $this->getCachedData("joueurparties_{$licence}", 3600*24*7, function($service) use ($licence) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_partie_mysql.php', array('licence' => $licence, 'auto' => 1)), 'partie');
        });
    }
    
    /*
     * Fonction: 
     *  Renvoie une liste des parties déun joueur de la base SPID
     *  
     * Paramétres d'entrée: 
     *  -serie: numéro de série de l'utilisateur qui émet la demande 
     *  -tm: Timestamp en clair
     *  -tmc: Timestamp crypté
     *  -id: ID de l'application qui émet la demande
     *  -numlic: numero de licence
     */  
    public function getJoueurPartiesSpid($licence)
    {
        return $this->getCachedData("joueurspid_{$licence}", 3600*24*1, function($service) use ($licence) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_partie.php', array('numlic' => $licence)), 'resultat');
        });
    }
    
    /*
     * Fonction: 
     *  Renvoie léhistorique classement déun joueur
     *  
     * Paramétres d'entrée: 
     *      -serie: numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *      -numlic: numéro de licence
     */
    public function getJoueurHistorique($licence)
    {
        return $this->getCachedData("joueur_historique_{$licence}", 3600*24*2, function($service) use ($licence) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_histo_classement.php', array('numlic' => $licence)), 'histo');
        });
    }
    
    /*
     * Fonction:
     *  Renvoie une liste des joueurs provenant de la base classement
     *  
     * Paramétres d'entrée: 
     *      -serie: numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *      -nom: nom dujoueur (optionnel)-prenom: (optionnel) NB: il faut passer en paramétre club ou nom (plus prénom éventuellement)
     */
    public function getJoueursByName($nom, $prenom= '')
    {
        return $this->getCachedData("joueurs_{$nom}_{$prenom}", 3600*24*7, function($service) use ($nom, $prenom) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_liste_joueur.php', array('nom' => $nom, 'prenom' => $prenom)), 'joueur');
        });
    }
    
    /*
     * Fonction:
     *  Renvoie une liste des joueurs provenant de la base classement
     *
     * Paramétres d'entrée:
     *      -serie: numéro de série de l'utilisateur qui émet la demande
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *      -club: numéro du club (optionnel)
     */
    public function getJoueursByClub($club)
    {
        return $this->getCachedData("clubjoueurs_{$club}", 3600*24*7, function($service) use ($club) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_liste_joueur.php', array('club' => $club)), 'joueur');
        });
    }
    
    /*
     * Fonction: 
     *  Renvoie une liste des équipes déun club
     *  
     *  Paramétres d'entrée: 
     *      -serie: numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *      -numclu: numéro du club
     *      -type:  M pour les équipes du championnat de France masculin, 
     *              F pour les équipes du championnat de France Féminin, 
     *              A pour les équipes Masculines et Féminines du championnat de France, 
     *              rien pour toutes les autres équipe
     */
    public function getEquipesByClub($club, $type = null)
    {
        if ($type && !in_array($type, array('M', 'F'))) {
            $type = 'M';
        }
        
        $teams = $this->getCachedData("clubequipes_{$club}_{$type}", 3600*24*7, function($service) use ($club, $type) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_equipe.php', array('numclu' => $club, 'type' => $type)), 'equipe');
        });
            
            foreach($teams as &$team) {
                $params = array();
                parse_str($team['liendivision'], $params);
                
                $team['idpoule'] = $params['cx_poule'];
                $team['iddiv'] = $params['D1'];
            }
            
            return $teams;
    }
    
    /*
     * Fonction:
     *  Renvoie les résultats ou classement d'une poule de championnat par équipes
     *  
     * Paramétres d'entrée: 
     *      -serie: numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *          Si épreuve par équipes
     *      -action: épouleé= récupérer les différentes poules, 
     *               éclassementé= récupérer le classement , 
     *               éinitialé = récupérer les clubs dans léordre de la poule, action vide = récupérer les rencontres
     *      -auto: 1
     *      -D1: id de la division
     *      -cx_poule: id de la poule demandée (optionnel. Si omis, positionné sur la premiére poule)
     */
    public function getPoules($division)
    {
        $poules = $this->getCachedData("poules_{$division}", 3600*24*7, function($service) use ($division) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_result_equ.php', array('action' => 'poule', 'D1' => $division)), 'poule');
        });
            
            foreach($poules as &$poule) {
                $params = array();
                parse_str($poule['lien'], $params);
                
                $poule['idpoule'] = $params['cx_poule'];
                $poule['iddiv'] = $params['D1'];
            }
            
            return $poules;
    }
    
    /*
     * idem
     */
    public function getPouleClassement($division, $poule = null)
    {
        return $this->getCachedData("pouleclassement_{$division}_{$poule}", 3600*24*1, function($service) use ($division, $poule) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_result_equ.php', array('auto' => 1, 'action' => 'classement', 'D1' => $division, 'cx_poule' => $poule)), 'classement');
        });
    }
    
    /*
     * idem
     */
    public function getPouleRencontres($division, $poule = null)
    {
        return $this->getCachedData("poulerencontres_{$division}_{$poule}", 3600*24*1, function($service) use ($division, $poule) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_result_equ.php', array('auto' => 1, 'D1' => $division, 'cx_poule' => $poule)), 'tour');
        });
    }
    
    /*
     * Fonction:
     *  Renvoie les résultats ou classement d'une poule de championnat par équipes
     *  
     * Paramétres d'entrée: 
     *      -serie: numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *          Si épreuve par équipes-action: 
     *              épouleé= récupérer les différentes poules, 
     *              éclassementé= récupérer le classement , 
     *              éinitialé = récupérer les clubs dans léordre de la poule, 
     *              action vide = récupérer les rencontres
     *      -auto: 1
     *      -D1: id de la division
     *      -cx_poule: id de la poule demandée (optionnel. Si omis, positionné sur la premiére poule
     */
    public function getIndivGroupes($division)
    {
        $groupes = $this->getCachedData("groupes_{$division}", 3600*24*7, function($service) use ($division) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_result_indiv.php', array('action' => 'poule', 'res_division' => $division)), 'tour');
        });
            
            foreach($groupes as &$groupe) {
                $params = array();
                parse_str($groupe['lien'], $params);
                
                if (isset($params['cx_tableau'])) {
                    $groupe['idgroupe'] = $params['cx_tableau'];
                } else {
                    $groupe['idgroupe'] = null;
                }
                $groupe['iddiv'] = $params['res_division'];
            }
            
            return $groupes;
    }
    
    /*
     * idem
     */
    public function getGroupeClassement($division, $groupe = null)
    {
        return $this->getCachedData("groupeclassement_{$division}_{$groupe}", 3600*24*1, function($service) use ($division, $groupe) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_result_indiv.php', array('action' => 'classement', 'res_division' => $division, 'cx_tableau' => $groupe)), 'classement');
        });
    }
    
    /*
     * idem
     */
    public function getGroupeRencontres($division, $groupe = null)
    {
        return $this->getCachedData("grouperencontres_{$division}_{$groupe}", 3600*24*1, function($service) use ($division, $groupe) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_result_indiv.php', array('action' => 'partie', 'res_division' => $division, 'cx_tableau' => $groupe)), 'partie');
        });
    }
    
    /*
     * Fonction:
     *  Renvoie une liste des organismes
     *  
     * Paramétres d'entrée:
     *  -serie: numéro de série de l'utilisateur qui émet la demande
     *  -tm: Timestamp en clair
     *  -tmc: Timestamp crypté
     *  -id: ID de l'application qui émet la demande
     *  -type: Type déorganisme (F = Fédération, Z = Zone, L=Ligue, D=Département)
     *  -pere: paramétre optionnel (ID) qui renverra seulement les organismes dont le pére est spécifié
     */ 
    public function getOrganismes($type)
    {
        // Zone / Ligue / Departement
        if (!in_array($type, array('Z', 'L', 'D'))) {
            $type = 'L';
        }
        
        return $this->getCachedData("organismes_{$type}", 3600*24*30, function($service) use ($type) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_organisme.php', array('type' => $type)), 'organisme');
        });
    }
    
    /*
     * Fonction:
     *  Renvoie une liste des épreuves pour un organismeParamétres d'entrée:
     *      -serie:numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *      -organisme: id unique de léorganisme
     *      -type: type déépreuve (E = Equipes, I = Individuelles
     */
    public function getEpreuves($organisme, $type)
    {
        // Equipe / Individuelle
        if (!in_array($type, array('E', 'I'))) {
            $type = 'E';
        }
        
        return $this->getCachedData("epreuves_{$organisme}_{$type}", 3600*24*30, function($service) use ($organisme, $type) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_epreuve.php', array('type' => $type, 'organisme' => $organisme)), 'epreuve');
        });
    }
    
    /*
     * Fonction:
     *  Renvoie une liste des divisions pour une épreuve donnée
     *  
     * Paramétres d'entrée: 
     *      -serie: numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *      -organisme: id de léorganisme
     *      -epreuve: id de léépreuve
     *      -type:2
     *          type déépreuve (E = Equipe, I = Individuelle)
     */
    public function getDivisions($organisme, $epreuve, $type = 'E')
    {
        // Equipe / Individuelle
        if (!in_array($type, array('E', 'I'))) {
            $type = 'E';
        }
        
        return $this->getCachedData("divisions_{$organisme}_{$epreuve}_{$type}", 3600*24*7, function($service) use ($organisme, $epreuve, $type) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_division.php', array('organisme' => $organisme, 'epreuve' => $epreuve, 'type' => $type)), 'division');
        });
    }
    
    /*
     * Fonction:
     *  Renvoie les informations détaillées d'une rencontre
     *  
     * Paramétres d'entrée: 
     *      -serie: numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -is_retour
     *      -phase
     *      -res_1
     *      -res_2
     *      -renc_id
     *      -equip_1
     *      -equip_2
     *      -equip_id1
     *      -equip_id2
     *      
     *      cesparamètres en surbrillance sont donnés par léinfo élienérenvoyé par xml_result_equ.php définis ci-dessus.
     */
    public function getRencontre($link)
    {
        $params = array();
        parse_str($link, $params);
        
        return $this->getCachedData("rencontre_".sha1($link), 3600*24*1, function($service) use ($params) {
            return Service::getObject($service->getData('http://www.fftt.com/mobile/pxml/xml_chp_renc.php', $params), null);
        });
    }
    
    /*
     * Fonction:
     *  Renvoie une liste des joueurs provenant de la base des licencies spid
     *  
     * Paramétres d'entrée: 
     *      -serie: numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *      -licence: numero de licence (optionnel)
     *      -nom: nom du joueur (optionnel)
     *      -prenom: (optionnel) 
     *      -valid: (optionnel) par défaut tous les joueurs. 
     *              Si valid = 1 ,seuls les joueurs validés sont retournés.
     *      
     * NB: il faut passer en paramétre club ou licence ou nom (plus prénom éventuellement)
     */
    public function getLicencesByName($nom, $prenom= '')
    {
        return $this->getCachedData("licences_{$nom}_{$prenom}", 3600*24*2, function($service) use ($nom, $prenom) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_liste_joueur_o.php', array('nom' => strtoupper($nom), 'prenom' => ucfirst($prenom))), 'joueur');
        });
    }
    
    /*
     * Fonction:
     *  Renvoie une liste des joueurs provenant de la base des licencies spid
     *
     * Paramétres d'entrée:
     *      -serie: numéro de série de l'utilisateur qui émet la demande
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *      -club: numéro du club (optionnel)
     *      -valid: (optionnel) par défaut tous les joueurs.
     *          Si valid = 1 ,seuls les joueurs validés sont retournés.
     */
    public function getLicencesByClub($club)
    {
        return $this->getCachedData("licencesclub_{$club}", 3600*24*2, function($service) use ($club) {
            return Service::getCollection($service->getData('http://www.fftt.com/mobile/pxml/xml_liste_joueur_o.php', array('club' => $club)), 'joueur');
        });
    }
    
    /*
     * Fonction:
     *  Renvoie un joueur provenant de la base des licencies SPID
     *  
     * Paramètres d'entrée: 
     *      -serie: numéro de série de l'utilisateur qui émet la demande 
     *      -tm: Timestamp en clair
     *      -tmc: Timestamp crypté
     *      -id: ID de l'application qui émet la demande
     *      -licence: numéro de licence
     */
    public function getLicence($licence)
    {
        return $this->getCachedData("licence_{$licence}", 3600*24*2, function($service) use ($licence) {
            return Service::getObject($service->getData('http://www.fftt.com/mobile/pxml/xml_licence.php', array('licence' => $licence)), 'licence');
        });
    }
    
    protected function getCachedData($key, $lifeTime, $callback)
    {
        if (!$this->cache) {
            return $callback($this);
        }
        
        if (false === ($data = $this->cache->fetch($key))) {
            $data = $callback($this);
            
            if ($data !== false) {
                $this->cache->save($key, $data, $lifeTime);
            }
        }
        
        return $data;
    }
    
    public function getData($url, $params = array(), $generateHash = true)
    {
        if ($generateHash) {
            $params['serie'] = $this->getSerial();
            $params['id'] = $this->getAppId();
            $params['tm'] = date('YmdHis') . substr(microtime(), 2, 3);
            $params['tmc'] =  hash_hmac('sha1', $params['tm'], hash('md5', $this->getAppKey(), false));
        }
        
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        
        if ($this->getIpSource()) {
            // Le nom de l'interface à utiliser. Cela peut être le nom d'une interface, une adresse IP ou encore le nom de l'hôte.
            curl_setopt($curl, CURLOPT_INTERFACE, $this->getIpSource());
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER , true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Accept:", // Suprime le header par default de cUrl (Accept: */*)
            "User-agent: Mozilla/4.0 (compatible; MSIE 6.0; Win32)",
            "Content-Type: application/x-www-form-urlencoded",
            "Accept-Encoding: gzip",
            "Connection: Keep-Alive",
        ));
        $data = curl_exec($curl);
        curl_close($curl);
                   
        $xml = simplexml_load_string($data);
        
        if (!$xml) {
            return false;
        }
        
        // Petite astuce pour transformer simplement le XML en tableau
        return json_decode(json_encode($xml), true);
    }
    
    public static function getCollection($data, $key = null)
    {
        if (empty($data)) {
            return array();
        }
        
        if ($key) {
            if (!array_key_exists($key, $data)) {
                return array();
            }
            $data = $data[$key];
        }
        
        return isset($data[0]) ? $data : array($data);
    }
    
    public static function getObject($data, $key = null)
    {
        if ($key && $data !== false) {
            return array_key_exists($key, $data) ? $data[$key] : null;
        } else {
            return empty($data) ? null : $data;
        }
    }   
}
