<?php
echo $this->Html->script('pannel.js');
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-12">
                <h3 class="panel-title">
                    <?php
                    echo __d('pannel', 'pannel.traitementValidationInsereeRegistre') . count($validees) . ')';
                    ?>
                </h3>
            </div>
        </div>
    </div>
    <div class="panel-body panel-body-custom">
        <?php
        if (!empty($validees)) {
            ?>
            <table class="table  table-bordered">
                <thead>
                    <tr>
                        <th class="thleft col-md-1">
                            <?php echo __d('pannel', 'pannel.motEtat'); ?>
                        </th>
                        <th class="thleft col-md-9 col-md-offset-1">
                            <?php echo __d('pannel', 'pannel.motSynthese'); ?>
                        </th>
                        <th class="thleft col-md-2 col-md-offset-10">
                            <?php echo __d('pannel', 'pannel.motActions'); ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($validees as $donnee) {
                        ?>
                        <tr>
                            <td class='tdleft col-md-1'>
                                <?php
                                if ($donnee['EtatFiche']['etat_id'] == 5){
                                    $action = 'genereTraitement';
                                    $icone = '<span class="fa fa-cog fa-lg"></span>';
                                    $titre = __d('pannel', 'pannel.commentaireGenererTraitement');
                                    ?>
                                    <div class="etatIcone">
                                        <i class="fa fa-check fa-3x fa-success"></i>
                                    </div>
                                <?php
                                } else if ($donnee['EtatFiche']['etat_id'] == 7) {
                                    $action = 'downloadFileTraitement';
                                    $icone = '<span class="fa fa-download fa-lg"></span>';
                                    $titre = __d('pannel', 'pannel.commentaireTelechargerTraitement');
                                    ?>
                                    <div class="etatIcone">
                                        <i class="fa fa-lock fa-3x fa-success"></i>
                                    </div>
                                    <?php
                                }
                                ?>
                            </td>
                            <td class='tdleft col-md-9 col-md-offset-1'>
                                <div class="row">
                                    <div class="col-md-12">
                                        <strong><?php echo __d('pannel', 'pannel.motNomTraitement'); ?>
                                        </strong> <?php echo $donnee['Fiche']['Valeur'][0]['valeur']; ?>
                                    </div>

                                </div>
                                <div class="row top15">
                                    <div class="col-md-6">
                                        <strong><?php echo __d('pannel', 'pannel.motCreee'); ?>
                                        </strong> <?php echo $donnee['Fiche']['User']['prenom'] . ' ' . $donnee['Fiche']['User']['nom'] . ' le ' . $this->Time->format($donnee['Fiche']['created'], FORMAT_DATE_HEURE); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <strong><?php echo __d('pannel', 'pannel.motDerniereModification'); ?>
                                        </strong> <?php echo $this->Time->format($donnee['Fiche']['modified'], FORMAT_DATE_HEURE); ?>
                                    </div>
                                </div>
                            </td>
                            <td class='tdcent col-md-2 col-md-offset-10'>
                                <div class="btn-group">
                                    <?php
                                    echo $this->Html->link('<span class="fa fa-eye fa-lg"></span>', [
                                        'controller' => 'fiches',
                                        'action' => 'show',
                                        $donnee['Fiche']['id']
                                            ], [
                                        'class' => 'btn btn-default-default boutonShow btn-sm my-tooltip',
                                        'title' => __d('pannel', 'pannel.commentaireVoirTraitement'),
                                        'escapeTitle' => false
                                    ]);
                                    
                                    echo $this->Html->link($icone, [
                                        'controller' => 'fiches',
                                        'action' => $action,
                                        $donnee['Fiche']['id']
                                            ], [
                                        'class' => 'btn btn-default-default boutonEdit btn-sm my-tooltip',
                                        'title' => $titre,
                                        'escapeTitle' => false
                                    ]);
                                    ?>
                                    <button type='button'
                                            class='btn btn-default-default boutonList btn-sm my-tooltip'
                                            title='<?php echo __d('pannel', 'pannel.commentaireVoirParcours'); ?>'
                                            id='<?php echo $donnee['Fiche']['id']; ?>'
                                            value='<?php echo $donnee['Fiche']['id']; ?>'>
                                        <span class='fa fa-history fa-lg'></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class='listeValidation'
                                id='listeValidation<?php echo $donnee['Fiche']['id']; ?>'>
                                <td></td>
                                <td class='tdleft'>
                                    <?php
                                    $parcours = $this->requestAction([
                                        'controller' => 'Pannel',
                                        'action' => 'parcours',
                                        $donnee['Fiche']['id']
                                    ]);
                                    echo $this->element('parcours', [
                                        "parcours" => $parcours
                                    ]);
                                    ?>
                                </td>
                                <td class="tdleft">
                                    <?php
                                    $historique = $this->requestAction([
                                        'controller' => 'Pannel',
                                        'action' => 'getHistorique',
                                        $donnee['Fiche']['id']
                                    ]);
                                    echo $this->element('historique', [
                                        "historique" => $historique,
                                        "id" => $donnee['Fiche']['id']
                                    ]);
                                    ?>
                                </td>
                            </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <?php
        } else {
            ?>
            <div class='text-center'>
                <h3><?php echo __d('pannel', 'pannel.aucunTraitementValidationInsereeRegistre'); ?></h3>
            </div>
            <?php
        }
        ?>
    </div>
</div>