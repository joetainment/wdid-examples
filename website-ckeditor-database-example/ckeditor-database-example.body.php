<div style="float: right; width: 400px;">
		<h1>Ajax Examples</h1>
		<a href="#" id="ajaxExampleSetCkeditorToPresetText" onClick="return false;">
			Ajax Example - Set Editor To Preset Text
		</a>
		<br><br>
		<a href="#" id="ajaxExampleCensorCkeditorText" onClick="return false;">
			Ajax Example - Censor Text In Editor
		</a>
		<br><br>		<br><br>
		<a href="#" id="ajaxExampleSaveCkeditorText" onClick="return false;">
			Save Editor Text
		</a>
		<br><br>
		<a href="#" id="ajaxExampleRevertCkeditorText" onClick="return false;">
			Revert to before save (via ajax)
		</a>
		<br><br>		<h1>Page Reload Examples</h1>
		<a href="ckeditor-database-example.php">
			Revert to before save (via page reload)
		</a>        <br><br>
		<a href="ckeditor-database-example.php?nuke=1">
			Nuke the entire database!
		</a>
	
		<h1> Preview: </h1>
		<div id="preview"></div>
	</div>
	
	<div style="width: 500px;">
		<h1 style="margin-top: 5px;margin-bottom: 5px;">Ckeditor Example</h1>	
		<form
			action="ckeditor-database-example.php"
			method="post"
			>

			<textarea name="ckeditor">
			</textarea>
			<input type="submit" value="Save">
		</form>
	</div>

<br>