<?php /* Smarty version Smarty-3.1.16, created on 2016-01-13 16:04:41
         compiled from "/home/janilv/public_html/php-ruhmatoo-projekt/forum/admin/layout/templates/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2024749506569675993c7470-34957156%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7b98c1affac77350beb200b9f021ea835f6d80a' => 
    array (
      0 => '/home/janilv/public_html/php-ruhmatoo-projekt/forum/admin/layout/templates/login.tpl',
      1 => 1438645514,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2024749506569675993c7470-34957156',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'msg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_569675993fa409_30989254',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_569675993fa409_30989254')) {function content_569675993fa409_30989254($_smarty_tpl) {?><section class="content-header" id="breadcrumb_forthistemplate_hack">
    <h1>&nbsp;</h1>
    <ol class="breadcrumb" style="float:left; left:10px;">
         <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
         <li class="active"><i class="fa fa-lock"></i> Login</li>
    </ol>
    
</section>



<div class="row" id="msg_cntnr">
    <div class="col-lg-4"><!-- just an empty tag so that the next div looks centeres--> </div>
    <div class="col-lg-4">
        <?php if ($_smarty_tpl->tpl_vars['msg']->value=='') {?>

        <?php } else { ?>
            <div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
</div>
        <?php }?>

    </div>
</div>
<br/>


<div class="row" id="add_cat">
    <div class="col-lg-4"><!-- just an empty tag so that the next div looks centeres--> </div>
    
    <div class="col-lg-4">
        <div class="box box-primary">
            <div class="box-header" style="text-align: center">
                <img src="<?php echo @constant('A_RURI');?>
img/mstile-70x70.png" />
            </div>
            <hr/>
            <form class="box-body" action="?page=login" role="form" method="post" enctype="multipart/form-data">
               
                <input type="text" name="username"  value="" class="form-control" placeholder="Username" required />
                <br/>
                <input type="password" name="password"  value="" class="form-control" placeholder="Password" required />
                <br/>
                <input type="submit" value="Login" class="btn btn-success btn-block" />

            </form>
        </div>
    </div>

</div>
                        
            
<script type="text/javascript">

    jQuery('input[name=username]').focus();

</script><?php }} ?>
