<?php /* Smarty version Smarty-3.1.16, created on 2016-01-13 16:04:43
         compiled from "/home/janilv/public_html/php-ruhmatoo-projekt/forum/admin/layout/templates/permission/roles.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12423113875696759b897ce0-17964233%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ac3c7d6c1bd6ecce32ed7a3e373cb73e780b8e85' => 
    array (
      0 => '/home/janilv/public_html/php-ruhmatoo-projekt/forum/admin/layout/templates/permission/roles.tpl',
      1 => 1438645514,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12423113875696759b897ce0-17964233',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'msg' => 0,
    'msgType' => 0,
    'token' => 0,
    'roles' => 0,
    'role' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_5696759b988644_78739846',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5696759b988644_78739846')) {function content_5696759b988644_78739846($_smarty_tpl) {?><section class="content-header" id="breadcrumb_forthistemplate_hack">
    <h1>&nbsp;</h1>
    <ol class="breadcrumb" style="float:left; left:10px;">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><i class="fa fa-users"></i> Roles</li>
    </ol>

</section>

<?php if ($_smarty_tpl->tpl_vars['msg']->value=='') {?>
<?php } else { ?>
    <div class="alert alert-<?php echo $_smarty_tpl->tpl_vars['msgType']->value;?>
 alert-dismissable">
        <i class="fa fa-info"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $_smarty_tpl->tpl_vars['msg']->value;?>

    </div>
<?php }?>


<div class="row" id="add_cat">
    <div class="col-lg-4"> 
        <div class="box box-info ">

            <form class="box-body" action="index.php?page=permission/roles" role="form" id="add_user_form" method="post">

                <input type="hidden" name="CSRF_token" value="<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
" />

                <input type="text" name="role_name"  value="" class="form-control" placeholder="Role Name"  required="required"/>
                <br/>

                <p class="help-block">Copy permissions from role: </p>                
                <select name="copy_from_role_id" class="form-control">
                    <?php  $_smarty_tpl->tpl_vars['role'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['role']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['roles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['role']->key => $_smarty_tpl->tpl_vars['role']->value) {
$_smarty_tpl->tpl_vars['role']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['role']->value['rid'];?>
"><?php echo $_smarty_tpl->tpl_vars['role']->value['rname'];?>
</option>
                    <?php } ?>
                </select>
                <br/>

                <input type="submit" value="Add Role" class="btn btn-success" />

            </form>


        </div>

    </div>


</div>


<div class="row">
    <div class="col-lg-6">

        <div class="box box-success">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role Name</th>
                                <th style="text-align: center">Actions</th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php  $_smarty_tpl->tpl_vars['role'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['role']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['roles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['role']->key => $_smarty_tpl->tpl_vars['role']->value) {
$_smarty_tpl->tpl_vars['role']->_loop = true;
?>
                                <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['role']->value['rid'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['role']->value['rname'];?>
</td>
                                    <td style="text-align: center">

                                        <a class="btn btn-sm btn-primary" href="index.php?page=permission/role_edit&role_id=<?php echo $_smarty_tpl->tpl_vars['role']->value['rid'];?>
" title="Edit Role"><i style="color:#fff" class="fa fa-edit"></i> Edit permissions</a>                                                            

                                        &nbsp;&nbsp; <a class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="delete_role(<?php echo $_smarty_tpl->tpl_vars['role']->value['rid'];?>
);" title="Delete Role"><i style="color:#fff" class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="delete_role_form" method="post" action="index.php?page=permission/roles&action=delete">
    <input type="hidden" id="del_role_id" name="del_role_id" value=""/>
    <input type="hidden" name="CSRF_token" value="<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
" />

</form> 
<script type="text/javascript">

    function delete_role(id) {

        var r = confirm("Are you sure, you want to delete?");
        if (r === true)
        {

            $('#del_role_id').val(id + '');
            $('#delete_role_form').submit();

        }
        else
        {
            return;
        }
    }

</script><?php }} ?>
