<!-- Tableau -->
<table class="table">
    <!-- Titre tableau -->
    <thead>
        <!-- Utilisateur -->
    <th class="col-md-2">
        <?php echo __d('user', 'user.titreTableauUtilisateur'); ?>
    </th>

    <!-- Synthèse -->
    <th class="col-md-8">
        <?php echo __d('user', 'user.titreTableauSynthese'); ?>
    </th>

    <!-- Actions -->
    <th class="col-md-1">
        <?php echo __d('user', 'user.titreTableauAction'); ?>
    </th>

</thead>

<!-- Info tableau -->
<tbody>
    <?php
    foreach ($admins as $donnees) {
        ?>
        <tr>
            <!-- Nom + prénom utilisateur -->
            <td class="tdleft">
                <?php 
                    echo $donnees['User']['civilite'] . ' ' .  ucfirst($donnees['User']['prenom']) . ' ' . strtoupper($donnees['User']['nom']); 
                ?>
            </td>

            <!-- Entitée(s) de l'utilisateur -->
            <td class="tdleft">
                <!-- Login de l'utilisateur -->
                <div class="col-md-3">
                    <strong>
                        <?php
                        //Login :
                        echo __d('admin', 'admin.textTableauLogin');
                        ?>
                    </strong>
                    <?php
                    //Libelle du login de l'utilisateur
                    echo $donnees['User']['username'];
                    ?>
                </div>

                <!-- Profil de l'utilisateur -->
                <div class="col-md-3">
                    <strong>
                        <?php echo __d('admin', 'admin.champProfil'); ?>
                    </strong>
                    <?php
                    echo __d('admin', 'admin.textSuperadministrateur');
                    ?>
                </div>
            </td>

            <!-- Action possible d'effectuer en fonction des droits de l'utilisateur -->
            <td class="tdleft">
                <div class="btn-group">
                    <?php
                        if ($donnees['User']['id'] != 1) {
                            //Bouton de suppression
                            echo $this->Html->link('<span class="fa fa-trash fa-lg"></span>', [
                                'controller' => 'admins',
                                'action' => 'delete',
                                $donnees['Admin']['id'],
                                $donnees['User']['id']
                                    ], [
                                'class' => 'btn btn-default-danger btn-sm my-tooltip',
                                'title' => __d('user', 'user.commentaireSupprimerUser'),
                                'escapeTitle' => false
                                    ], __d('user', 'user.confirmationSupprimerUser') . $donnees['User']['prenom'] . ' ' . $donnees['User']['nom'] . ' ?');
                        }
                    ?>
                </div>
            </td>
        </tr>
        <?php
    }
    ?>
</tbody>
</table>

<div class="row bottom10">
    <div class="col-md-12 text-center">
        <?php
            echo $this->Html->link('<span class="glyphicon glyphicon-plus"></span>'. __d('admin','admin.btnAjouterSuperAdmin'), array(
                'controller' => 'admins',
                'action' => 'add'
                    ), array(
                'class' => 'btn btn-default-primary sender',
                'escapeTitle' => false
            ));
        ?>
    </div>
</div>