/*
 * @version $Id: init.js 193 2013-09-28 20:25:10Z hi $
 *
 */

function CKeditor_getTextareasByClass(name) {
    var textareas = document.getElementsByTagName('textarea');
    var pattern = new RegExp('(^|\\s)' + name + '(\\s|$)');
    var res = new Array();
    for (var i = 0, j = 0; i < textareas.length; i++) {
        if (pattern.test(textareas[i].className)) {
            res[j++] = textareas[i];
        }
    }
    return res;
}

function CKeditor_uniqueId() {
    var id = 'CKeditor';
    var i = 0;
    while (document.getElementById(id + i) !== null) {
        i++
    }
    return id + i;
}

function CKeditor_instantiateByClasses(classes, config) {
    classes = classes.split('|');
    for (var i = 0; i < classes.length; i++) {
        var textareas = CKeditor_getTextareasByClass(classes[i]);
        for (var j = 0; j < textareas.length; j++) {
            if (!textareas[j].getAttribute('id')) {
                textareas[j].setAttribute('id', CKeditor_uniqueId());
            }
            CKEDITOR.replace( textareas[j].getAttribute('id'), config);
        }
    }
    
}

//Source formatting
	
CKEDITOR.on( 'instanceReady', function( ev )
{
    var writer = ev.editor.dataProcessor.writer; 
    // The character sequence to use for every indentation step.
    writer.indentationChars = '    ';
	
    var dtd = CKEDITOR.dtd;
    // Elements taken as an example are: block-level elements (div or p), list items (li, dd), and table elements (td, tbody).
    for ( var e in CKEDITOR.tools.extend( {}, dtd.$block, dtd.$listItem, dtd.$tableContent ) )
    {
        ev.editor.dataProcessor.writer.setRules( e, {
            // Indicates that an element creates indentation on line breaks that it contains.
            indent : false,
            // Inserts a line break before a tag.
            breakBeforeOpen : true,
            // Inserts a line break after a tag.
            breakAfterOpen : false,
            // Inserts a line break before the closing tag.
            breakBeforeClose : false,
            // Inserts a line break after the closing tag.
            breakAfterClose : true
        });
    }
	
    for ( var e in CKEDITOR.tools.extend( {}, dtd.$list, dtd.$listItem, dtd.$tableContent ) )
    {
        ev.editor.dataProcessor.writer.setRules( e, {			
            indent : true,
        });
    }
		
    ev.editor.dataProcessor.writer.setRules( 'br',
    { 		
        indent : false,
        breakAfterOpen : false
    });
	
});


//Speichern-Nachfrage

//fix by CMB: Browse Server Button triggert beforeunload im IE wg. href="javascript:void(0)"
CKEDITOR.on('instanceCreated', function (event) {
    event.editor.on('dialogShow', function (dialogShowEvent) {
	var el = dialogShowEvent.data._.element.$;
	var as = el.getElementsByTagName("a");
	var n, i, a;

	for (i = 0, n = as.length; i < n; ++i) {
	    a = as[i];
	    if (a.href == "javascript:void(0)") {
		a.removeAttribute("href");
	    }
	}
    });
});

// code from http://stackoverflow.com/questions/5618689/ck-editor-cant-catch-submit
var CMSimpleSaveCmd = {
    modes : {
        wysiwyg:1, 
        source:1
    },
    exec : function( editor ){
        /*
	   if (!editor.checkDirty()) {
           alert('Nothing changed!');
           return;
       }
	   */
        if ( window.addEventListener )
            window.removeEventListener( 'beforeunload', CKeditor_beforeUnload, false );
        else
            window.detachEvent( 'onbeforeunload', CKeditor_beforeUnload );
        editor.element.$.form.submit();
    }
};

var pluginName = 'CMSimpleSave';

// Register a plugin named "CMSimpleSave".
CKEDITOR.plugins.add(pluginName, {
    init : function( editor ){
        var command = editor.addCommand( pluginName, CMSimpleSaveCmd );
        command.modes = {
            wysiwyg : !!( editor.element.$.form )
        };

        editor.ui.addButton( 'CMSimpleSave',{
            label     : editor.lang.save.toolbar,
            command   : pluginName,
            icon      : 'save',
            //toolbar   : 'document,10'
            toolbar   : 'mode,0'
        });
    }
});

function CKeditor_beforeUnload( e )
{
    for(var i in CKEDITOR.instances) {
        if ( CKEDITOR.instances[i].checkDirty() )
            return e.returnValue = "You will lose the changes made in the editor.";
    }
}

if ( window.addEventListener )
    window.addEventListener( 'beforeunload', CKeditor_beforeUnload, false );
else
    window.attachEvent( 'onbeforeunload', CKeditor_beforeUnload );