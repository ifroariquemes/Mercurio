<select name="organization" id="selectOrganization" required="required" class="form-control">
    <option></option>
    <?php foreach ($data['organizations'] as $organization) : ?>
        <option value="<?= $organization->getId() ?>" <?php if ($organization->getId() == $data['id']) : ?>selected="selected"<?php endif; ?>><?= $organization->getName() ?></option>
    <?php endforeach; ?>
</select>