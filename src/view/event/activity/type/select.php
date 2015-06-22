<label for="selectType"><span data-i18n="event:activity.type.label.type"></span>:</label><a href="#" onclick="activity_type.manage(event)"><i class="fa fa-gear"></i></a>
<select name="Type" id="selectType" required="required" class="form-control">
    <option></option>
    <?php foreach ($data['types'] as $type) : ?>
        <option value="<?= $type->getId() ?>" <?php if ($type->getId() == $data['id']): ?>selected="selected"<?php endif; ?>><?= $type->getName() ?></option>
    <?php endforeach; ?>
</select>     