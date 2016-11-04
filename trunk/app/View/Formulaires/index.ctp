<table class="table">
    <thead>
    <th class="thleft col-md-1">
        <?php echo __d('formulaire', 'formulaire.titreTableauStatut'); ?>
    </th>
    <th class="thleft col-md-9">
        <?php echo __d('formulaire', 'formulaire.titreTableauSynthese'); ?>
    </th>
    <th class="thleft col-md-2">
        <?php echo __d('formulaire', 'formulaire.titreTableauAction'); ?>
    </th>
</thead>
<tbody>
    <?php
    foreach ($formulaires as $data) {
        if ($data['Formulaire']['active']) {
            $iconClass = 'fa fa-check-square-o fa-3x fa-success';
            $statut = __d('formulaire', 'formulaire.textStatutActif');
            $statutClass = 'fa-success';
        } else {
            $statut = __d('formulaire', 'formulaire.textStatutInactif');
            $iconClass = 'fa fa-close fa-3x fa-danger';
            $statutClass = 'fa-danger';
        }
        ?>
        <tr>
            <!--Status-->
            <td class="tdleft col-md-1">
                <div class="etatIcone">
                    <i class= '<?php echo $iconClass; ?>'></i>
                </div>
            </td>

            <!--Synthèse-->
            <td class="tdleft col-md-9">
                <div class="row">
                    <div class="col-md-4">
                        <!--Nom : -->
                        <div class="row col-md-12">
                            <strong>
                                <?php echo __d('formulaire', 'formulaire.textTableauNom'); ?>
                            </strong>
                            <?php echo $data['Formulaire']['libelle']; ?>
                        </div>

                        <!--Statut :--> 
                        <div class="row col-md-12">
                            <strong>
                                <?php echo __d('formulaire', 'formulaire.textTableauStatut'); ?>
                            </strong>
                            <span class='<?php echo $statutClass; ?>'><?php echo $statut; ?></span>
                        </div>
                    </div>

                    <!--Service :--> 
                    <div class="col-md-3">
                        <strong>
                            <?php echo __d('user', 'user.champService'); ?>
                        </strong>
                        <ul>
                            <?php
                            if ($data['Formulaire']['service_id'] != null) {
                                $nameService = Hash::combine($services, '{n}.Service.id', array('%s', '{n}.Service.libelle'));
                                echo '<li>' . $nameService[$data['Formulaire']['service_id']] . '</li>';
                            } else {
                                echo '<li> Aucun service</li>';
                            }
                            ?>
                        </ul>
                    </div>


                    <!--<div class="col-md-7">-->
                    <!--Description :-->
                    <div class="col-md-3">
                        <strong>
                            <?php echo __d('formulaire', 'formulaire.textTableauDescription'); ?>
                        </strong>
                        <?php echo $data['Formulaire']['description']; ?>
                    </div>
                    <!--                        <div class="col-md-9">
                    <?php // echo $data['Formulaire']['description']; ?>
                                            </div>-->
                    <!--</div>-->
                </div>
            </td>

            <!--Actions-->
            <td class="tdleft col-md-2">
                <div class="btn-group">
                    <?php
                    //Bouton voir le formulaire
                    echo $this->Html->link('<span class="glyphicon glyphicon-search"></span>', array(
                        'controller' => 'formulaires',
                        'action' => 'show',
                        $data['Formulaire']['id']
                            ), array(
                        'class' => 'btn btn-default-default btn-sm my-tooltip',
                        'title' => __d('formulaire', 'formulaire.commentaireVoirFormulaire'),
                        'escape' => false
                    ));

                    if ($valid[$data['Formulaire']['id']]) {
                        //Bouton édité le formulaire
                        echo $this->Html->link('<span class="glyphicon glyphicon-pencil"></span>', array(
                            'controller' => 'formulaires',
                            'action' => 'edit',
                            $data['Formulaire']['id']
                                ), array(
                            'class' => 'btn btn-default-default btn-sm my-tooltip',
                            'title' => __d('formulaire', 'formulaire.commentaireModifierFormulaire'),
                            'escape' => false
                        ));
                    }

                    if ($data['Formulaire']['active']) {
                        //Bouton désactivé le formulaire
                        $lien = $this->Html->link('<span class="glyphicon glyphicon-remove"></span>', array(
                            'controller' => 'formulaires',
                            'action' => 'toggle',
                            $data['Formulaire']['id'],
                            $data['Formulaire']['active']
                                ), array(
                            'class' => 'btn btn-default-default btn-sm my-tooltip',
                            'escape' => false,
                            'title' => __d('formulaire', 'formulaire.commentaireDesactiverFormulaire')
                        ));
                    } else {
                        //Bouton activé le formulaire
                        $lien = $this->Html->link('<span class="glyphicon glyphicon-check"></span>', array(
                            'controller' => 'formulaires',
                            'action' => 'toggle',
                            $data['Formulaire']['id'],
                            $data['Formulaire']['active']
                                ), array(
                            'class' => 'btn btn-default-default btn-sm my-tooltip',
                            'title' => __d('formulaire', 'formulaire.commentaireActiverFormulaire'),
                            'escape' => false
                        ));
                    }

                    echo $lien;
                    if ($valid[$data['Formulaire']['id']]) {
                        //Bouton supprimé le formulaire
                        echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>', array(
                            'controller' => 'formulaires',
                            'action' => 'delete',
                            $data['Formulaire']['id']
                                ), array(
                            'class' => 'btn btn-default-danger btn-sm my-tooltip',
                            'title' => __d('formulaire', 'formulaire.commentaireSupprimerFormulaire'),
                            'escape' => false
                                ), __d('formulaire', 'formulaire.confirmationSupprimerFormulaire')
                        );
                    } else {
                        //Bouton dupliqué le formulaire
                        ?> 
                        <button type="button" class="btn btn-default-default btn-sm my-tooltip btn_duplicate" 
                                data-toggle="modal" data-target="#modalDupliquer" value="<?php echo $data['Formulaire']['id']; ?>"
                                title="<?php echo __d('formulaire', 'formulaire.commentaireDupliquerFormulaire'); ?>">
                            <span class="fa fa-files-o fa-lg" ></span>
                        </button>

                        <div class="modal fade" id="modalDupliquer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>

                                        <h4 class="modal-title" id="myModalLabel">
                                            <?php echo __d('formulaire', 'formulaire.popupInfoGeneraleFormulaireDuplication'); ?>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row form-group">
                                            <?php
                                            echo $this->Form->create('Formulaire', array('action' => 'dupliquer'));

                                            echo $this->Form->input('id', array("value" => 0));
                                            //echo $this->Form->input('id', array("value" => $data['Formulaire']['id']));

                                            //champ nom du formulaire *
                                            echo $this->Form->input('libelle', array(
                                                'class' => 'form-control',
                                                'placeholder' => __d('formulaire', 'formulaire.popupPlaceholderNomFormulaire'),
                                                'label' => array(
                                                    'text' => __d('formulaire', 'formulaire.popupNomFormulaire') . '<span class="requis">*</span>',
                                                    'class' => 'col-md-4 control-label'
                                                ),
                                                'between' => '<div class="col-md-8">',
                                                'after' => '</div>',
                                                'required' => true
                                            ));
                                            echo '</div>';

                                            if (!empty($services)) {
                                                $nameService = Hash::combine($services, '{n}.Service.id', array('%s', '{n}.Service.libelle'));

                                                echo '<div class="row form-group">';
                                                //Champ Service *
                                                echo $this->Form->input('service', [
                                                    'options' => $nameService,
                                                    'empty' => __d('formulaire', 'formulaire.placeholderChampService'),
                                                    'class' => 'usersDeroulant transformSelect form-control',
                                                    'label' => [
                                                        'text' => __d('formulaire', 'formulaire.champService') . '<span class="requis">*</span>',
                                                        'class' => 'col-md-4 control-label'
                                                    ],
                                                    'between' => '<div class="col-md-8">',
                                                    'after' => '</div>',
                                                    'required' => true
                                                ]);
                                                echo '</div>';
                                            }

                                            //Champ Description
                                            echo '<div class="row form-group">';
                                            echo $this->Form->input('description', array(
                                                'type' => 'textarea',
                                                'class' => 'form-control',
                                                'placeholder' => __d('formulaire', 'formulaire.popupPlaceholderDescription'),
                                                'label' => array(
                                                    'text' => __d('formulaire', 'formulaire.popupDescription'),
                                                    'class' => 'col-md-4 control-label'
                                                ),
                                                'between' => '<div class="col-md-8">',
                                                'after' => '</div>',
                                                'required' => false
                                            ));
                                            ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default-default" data-dismiss="modal">
                                                <i class="fa fa-arrow-left"></i>
                                                <?php echo __d('default', 'default.btnAnnuler'); ?>
                                            </button>
                                            <?php
                                            echo $this->Form->button("<i class='fa fa-check'></i>" . __d('default', 'default.btnEnregistrer'), array(
                                                'type' => 'submit',
                                                'class' => 'btn btn-default-success',
                                                'escape' => false
                                            ));
                                            ?>
                                        </div>
                                        <?php
                                        echo $this->Form->end();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>             
                        <?php
                    }

                    echo '
        </div>
        </td>
    </tr>';
                }
                ?>
