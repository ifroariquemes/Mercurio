<tr>
    <td><?= $data->getName() ?></td>
    <td class="text-right">
        <button class="btn btn-default" onclick="activity_type.edit(<?= $data->getId() ?>)"><i class="fa fa-edit"></i></button>
        <button class="btn btn-danger" onclick="activity_type.delete(<?= $data->getId() ?>)"><i class="fa fa-trash-o"></i></button>
    </td>
</tr>