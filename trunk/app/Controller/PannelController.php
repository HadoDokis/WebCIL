<?php

/**
 * PannelController
 * Controller du pannel
 *
 * WebCIL : Outil de gestion du Correspondant Informatique et Libertés.
 * Cet outil consiste à accompagner le CIL dans sa gestion des déclarations via 
 * le registre. Le registre est sous la responsabilité du CIL qui doit en 
 * assurer la communication à toute personne qui en fait la demande (art. 48 du décret octobre 2005).
 * 
 * Copyright (c) Adullact (http://www.adullact.org)
 *
 * Licensed under The CeCiLL V2 License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 * 
 * @copyright   Copyright (c) Adullact (http://www.adullact.org)
 * @link        https://adullact.net/projects/webcil/
 * @since       webcil v0.9.0
 * @license     http://www.cecill.info/licences/Licence_CeCILL_V2-fr.html CeCiLL V2 License
 * @version     v0.9.0
 * @package     App.Controller
 */
class PannelController extends AppController {

    public $uses = [
        'Pannel',
        'Fiche',
        'Users',
        'OrganisationUser',
        'Droit',
        'EtatFiche',
        'Commentaire',
        'Notification',
        'Historique',
        'Organisation'
    ];
    public $components = ['FormGenerator.FormGen', 'Droits'];

    /**
     * Accueil de la page, listing des fiches et de leurs catégories
     * 
     * @access public
     * @created 02/12/2015
     * @version V0.9.0
     */
    public function index() {
        $this->Session->write('nameController', "pannel");
        $this->Session->write('nameView', "index");
        
        if (!$this->Droits->authorized(1)) {
            $this->redirect(['controller' => 'pannel', 'action' => 'inbox']);
        }
        $this->set('title', __d('pannel', 'pannel.titreTraitement'));
        
        
        // Requète récupérant les fiches en cours de rédaction
        $db = $this->EtatFiche->getDataSource();
        $subQuery = $db->buildStatement([
            'fields' => ['"EtatFiche2"."fiche_id"'],
            'table' => $db->fullTableName($this->EtatFiche),
            'alias' => 'EtatFiche2',
            'limit' => null,
            'offset' => null,
            'joins' => [],
            'conditions' => ['EtatFiche2.etat_id BETWEEN 2 AND 5'],
            'order' => null,
            'group' => null
                ], $this->EtatFiche);
        $subQuery = '"Fiche"."user_id" = ' . $this->Auth->user('id') . ' AND "Fiche"."organisation_id" = ' . $this->Session->read('Organisation.id') . ' AND "EtatFiche"."fiche_id" NOT IN (' . $subQuery . ') ';
        $subQueryExpression = $db->expression($subQuery);

        $conditions[] = $subQueryExpression;
        $conditions[] = 'EtatFiche.etat_id = 1';
        $encours = $this->EtatFiche->find('all', [
            'conditions' => $conditions,
            'contain' => [
                'Fiche' => [
                    'fields' => [
                        'id',
                        'created',
                        'modified'
                    ],
                    'User' => [
                        'fields' => [
                            'id',
                            'nom',
                            'prenom'
                        ]
                    ],
                    'Valeur' => [
                        'conditions' => [
                            'champ_name' => 'outilnom'
                        ],
                        'fields' => [
                            'champ_name',
                            'valeur'
                        ]
                    ]
                ],
                'User' => [
                    'fields' => [
                        'id',
                        'nom',
                        'prenom'
                    ]
                ]
            ]
        ]);
        $this->set('encours', $encours);

        // Requète récupérant les fiches en cours de validation
        $requete = $this->EtatFiche->find('all', [
            'conditions' => [
                'EtatFiche.etat_id' => 2,
                'Fiche.user_id' => $this->Auth->user('id'),
                'Fiche.organisation_id' => $this->Session->read('Organisation.id')
            ],
            'contain' => [
                'Fiche' => [
                    'fields' => [
                        'id',
                        'created',
                        'modified'
                    ],
                    'Valeur' => [
                        'conditions' => [
                            'champ_name' => 'outilnom'
                        ],
                        'fields' => [
                            'champ_name',
                            'valeur'
                        ]
                    ],
                    'User' => [
                        'fields' => [
                            'id',
                            'nom',
                            'prenom'
                        ]
                    ]
                ],
                'User' => [
                    'fields' => [
                        'id',
                        'nom',
                        'prenom'
                    ]
                ]
            ]
                ]
        );
        $this->set('encoursValidation', $requete);

        // Requète récupérant les fiches refusées par un validateur
        $requete = $this->EtatFiche->find('all', [
            'conditions' => [
                'EtatFiche.etat_id' => 4,
                'Fiche.user_id' => $this->Auth->user('id'),
                'Fiche.organisation_id' => $this->Session->read('Organisation.id')
            ],
            'contain' => [
                'Fiche' => [
                    'fields' => [
                        'id',
                        'created',
                        'modified'
                    ],
                    'User' => [
                        'fields' => [
                            'id',
                            'nom',
                            'prenom'
                        ]
                    ],
                    'Valeur' => [
                        'conditions' => [
                            'champ_name' => 'outilnom'
                        ],
                        'fields' => [
                            'champ_name',
                            'valeur'
                        ]
                    ]
                ],
                'User' => [
                    'fields' => [
                        'id',
                        'nom',
                        'prenom'
                    ]
                ]
            ]
        ]);

        $notifications = $this->Notification->find('all', array(
            'conditions' => array(
                'Notification.user_id' => $this->Auth->user('id'),
                'Notification.vu' => false,
                'Notification.afficher' => false
                
            ),
            'contain' => array(
                'Fiche' => array(
                    'Valeur' => array(
                        'conditions' => array(
                            'champ_name' => 'outilnom'
                        ),
                        'fields' => array('champ_name', 'valeur')
                    )
                )
            ),
            'order' => array(
                'Notification.content'
            )
        ));
        $this->set('notifications', $notifications);

        $nameOrganisation = [];

        foreach ($notifications as $key => $value) {
            $nameOrganisation[$key] = $this->Organisation->find('first', [
                'conditions' => ['id' => $value['Fiche']['organisation_id']],
                'fields' => ['raisonsociale']
            ]);
        }
        $this->set('nameOrganisation', $nameOrganisation);

        $this->set('refusees', $requete);
        $return = $this->_listValidants();
        $this->set('validants', $return['validants']);
        $this->set('consultants', $return['consultants']);
    }

