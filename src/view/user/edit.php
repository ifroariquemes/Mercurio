<?php

use controller\user\accountType\AccountTypeControl;
use controller\user\UserController;

global $_User;
$user = $data['user'];
?>    
<header class="row">     
    <div class="col-md-6"><h2 data-i18n='user:label.<?= $data['action'] ?>_user'>% user</h2></div>
</header>    
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <form name="FrmEdit" id="FrmEdit" role="form" onsubmit="user.submit(event);">
                    <fieldset>
                        <div class="form-group">
                            <label for="textName"><span data-i18n="user:label.name">Name</span>*:</label>                            
                            <input type="text" required="required" name="name" id="textName" class="form-control" value="<?= $user->getName() ?>">                            
                        </div>                                           
                        <div class="form-group">
                            <label for="selectaccountTypeId"><span data-i18n="user:label.account_type">Account type</span>*:</label>                            
                            <?php AccountTypeControl::showSelection($user->getId(), $user->getAccountType()->getId()) ?>                                                    
                        </div>        
                        <div class="form-group">
                            <label for="textEmail"><span data-i18n="user:label.email">E-mail</span>*:</label>                            
                            <input <?php if ($user->getId()) : ?>readonly<?php endif; ?> required="required" type="email" name="email" id="textEmail" class="form-control" value="<?= $user->getEmail() ?>">                            
                        </div>
                        <?php if (!$user->getId()) : ?>
                            <div class="form-group">
                                <label><span data-i18n="user:label.password">Password</span>:</label>                                
                                <span style="font-size: 16px; font-weight: bold"><?= $passGen = substr(uniqid(), 7); ?></span>
                                <input type="hidden" name="newPassword" value="<?= $passGen; ?>">                                
                            </div>
                            <div class="form-group">
                                <label for="checkEmailDet"><span data-i18n="user:label.email_details">E-mail account details to new user?</span></label>
                                <input type="checkbox" checked="checked" name="emailDetails" id="checkEmailDet" value="true">
                            </div>
                            <input type="hidden" id="textActualPassword">                        
                        <?php endif; ?>
                    </fieldset>
                    <input type="hidden" name="id" value="<?= $user->getId() ?>">            
                    <div class="text-right">            
                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> <span data-i18n="mycookie:button.save">Save</span></button>                        
                        <button class="btn btn-danger" type="button" onclick="history.go(-1);"><i class="fa fa-times"></i> <span data-i18n="mycookie:button.cancel">Cancelar</span></button>                        
                    </div>
                </form>                
            </div>
        </div>        
    </div>
    <?php if ($user->getId()) : ?>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" data-i18n="user:message.change">Want to change password?</h3>
                </div>
                <div class="panel-body">
                    <form name="FrmEditPassword" id="FrmEditPassword" onsubmit="user.changePassword(event)">
                        <div class="form-group">
                            <label for="textActualPassword" data-i18n="user:label.password">Password</label>                            
                            <input required="required" type="password" name="actualPassword" id="textActualPassword" class="form-control" value="" onblur="user.event_onBlurActualPassword()">                            
                        </div>
                        <div class="form-group">
                            <label for="textNewPassword"><span data-i18n="user:label.new_password">New password</span>:</label>                            
                            <input required="required" pattern=".{6,32}" onchange="user.event_onChangePassword()" type="password" name="newPassword" id="textNewPassword" class="form-control" value="">                            
                        </div>
                        <div class="form-group">
                            <label for="textPasswordRepeat"><span data-i18n="user:label.repeat_new_pwd">Repeat new password</span>:</label>                            
                            <input required="required" type="password" onchange="user.event_onChangePassword()" name="passwordRepeat" id="textPasswordRepeat" class="form-control" value="">                            
                        </div>
                        </fieldset>
                        <input type="hidden" name="id" value="<?= $user->getId() ?>">                
                        <div class="text-right">                           
                            <button class="btn btn-default" type="submit"><i class="fa fa-edit"></i> <span data-i18n="user:button.change_pwd">Change password</span></button>                
                        </div>
                    </form>                     
                    <div class="text-right">
                        <br>
                        <?php if ($user->getStatus()) : ?>
                            <a href="#" onclick="user.deactivate(event)" data-i18n="user:button.deactivate">Deactivate user</a>
                        <?php else : ?>
                            <span class="alert-danger" data-i18n="user:message.deactivated">This user is deactivated</span> <a href="#" onclick="user.reactivate(event)" data-i18n="user:button.reactivate">Reactivate user?</a>
                        <?php endif; ?>
                        <?php if (UserController::isAdministratorLoggedIn()) : ?>    
                            | <a href="#" onclick="user.delete(event)" data-i18n="user:button.delete">Delete user</a>                
                        <?php endif; ?>
                    </div>                    
                </div>
            </div>                       
        </div>
    <?php endif; ?>
</div>
<script>
    require(['jquery'], function ($) {
        $('#textName').focus();
        document.getElementById('textActualPassword').setCustomValidity($.i18n.t('user:message.incorrect_pwd'));
    });
</script>