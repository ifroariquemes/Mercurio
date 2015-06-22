<tr>
    <td><input type="hidden" name="Translations[Name][]" value="<?= $data->getName() ?>"><?= $data->getName() ?></td>
    <td><input type="hidden" name="Translations[Lang][]" value="<?= $data->getLanguage() ?>"><?= $data->getLanguage() ?></td>
    <td><button type="button" onclick="$(this).parent().parent().remove()" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
</tr>