    /**
     * @access public
     * @created 02/12/2015
     * @version V0.9.0
     */
    public function inbox() {
        $this->Session->write('nameController', "pannel");
        $this->Session->write('nameView', "inbox");
        
        if (!$this->Droits->authorized([2, 3, 5])) {
            $this->redirect($this->referer());
        }
        $this->set('title', __d('pannel', 'pannel.titreTraitementRecue'));
        // Requète récupérant les fiches qui demande une validation

        $requete = $this->EtatFiche->find('all', [
            'conditions' => [
                'EtatFiche.etat_id' => 2,
                'EtatFiche.user_id' => $this->Auth->user('id'),
                'Fiche.organisation_id' => $this->Session->read('Organisation.id')
            ],
            'contain' => [
                'Fiche' => [
                    'fields' => [
                        'id',
                        'created',
                        'modified'
                    ],
                    'User' => [
                        'fields' => [
                            'id',
                            'nom',
                            'prenom'
                        ]
                    ],
                    'Valeur' => [
                        'conditions' => [
                            'champ_name' => 'outilnom'
                        ],
                        'fields' => [
                            'champ_name',
                            'valeur'
                        ]
                    ]
                ],
                'User' => [
                    'fields' => [
                        'id',
                        'nom',
                        'prenom'
                    ]
                ],
                'PreviousUser' => [
                    'fields' => [
                        'id',
                        'nom',
                        'prenom'
                    ]
                ]
            ]
        ]);
        $this->set('dmdValid', $requete);

        $notifications = $this->Notification->find('all', array(
            'conditions' => array(
                'Notification.user_id' => $this->Auth->user('id'),
                'Notification.vu' => false,
                'Notification.afficher' => false
                
            ),
            'contain' => array(
                'Fiche' => array(
                    'Valeur' => array(
                        'conditions' => array(
                            'champ_name' => 'outilnom'
                        ),
                        'fields' => array('champ_name', 'valeur')
                    )
                )
            ),
            'order' => array(
                'Notification.content'
            )
        ));
        $this->set('notifications', $notifications);
        
        $nameOrganisation = [];

        foreach ($notifications as $key => $value) {
            $nameOrganisation[$key] = $this->Organisation->find('first', [
                'conditions' => ['id' => $value['Fiche']['organisation_id']],
                'fields' => ['raisonsociale']
            ]);
        }
        $this->set('nameOrganisation', $nameOrganisation);
        
        // Requète récupérant les fiches qui demande un avis
        $requete = $this->EtatFiche->find('all', [
            'conditions' => [
                'EtatFiche.etat_id' => 6,
                'EtatFiche.user_id' => $this->Auth->user('id'),
                'Fiche.organisation_id' => $this->Session->read('Organisation.id')
            ],
            'contain' => [
                'Fiche' => [
                    'fields' => [
                        'id',
                        'created',
                        'modified'
                    ],
                    'User' => [
                        'fields' => [
                            'id',
                            'nom',
                            'prenom'
                        ]
                    ],
                    'Valeur' => [
                        'conditions' => [
                            'champ_name' => 'outilnom'
                        ],
                        'fields' => [
                            'champ_name',
                            'valeur'
                        ]
                    ]
                ],
                'User' => [
                    'fields' => [
                        'id',
                        'nom',
                        'prenom'
                    ]
                ],
                'PreviousUser' => [
                    'fields' => [
                        'id',
                        'nom',
                        'prenom'
                    ]
                ]
            ]
        ]);

        $this->set('dmdAvis', $requete);
        $return = $this->_listValidants();
        $this->set('validants', $return['validants']);
        $this->set('consultants', $return['consultants']);
    }

