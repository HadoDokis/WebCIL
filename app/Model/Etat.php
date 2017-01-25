<?php

/**
 * Model Etat
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

class Etat extends AppModel {

    public $name = 'Etat';
    
    public $displayField = 'libelle';

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
        'EtatFiche' => array(
            'className' => 'EtatFiche',
            'foreignKey' => 'etat_id',
            'dependent' => false,
        //'conditions' => array('Model.field' => 'value'),
        //'fields'       => '',
        //'order'        => '',
        //'limit'        => '',
        //'offset'       => '',
        //'exclusive'    => '',
        //'finderQuery'  => '',
        //'counterQuery' => ''
        )
    );

}
