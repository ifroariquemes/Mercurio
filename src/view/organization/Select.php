<select name="organization" id="selectOrganization" required="required">
    <option></option>
    <?php foreach ($data['organizations'] as $organization) : ?>
        <option value="<?php echo $organization->getId() ?>" <?php if ($organization->getId() == $data['id']) : ?>selected="selected"<?php endif; ?>><?php echo $organization->getName() ?></option>
    <?php endforeach; ?>
</select>
<script type="text/javascript">
    require(['jquery'], function($) {
        $('#selectOrganization').select2({
            placeholder: 'Select an organization...'
        });
    });
</script>
