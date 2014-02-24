<?php 
#####################################################################################
#  Module Download Updater for Opencart 1.5.x From Eric Baker ericbaker.me 			#
#####################################################################################
?>
<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>

<div class="box">
  <div class="heading">
    <h1><img src='view/image/feed.png' /><?php echo $heading_title; ?></h1>
  </div>
  <div class="content">
  	
	<div id="tab_import">
		<table class="form">
        <tr class="instructions">
        	<td colspan="3">This page is where you run the import from once your settings and mappings are all ready. First, choose what type of import you want to run - add, update or reset. Next, if there are any products you want to exclude from the import, you can say exclude any products which have &lt;field&gt; with this &lt;value&gt;.
        	For example, you may want to exclude all items where stock is 0. You would put stock in the column field and 0 in the value field. Finally, either upload a file or enter a url in the field provided and click import.</td>
        </tr>
		<!-- update/reset/add -->
		<tr>
			<td><?php echo $entry_import_type; ?></td>
			<td colspan="2">
				<select name="csv_import_type" onchange="updateText(this);">
					<option value="add"><?php echo $text_add; ?></option>	
					<option value="update"><?php echo $text_update; ?></option>	
					<option value="reset"><?php echo $text_reset; ?></option>
				</select>
				<span id="update_text">
				Update Based on Field: 
				<select name="csv_import_update_field">
					<option value="model"><?php echo $text_field_model; ?></option>	
					<option value="sku"><?php echo $text_field_sku; ?></option>	
					<option value="name"><?php echo $text_field_name; ?></option>
				</select>
				&nbsp;&nbsp;Update any products that already have the same value for the chosen attribute, add the rest
				</span>
				<span id="add_text">&nbsp;&nbsp;Leave current items alone, add all products from feed as new items</span>
				<span id="reset_text">&nbsp;&nbsp;Delete all products from the shop, import feed to empty shop</span>
		</tr>
		<!-- ignore where FIELD equals VALUE -->
		<tr>
			<td><?php echo $entry_ignore_fields; ?></td>
			<td colspan="2"><input type="text" name="csv_import_ignore_field" value="COLUMN">&nbsp;contains&nbsp;<input type="text" name="csv_import_ignore_value" value="VALUE"></td>
		</tr>
		<!-- File.. -->
		<tr>
            <td><?php echo $entry_import_file; ?></td>
            <td colspan="2"><input type="file" name="csv_import" /></td>
        </tr>
		<!-- ..or URL -->
		<tr>
            <td><?php echo $entry_import_url; ?></td>
			<td><input type="text" size="70" name="csv_import_feed_url" value="<?php echo $csv_import_feed_url ?>" />&nbsp;Unzip Feed <input type="checkbox" name="csv_import_unzip_feed" <?php if ($csv_import_unzip_feed) echo 'checked="1" '; ?>/></td>
            <td><a onclick="$('#csv_import').submit();" class="button"><span><?php echo $button_import; ?></span></a></td>
        </tr>
        </table>
       </div>
      </form>
  </div>
</div><script type="text/javascript"><!--
$('#tabs a').tabs(); 
//--></script>
<?php echo $footer; ?>