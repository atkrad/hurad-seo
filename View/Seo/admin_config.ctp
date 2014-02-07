<div class="page-header">
    <h2><?php echo $title_for_layout; ?></h2>
</div>


<?php
echo $this->Form->create(
    'HuradSeo',
    [
        'class' => 'form-horizontal',
        'inputDefaults' => [
            'label' => false,
            'div' => false
        ]
    ]
);
?>

<h3 class="sub-header">
    <?= __d('hurad_seo', 'Webmaster Tools'); ?>
    <br>
    <small><?php echo __d(
            'hurad_seo',
            'You can use the boxes below to verify with the different Webmaster Tools, if your site is already verified, you can just forget about these. Enter the verify meta values for:'
        ); ?></small>
</h3>

<div class="form-group">
    <?php echo $this->Form->label(
        'google_webmaster_verification',
        __d('hurad_seo', 'Google Webmaster Config'),
        ['class' => 'control-label col-lg-3']
    ); ?>
    <div class="col-lg-4">
        <?php
        echo $this->Form->input(
            'google_webmaster_verification',
            [
                'required' => false, //For disable HTML5 validation
                'type' => 'text',
                'class' => 'form-control'
            ]
        );
        ?>
    </div>
</div>

<?php echo $this->Form->button(__d('hurad_seo', 'Save Changes'), ['type' => 'submit', 'class' => 'btn btn-primary']); ?>

<?php echo $this->Form->end(); ?>
