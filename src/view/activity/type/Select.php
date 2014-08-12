<label for="selectType"><?php _e('Type', 'activity') ?>:</label><a href="#" onclick="tpe.manage(event)"><i class="fa fa-gear"></i></a>
<select name="Type" id="selectType" required="required">
    <option></option>
    <?php foreach ($data['types'] as $type) : ?>
        <option value="<?php echo $type->getId() ?>" <?php if ($type->getId() == $data['id']): ?>selected="selected"<?php endif; ?>><?php echo $type->getName() ?></option>
    <?php endforeach; ?>
</select>         
<script type="text/javascript">
    require(['jquery'], function($) {
        $(function() {
            $('#selectType').select2();
        });
    });
</script>