<textarea id="<?php echo $editor_textarea['id']; ?>" name="<?php echo $editor_textarea['name']; ?>" rows="10" cols="80"><?php echo $editor_textarea['value']; ?></textarea>


<script type="text/javascript">

// This is a check for the CKEditor class. If not defined, the paths must be checked.
if ( typeof CKEDITOR == 'undefined' )
{
	document.write(
		'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
		'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
		'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
		'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
		'value (line 32).' ) ;
}
else
{




	
	
	
	var editor = CKEDITOR.replace( '<?php echo $editor_textarea['id']; ?>' );
	//editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );
	
editor.config.width = '<?php echo $editor_textarea['w']; ?>';
editor.config.height = '<?php echo $editor_textarea['h']; ?>';

//editor.config.extraPlugins = 'imgbrowser';
//editor.config.extraPlugins = 'imgbrowser';


editor.config.toolbar = 'MyToolbar';

/*
var ckEditorInstance = CKEDITOR.replace('DivIdToReplaceAsCKEditor',{
toolbar: [
['Bold'], ['Italic'], ['newplugin'],
]
});
*/
    editor.config.toolbar_MyToolbar =
    [
	['Source','-'],['Newplugin'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat','Styles','Format','Font','FontSize'],
	['Image'],'/',
	['Cut','Copy','Paste','PasteText','PasteFromWord'],
	['TextColor','BGColor'],
        ['Bold','Italic','Underline','Strike'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Link','Unlink','Anchor','-','Table','-','HorizontalRule','-','SpecialChar']
    ];








	// Just call CKFinder.SetupCKEditor and pass the CKEditor instance as the first argument.
	// The second parameter (optional), is the path for the CKFinder installation (default = "/newsletter/ckfinder/").
	//CKFinder.SetupCKEditor( editor, '<?php echo $directory_CKFinder; ?>' ) ;
	CKFinder.SetupCKEditor( editor, '<?php echo $rootCkfinder; ?>' ) ;

	// It is also possible to pass an object with selected CKFinder properties as a second argument.
	//CKFinder.SetupCKEditor( editor, { BasePath : '<?php echo $rootCkfinder; ?>', RememberLastFolder : false } ) ;	


	editor.filebrowserBrowseUrl('/browser/browse.php');
}



		</script>

