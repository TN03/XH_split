
/*
 * @version $Id: ckeditor_ilinks_src.js 138 2013-05-30 17:22:31Z hi $
 *
 */

// // Internal Links, displayed in Link-Dialog
// http://attic.ist.unomaha.edu/blogs/zac/2011/04/01/ckeditor-adding-a-select-list-of-urls-for-users-in-a-cms/

// When opening a dialog, its "definition" is created for it, for
// each editor instance. The "dialogDefinition" event is then
// fired. We should use this event to make customizations to the
// definition of existing dialogs.

CKEDITOR.on( 'dialogDefinition', function( ev )
	{
		// Take the dialog name and its definition from the event
		// data.
		var dialogName = ev.data.name;
		var dialogDefinition = ev.data.definition;
 
		// Check if the definition is from the dialog we're
		// interested on (the "Link" dialog).
		if ( dialogName == 'link' )
		{
			// Get a reference to the "Link Info" tab.
			// CKEDITOR.dialog.definition.content
			var infoTab = dialogDefinition.getContents( 'info' );
 
			// Add a new UI element to the info box.
			// Use a JSON array named items to grab the list.
			// Modify the onChange event to update the real URL field.
			infoTab.add(
			{
				type : 'vbox',
				id : 'localPageOptions',
				children : [
				{
					type : 'select',
					label : 'CMSimple-Links',
					id : 'localPage',
					title : 'CMSimple-Links',
					items: CMSLinkList,  //JSON-Array with Link-Data
					onChange : function(ev) {
						var diag = CKEDITOR.dialog.getCurrent();
						var url = diag.getContentElement('info','url');
						url.setValue(ev.data.value);
					}
				}]
			}
			);
			// Rewrite the 'onFocus' handler to always focus 'url' field.
			dialogDefinition.onFocus = function()
			{
				var urlField = this.getContentElement( 'info', 'url' );
				urlField.select();
			};
		}
	});