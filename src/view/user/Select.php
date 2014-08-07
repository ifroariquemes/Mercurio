<select name="User" id="selectUser">
    <option></option>
    <?php foreach ($data as $user) : ?>
        <option value="<?php echo $user->getId() ?>"><?php echo $user->getCompleteName() ?></option>
    <?php endforeach; ?>
</select>
<script type="text/javascript">
    require(['jquery'], function($) {
        $(function() {
            $('#selectUser').select2({allowClear: true});
        });
    });
</script>