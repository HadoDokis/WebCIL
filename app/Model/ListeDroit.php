<?php

/**
 * Model ListeDroit
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

class ListeDroit extends AppModel {
    public $name = 'ListeDroit';

    public $displayField = 'libelle';

    const REDIGER_TRAITEMENT = 1; // Rédiger une fiche
    const VALIDER_TRAITEMENT = 2; // Valider une fiche
    const VISER_TRAITEMENT = 3; // Viser une fiche
    const CONSULTER_REGISTRE = 4; // Consulter le registre
    const INSERER_TRAITEMENT_REGISTRE = 5; // Insérer une fiche dans le registre
    const MODIFIER_TRAITEMENT_REGISTRE = 6; // modifier une fiche du registre
    const TELECHARGER_TRAITEMENT_REGISTRE = 7; // Télécharger une fiche du registre
    const CREER_UTILISATEUR = 8; // Créer un utilisateur
    const MODIFIER_UTILISATEUR = 9; // Modifier un utilisateur
    const SUPPRIMER_UTILISATEUR = 10; // Supprimer un utilisateur
    const CREER_ORGANISATION = 11; // Créer une organisation
    const MODIFIER_ORGANISATION = 12; // Modifier une organisation
    const CREER_PROFIL = 13; // Créer un profil
    const MODIFIER_PROFIL = 14; // Modifier un profil
    const SUPPRIMER_PROFIL = 15; // Supprimer un profil


    /**
     * hasMany associations
     *
     * @var array
     * 
     * @access public
     * @created 13/04/2015
     * @version V0.9.0
     */
    public $hasMany = array(
    'Droit' => array(
    'className' => 'Droit',
    'foreignKey' => 'liste_droit_id',
    'dependent' => true
    )
    );

    /**
     * $hasAndBelongsToMany associations
     *
     * @var array
     * 
     * @access public
     * @created 13/04/2015
     * @version V0.9.0
     */
    public $hasAndBelongsToMany = array(
    'Role' =>
    array(
    'className' => 'Role',
    'joinTable' => 'role_droits',
    'foreignKey' => 'liste_droit_id',
    'associationForeignKey' => 'role_id',
    'unique' => true,
    'conditions' => '',
    'fields' => '',
    'order' => '',
    'limit' => '',
    'offset' => '',
    'finderQuery' => '',
    'with' => 'RoleDroit'
    )
    );
}
