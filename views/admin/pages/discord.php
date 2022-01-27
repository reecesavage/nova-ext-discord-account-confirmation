<?php echo text_output($title, 'h1', 'page-head');?>

<?php echo form_open('extensions/nova_ext_discord_account_confirmation/Manage/discord/');?>



<?php if($this->session->flashdata('error')){ ?>
<div class="flash_message flash-error">
	<p><?php echo $this->session->flashdata('error'); ?></p></div>
<?php } ?>


<?php if($this->session->flashdata('success')){ ?>
<div class="flash_message flash-success">
	<p><?php echo $this->session->flashdata('success'); ?></p></div>
<?php } ?>

<p>
				<kbd>CLIENT ID</kbd>
				<input type="text" name="api_key_value" value="<?=isset($jsons['setting']['api_key'])?$jsons['setting']['api_key']:''?>" readonly >	
			</p>

			<p>
				<kbd>CLIENT SECRET</kbd>
				<input type="text" name="secret_key" value="<?=isset($jsons['setting']['secret_key'])?$jsons['setting']['secret_key']:''?>" readonly>	
			</p>

			<p>
				<kbd>Discord Id</kbd>
				<input type="text" name="discord_id" value="<?=$userModel->discord_id?>" readonly>	
			</p>

			<br>
			<button name="submit" type="submit" class="button-main" value="Submit"><span>Get Auth</span></button>
<?php echo form_close(); ?>


