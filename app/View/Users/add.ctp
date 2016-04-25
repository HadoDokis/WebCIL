<div class="users form">
    <?php
    if (isset($this->validationErrors['User']) && !empty($this->validationErrors['User'])) {
        ?>

        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <span class="sr-only">Error:</span>
            Ces erreurs se sont produites:
            <ul>
                <?php
                foreach ($this->validationErrors as $donnees) {
                    foreach ($donnees as $champ) {
                        foreach ($champ as $error) {
                            echo '<li>' . $error . '</li>';
                        }
                    }
                }
                ?>
            </ul>
        </div>
        <?php
    }

    echo $this->Form->create('User', [
        'autocomplete' => 'off',
        'inputDefaults' => ['div' => false],
        'class' => 'form-horizontal'
    ]);
    ?>
    <div class="row">
        <div class="col-md-6">

            <?php
            if (empty($this->validationErrors['User']['username'])) {
                echo '<div class="form-group">';
            } else {
                echo '<div class="form-group has-error">';
            }
            ?>
            <?php
            echo $this->Form->input('username', [
                'class' => 'form-control',
                'placeholder' => __d('user','user.placeholderChampLogin'),
                'label' => [
                    'text' => __d('user','user.champLogin').'<span class="requis">*</span>',
                    'class' => 'col-md-4 control-label'
                ],
                'between' => '<div class="col-md-8">',
                'after' => '</div>',
                'required' => true
            ]);
            ?>
        </div>

        <?php
        if (empty($this->validationErrors['User']['password'])) {
            echo '<div class="form-group">';
        } else {
            echo '<div class="form-group has-error">';
        }

        echo $this->Form->input('password', [
            'class' => 'form-control',
            'placeholder' => __d('user','user.placeholderChampMotDePasse'),
            'label' => [
                'text' => __d('user','user.champMotDePasse').'<span class="requis">*</span>',
                'class' => 'col-md-4 control-label'
            ],
            'between' => '<div class="col-md-8">',
            'after' => '</div>',
            'required' => true
        ]);
        ?>
    </div>
    <?php
    if (empty($this->validationErrors['User']['passwd'])) {
        echo '<div class="form-group">';
    } else {
        echo '<div class="form-group has-error">';
    }
    ?>

    <?php
    echo $this->Form->input('passwd', [
        'class' => 'form-control',
        'placeholder' => __d('user','user.placeholderChampVerifMotDePasse'),
        'label' => [
            'text' => __d('user','user.champVerifMotDePasse').'<span class="requis">*</span>',
            'class' => 'col-md-4 control-label'
        ],
        'between' => '<div class="col-md-8">',
        'after' => '</div>',
        'required' => true
    ]);
    ?>
</div>

<div class="form-group">
    <?php
    echo $this->Form->input('nom', [
        'class' => 'form-control',
        'placeholder' => __d('user','user.placeholderChampNom'),
        'label' => [
            'text' => __d('default','default.champNom').'<span class="requis">*</span>',
            'class' => 'col-md-4 control-label'
        ],
        'between' => '<div class="col-md-8">',
        'after' => '</div>',
        'required' => true
    ]);
    ?>
</div>
<div class="form-group">
    <?php
    echo $this->Form->input('prenom', [
        'class' => 'form-control',
        'placeholder' => __d('user','user.placeholderChampPrenom'),
        'label' => [
            'text' => __d('user','user.champPrenom').'<span class="requis">*</span>',
            'class' => 'col-md-4 control-label'
        ],
        'between' => '<div class="col-md-8">',
        'after' => '</div>',
        'required' => true
    ]);
    ?>
</div>

<?php
if (empty($this->validationErrors['User']['email'])) {
    echo '<div class="form-group">';
} else {
    echo '<div class="form-group has-error">';
}

