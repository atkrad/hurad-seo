<div class="form-group clearfix">
    <?php echo $this->PluginForm->label(
        'PostMeta.keywords',
        __d('hurad_seo', 'Keywords'),
        ['class' => 'control-label col-lg-2']
    ); ?>
    <div class="col-lg-10">
        <?php echo $this->PluginForm->input('PostMeta.keywords', ['class' => 'form-control']); ?>
    </div>
</div>

<div class="form-group">
    <?php echo $this->PluginForm->label(
        'PostMeta.description',
        __d('hurad_seo', 'Description'),
        ['class' => 'control-label col-lg-2']
    ); ?>
    <div class="col-lg-10">
        <?php echo $this->PluginForm->input(
            'PostMeta.description',
            ['class' => 'form-control', 'type' => 'textarea']
        ); ?>
    </div>
</div>