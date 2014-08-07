<tr>
    <td><input type="hidden" name="Speakers[]" value="<?php echo $data->getId() ?>"><?php echo $data->getCompleteName() ?></td>
    <td><button type="button" onclick="$(this).parent().parent().remove()" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></td>
</tr>