    /**
     * @access public
     * @created 02/12/2015
     * @version V0.9.0
     */
    public function archives() {
        $this->Session->write('nameController', "pannel");
        $this->Session->write('nameView', "archives");
        
        $this->set('title', __d('pannel', 'pannel.titreTraitementValidee'));
        // Requète récupérant les fiches validées par le CIL

        $requete = $this->EtatFiche->find('all', [
            'conditions' => [
                'EtatFiche.etat_id' => 5,
                'Fiche.user_id' => $this->Auth->user('id'),
                'Fiche.organisation_id' => $this->Session->read('Organisation.id')
            ],
            'contain' => [
                'Fiche' => [
                    'fields' => [
                        'id',
                        'created',
                        'modified'
                    ],
                    'User' => [
                        'fields' => [
                            'id',
                            'nom',
                            'prenom'
                        ]
                    ],
                    'Valeur' => [
                        'conditions' => [
                            'champ_name' => 'outilnom'
                        ],
                        'fields' => [
                            'champ_name',
                            'valeur'
                        ]
                    ]
                ],
                'User' => [
                    'fields' => [
                        'id',
                        'nom',
                        'prenom'
                    ]
                ]
            ]
                ]
        );
        $this->set('validees', $requete);
    }

    /**
     * Fonction appelée pour le composant parcours, permettant d'afficher le parcours parcouru par une fiche et les commentaires liés (uniquement ceux visibles par l'utilisateur)
     * 
     * @param int $id
     * @return type
     * 
     * @access public
     * @created 02/12/2015
     * @version V0.9.0
     */
    public function parcours($id) {
        $parcours = $this->EtatFiche->find('all', [
            'conditions' => [
                'EtatFiche.fiche_id' => $id
            ],
            'contain' => [
                'Fiche' => [
                    'id',
                    'organisation_id',
                    'user_id',
                    'created',
                    'modified',
                    'User' => [
                        'id',
                        'nom',
                        'prenom'
                    ]
                ],
                'User' => [
                    'id',
                    'nom',
                    'prenom'
                ],
                'Commentaire' => [
                    'conditions' => [
                        'OR' => [
                            'Commentaire.user_id' => $this->Auth->user('id'),
                            'Commentaire.destinataire_id' => $this->Auth->user('id')
                        ]
                    ],
                    'User' => [
                        'id',
                        'nom',
                        'prenom'
                    ]
                ]
            ],
            'order' => [
                'EtatFiche.id DESC'
            ]
        ]);

        return $parcours;
    }

