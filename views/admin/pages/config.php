<?php echo text_output($title, 'h1', 'page-head');?>

<?php echo form_open('extensions/nova_ext_discord_account_confirmation/Manage/config/');?>
         

          <?php if(empty($jsons['setting']['api_key'])){ ?>
               <p>No Discord Bot Credentials are stored.</p>
          <?php }else { ?>
                 <p><?=$jsons['setting']['bot_name']?> Discord Bot Credentials are stored.</p>
         <?php  } ?>
           <p>
				<kbd>Game API Token</kbd>
				<input type="text" name="apiToken" value="<?=isset($jsons['setting']['apiToken'])?$jsons['setting']['apiToken']:''?>" readOnly>	
			</p>


		
			<br>
			<button name="submit" type="submit" class="button-main" value="Submit"><span>Rotate API Token</span></button>
<?php echo form_close(); ?>

<?php echo form_open('extensions/nova_ext_discord_account_confirmation/Manage/config/');?>
  <br>
  <button name="delete" type="submit" class="button-main" value="delete"><span>Delete Setting</span></button>

<?php echo form_close(); ?>


<?php if(!empty($fields)){ ?>
<?php echo form_open('extensions/nova_ext_discord_account_confirmation/Manage/config/');?>
        

			<p>
				<kbd>Database Columns Missing - This is expected if it is the first time you have used this Extension or an update has produced a change. Click the Create Column button below for each missing column or check the README file for manual instructions.</kbd>
				<select name="attribute">
				<?php foreach($fields as $key=>$field){?>
                  <option value="<?=$field?>"><?=$field?></option>
				<?php }?>
				</select>
			</p>

			<br>
			<button name="submit" type="submit" class="button-main" value="Add"><span>Create Column</span></button>
<?php echo form_close(); ?>
<?php } else { ?>
   <div><br>All expected columns found in the database</div>
    
<?php } ?>