echo $this->Form->input('email', [
    'class' => 'form-control',
    'placeholder' => __d('user','user.placeholderChampE-mail'),
    'label' => [
        'text' => __d('default','default.champE-mail').'<span class="requis">*</span>',
        'class' => 'col-md-4 control-label'
    ],
    'between' => '<div class="col-md-8">',
    'after' => '</div>',
    'required' => true
]);
?>
</div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <?php
        $listeOrganisations = [];
        foreach ($tableau['Organisation'] as $key => $datas) {
            $listeOrganisations[$datas['infos']['id']] = $datas['infos']['raisonsociale'];
        }
        
            echo $this->Form->input('Organisation.Organisation_id', [
                'options' => $listeOrganisations,
                'selected' => $this->Session->read('Organisation.id'),
                'class' => 'form-control',
                'id' => 'deroulant',
                'label' => [
                    'text' => __d('user','user.champEntite').'<span class="requis">*</span>',
                    'class' => 'col-md-4 control-label'
                ],
                'between' => '<div class="col-md-8">',
                'after' => '</div>',
                'multiple' => 'multiple',
                'required' => false
            ]);
        ?>
    </div>


    <?php
    foreach ($tableau['Organisation'] as $key => $datas) {
        $listeroles = [];
        echo "<script type='text/javascript'>";

        foreach ($datas['roles'] as $clef => $value) {
            $listeroles[$value['infos']['id']] = $value['infos']['libelle'];
            echo 'var tableau_js' . $value['infos']['id'] . '= new Array();';
            foreach ($value['droits'] as $k => $v) {
                echo "tableau_js" . $value['infos']['id'] . ".push(" . $v['liste_droit_id'] . ");";
            }
        }
        echo "</script>";
        ?>

        <div class="form-group droitsVille" id="droitsVille<?php echo $key; ?>">
            <div class="titreDiv text-center">
                <h4><?php echo $datas['infos']['raisonsociale']; ?></h4>
            </div>
            <div class="form-group">
                <?php
                if (!empty($listeservices[$datas['infos']['id']])) {
                    echo $this->Form->input('Service.' . $datas['infos']['id'], [
                        'options' => $listeservices[$datas['infos']['id']],
                        'empty' => __d('user','user.placeholderChampService'),
                        'class' => 'usersDeroulant transformSelect form-control',
                        'label' => [
                            'text' => __d('user','user.champService').'<span class="requis">*</span>',
                            'class' => 'col-md-4 control-label'
                        ],
                        'between' => '<div class="col-md-8">',
                        'after' => '</div>',
                    ]);
                }
                echo '</div><div class="form-group">';
                if (!empty($listeroles)) {
                    echo $this->Form->input('Role.' . $datas['infos']['id'], [
                        'options' => $listeroles,
                        'class' => 'form-control deroulantRoles' . $key,
                        'id' => $key,
                        'label' => [
                            'text' => __d('user','user.champProfilEntite') . $datas['infos']['raisonsociale'] . ' <span class="requis">*</span>',
                            'class' => 'col-md-4 control-label'
                        ],
                        'between' => '<div class="col-md-8">',
                        'after' => '</div>',
                        'multiple' => 'multiple'
                    ]);
                } else {
                    echo "Aucun profil n'a été créé pour cette entité";
                }
                ?>
            </div>
        </div>

        <?php
    }
    echo '</div></div>';

    echo '<div class="text-center">';


    echo '<div class="btn-group send">';
    echo $this->Html->link('<i class="fa fa-arrow-left"></i>'. __d('default','default.btnAnnuler'), $referer, [
        'class' => 'btn btn-default-default',
        'escape' => false
    ]);
    echo $this->Form->button('<i class="fa fa-check"></i>'.__d('default','default.btnEnregistrer'), [
        'type' => 'submit',
        'class' => 'btn btn-default-success'
    ]);
    echo '</div>';
    ?>

</div>
</div>
</div>
</div>
<?php
echo $this->Html->script('users.js');
?>

<script type="text/javascript">

    $(document).ready(function () {
        $("#deroulant").select2({
            placeholder: "Selectionnez une ou plusieurs entitées",
            allowClear: true
        });
    });

</script>