    /**
     * @param int $id
     * @return type
     * 
     * @access public
     * @created 02/12/2015
     * @version V0.9.0
     */
    public function getHistorique($id) {
        $historique = $this->Historique->find('all', [
            'conditions' => ['fiche_id' => $id],
            'order' => [
                'created DESC',
                'id DESC'
            ]
        ]);

        return $historique;
    }

    /**
     * Fonction de suppression de toute les notifications d'un utilisateur
     * 
     * @access public
     * @created 02/12/2015
     * @version V0.9.0
     */
    public function dropNotif() {
        $this->Notification->deleteAll([
            'Notification.user_id' => $this->Auth->user('id'),
            false
        ]);
        $this->redirect($this->referer());
    }
    
    /**
     * Fonction de suppression d'une notification d'un utilisateur
     * 
     * @access public
     * @created 20/01/2016
     * @version V0.9.0
     */
    public function supprimerLaNotif($idFiche) {
        $this->Notification->deleteAll([
            'Notification.fiche_id' => $idFiche ,
            'Notification.user_id' => $this->Auth->user('id')
        ]);
    }

    /**
     * Permet de mettre dans la base de donner les notifications deja afficher 
     * quand on fermer la pop-up avec le bouton FERMER
     * 
     * @access public
     * @created 02/12/2015
     * @version V0.9.0
     */
    public function validNotif() {
        $this->Notification->updateAll([
            'Notification.afficher' => true
                ], [
            'Notification.user_id' => $this->Auth->user('id')
        ]);
        $this->redirect($this->referer());
    }
    
    /**
     * Permet de mettre en base les notifs deja afficher
     * 
     * @param int $idFicheEnCourAffigage
     * 
     * @access public
     * @created 20/01/2016
     * @version V0.9.0
     */
    public function notifAfficher($idFicheEnCourAffigage = 0) {
        $this->Notification->updateAll([
            'Notification.afficher' => true
                ], [
            'Notification.user_id' => $this->Auth->user('id'),
            'Notification.fiche_id' => $idFicheEnCourAffigage  
        ]);
    }

    /**
     * @return type
     * 
     * @access protected
     * @created 02/12/2015
     * @version V0.9.0
     */
    protected function _listValidants() {
        // Requète récupérant les utilisateurs ayant le droit de consultation

        $queryConsultants = [
            'fields' => [
                'User.id',
                'User.nom',
                'User.prenom'
            ],
            'joins' => [
                $this->Droit->join('OrganisationUser', ['type' => "INNER"]),
                $this->Droit->OrganisationUser->join('User', ['type' => "INNER"])
            ],
            'recursive' => -1,
            'conditions' => [
                'OrganisationUser.organisation_id' => $this->Session->read('Organisation.id'),
                'User.id != ' . $this->Auth->user('id'),
                'Droit.liste_droit_id' => 3
            ],
        ];
        $consultants = $this->Droit->find('all', $queryConsultants);
        $consultants = Hash::combine($consultants, '{n}.User.id', [
                    '%s %s',
                    '{n}.User.prenom',
                    '{n}.User.nom'
        ]);
        $return = ['consultants' => $consultants];


        // Requète récupérant les utilisateurs ayant le droit de validation
        if ($this->Session->read('Organisation.cil') != null) {
            $cil = $this->Session->read('Organisation.cil');
        } else {
            $cil = 0;
        }


        $queryValidants = [
            'fields' => [
                'User.id',
                'User.nom',
                'User.prenom'
            ],
            'joins' => [
                $this->Droit->join('OrganisationUser', ['type' => "INNER"]),
                $this->Droit->OrganisationUser->join('User', ['type' => "INNER"])
            ],
            'conditions' => [
                'OrganisationUser.organisation_id' => $this->Session->read('Organisation.id'),
                'NOT' => [
                    'User.id' => [
                        $this->Auth->user('id'),
                        $cil
                    ]
                ],
                'Droit.liste_droit_id' => 2
            ]
        ];
        $validants = $this->Droit->find('all', $queryValidants);
        $validants = Hash::combine($validants, '{n}.User.id', [
                    '%s %s',
                    '{n}.User.prenom',
                    '{n}.User.nom'
        ]);
        $return['validants'] = $validants;

        return $return;
    }

}