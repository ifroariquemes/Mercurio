<tr>
    <td><?php echo $data->getName() ?></td>
    <td class="text-right">
        <button class="btn btn-default" onclick="tpe.edit(<?php echo $data->getId() ?>)"><i class="fa fa-edit"></i></button>
        <button class="btn btn-danger" onclick="tpe.delete(<?php echo $data->getId() ?>)"><i class="fa fa-trash-o"></i></button>
    </td>
</tr>