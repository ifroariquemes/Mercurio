<label for="selectType"><?php _e('Type', 'activity') ?>:</label><a href="#" onclick="manage(event)"><i class="fa fa-gear"></i></a>
<select name="Type" id="selectType" required="required">
    <option></option>
    <?php foreach ($data as $type) : ?>
        <option value="<?php echo $type->getId() ?>"><?php echo $type->getName() ?></option>
    <?php endforeach; ?>
</select>         
<script type="text/javascript">
    require(['jquery'], function($) {
        $(function() {
            $('#selectType').select2();
        });
    });
    
    function manage(e) {
        e.preventDefault();
        MyCookieJS.showDynamicPopup('mdTypeManage', 'activity/type/manage');
    }
</script>