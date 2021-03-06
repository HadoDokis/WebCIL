<?php

/**
 * Model EtatFiche
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
 * @package     AppModel
 */
App::uses('AppModel', 'Model');

class EtatFiche extends AppModel {

    public $name = 'EtatFiche';

    const ENCOURS_REDACTION = 1; // En cours de rédaction
    const ENCOURS_VALIDATION = 2; // En cours de validation
    const VALIDER = 3; // Validée
    const REFUSER = 4; // Refusée
    const VALIDER_CIL = 5; // Validée par le CIL
    const DEMANDE_AVIS = 6; // Demande d avis
    const ARCHIVER = 7; // Archivée
    const REPLACER_REDACTION = 8; // Replacer en rédaction
    const MODIFICATION_TRAITEMENT_REGISTRE = 9; // Modification du traitement inséré au registre

    /**
     * belongsTo associations
     *
     * @var array
     * 
     * @access public
     * @created 13/04/2015
     * @version V1.0.0
     */
    public $belongsTo = array(
        'Etat' => array(
            'className' => 'Etat',
            'foreignKey' => 'etat_id',
        ),
        'Fiche' => array(
            'className' => 'Fiche',
            'foreignKey' => 'fiche_id'
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id'
        ),
        'PreviousUser' => array(
            'className' => 'User',
            'foreignKey' => 'previous_user_id'
        )
    );

    /**
     * hasOne associations
     *
     * @var array
     * 
     * @access public
     * @created 13/04/2015
     * @version V1.0.0
     */
    public $hasMany = array(
        'Commentaire' => array(
            'className' => 'Commentaire',
            'foreignKey' => 'etat_fiches_id',
            'dependent' => true
        )
    );
    
    /**
     *
     * @var type
     * 
     * @access public
     * @created 11/01/2017
     * @version V1.0.0
     * @author Théo GUILLON <theo.guillon@libriciel.coop>
     */
    public $hasOne = array(
        'Modification' => array(
            'className' => 'Modification',
            'foreignKey' => 'etat_fiches_id',
            'dependent' => true
        ),
    );

}