</tbody>
</table>

<!--Bouton de création d'un formulaire -->
<div class="row bottom10">
    <div class="col-md-12 text-center">
        <button type="button" class="btn btn-default-primary" data-toggle="modal" data-target="#modalAddForm">
            <span class="glyphicon glyphicon-plus"></span>
            <?php echo __d('formulaire', 'formulaire.btnCreerFormulaire'); ?>
        </button>
    </div>
</div>
<div class="modal fade" id="modalAddForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><?php echo __d('formulaire', 'formulaire.popupInfoGeneraleFormulaire'); ?></h4>
            </div>
            <div class="modal-body">
                <?php
                //pop-up de création de formulaire
                echo $this->Form->create('Formulaire', array('action' => 'addFirst'));
                echo '<div class="row form-group">';
                //champ nom du formulaire *
                echo $this->Form->input('libelle', array(
                    'class' => 'form-control',
                    'placeholder' => __d('formulaire', 'formulaire.popupPlaceholderNomFormulaire'),
                    'label' => array(
                        'text' => __d('formulaire', 'formulaire.popupNomFormulaire') . '<span class="requis">*</span>',
                        'class' => 'col-md-4 control-label'
                    ),
                    'between' => '<div class="col-md-8">',
                    'after' => '</div>',
                    'required' => true
                ));
                echo '</div>';

                if (!empty($services)) {
                    $nameService = Hash::combine($services, '{n}.Service.id', array('%s', '{n}.Service.libelle'));

                    echo '<div class="row form-group">';
                    //Champ Service *
                    echo $this->Form->input('service', [
                        'options' => $nameService,
                        'empty' => __d('formulaire', 'formulaire.placeholderChampService'),
                        'class' => 'usersDeroulant transformSelect form-control',
                        'label' => [
                            'text' => __d('formulaire', 'formulaire.champService') . '<span class="requis">*</span>',
                            'class' => 'col-md-4 control-label'
                        ],
                        'between' => '<div class="col-md-8">',
                        'after' => '</div>',
                        'required' => true
                    ]);
                    echo '</div>';
                }

                echo '<div class="row form-group">';
                //Champ Description
                echo $this->Form->input('description', array(
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'placeholder' => __d('formulaire', 'formulaire.popupPlaceholderDescription'),
                    'label' => array(
                        'text' => __d('formulaire', 'formulaire.popupDescription'),
                        'class' => 'col-md-4 control-label'
                    ),
                    'between' => '<div class="col-md-8">',
                    'after' => '</div>',
                    'required' => false
                ));
                echo '</div>'
                ?>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" class="btn btn-default-default" data-dismiss="modal"><i
                            class="fa fa-arrow-left"></i><?php echo __d('default', 'default.btnAnnuler'); ?>
                    </button>
                    <?php
                    echo $this->Form->button("<i class='fa fa-check'></i>" . __d('default', 'default.btnEnregistrer'), array(
                        'type' => 'submit',
                        'class' => 'btn btn-default-success',
                        'escape' => false
                    ));
                    ?>
                </div>
                <?php
                echo $this->Form->end();
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(".btn_duplicate").click(function () {
        var valueId = $(this).val();
        $('#FormulaireId').val(valueId);
    });

</script>    