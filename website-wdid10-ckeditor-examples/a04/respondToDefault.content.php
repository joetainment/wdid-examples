<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport"
		<title>CKEditor Example A</title>

		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="//cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
        <script id="phpGeneratedScript"></script>
		<script src="main.js"></script>		

	</head>
	<body>
	
		<form method="post">
			<textarea
				name="editor1"
				id="editor1"
				row="10" cols="80">

				This text will be replaced by
				ckeditor, and will become, by default
				the text used by CKEditor
			</textarea>
            <input type="submit" value="Submit">
		</form>

        <br><br>
        
        <input type="button" id="clear" value="Clear CKEditor Contents">
        
        <input type="button" id="SimpleRequestButton"
            value="Send CKEditor Data as AJAX (response to be shown below)"
        >
        
        <div id="SimpleRequestResponseDiv">
        </div>
        
        
        
        
        
	</body>

</html>