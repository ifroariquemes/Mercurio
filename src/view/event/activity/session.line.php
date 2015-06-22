<tr>
    <td><input type="hidden" name="Sessions[date][]" value="<?= $data->getDate() ?>"><?= $data->getDateStr() ?></td>
    <td><input type="hidden" name="Sessions[start][]" value="<?= $data->getStart() ?>"><?= $data->getStart() ?></td>
    <td><input type="hidden" name="Sessions[end][]" value="<?= $data->getEnd() ?>"><?= $data->getEnd() ?></td>
    <td><button type="button" onclick="$(this).parent().parent().remove()" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
</tr>