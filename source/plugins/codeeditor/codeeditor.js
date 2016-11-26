var codeeditor={}
codeeditor.instances=[];codeeditor.current=null;codeeditor.getTextareasByClass=function(name){var textareas=document.getElementsByTagName('textarea'),pattern=new RegExp('(^|\\s)'+name+'(\\s|$)'),result=[],length,i;for(i=0,length=textareas.length;i<length;i++){textarea=textareas[i];if(pattern.test(textarea.className)){result.push(textarea);}}
return result;}
codeeditor.uniqueId=function(){var prefix='codeeditor',i;while(document.getElementById(prefix+i)!==null){i++;}
return prefix+i;}
codeeditor.hasSubmit=function(form){var elements,count,i,element;elements=form.elements;for(i=0,count=elements.length;i<count;i++){element=elements[i];if(element.type=="submit"){return true;}}
return false;}
codeeditor.beforeUnload=function(e){var i,count;for(i=0,count=codeeditor.instances.length;i<count;i++){if(!codeeditor.instances[i].isClean()){return e.returnValue=codeeditor.text.confirmLeave;}}
return undefined;}
codeeditor.insertURI=function(url){var cm=codeeditor.current;cm.replaceSelection(url);cm.focus();}
codeeditor.instantiateByClasses=function(classes,config,mayPreview){var classCount,i,textareas,textareaCount,j,textarea;for(i=0,classCount=classes.length;i<classCount;i++){textareas=codeeditor.getTextareasByClass(classes[i]);for(j=0,textareaCount=textareas.length;j<textareaCount;j++){textarea=textareas[j];if(!textarea.id){textarea.id=codeeditor.uniqueId();}
codeeditor.instantiate(textarea.id,config,mayPreview);}}}
codeeditor.instantiate=function(id,config,mayPreview){var textarea=document.getElementById(id),height=textarea.offsetHeight,cm=CodeMirror.fromTextArea(textarea,config);cm.cmbMayPreview=mayPreview||false;cm.setSize(null,height);cm.on("focus",function(editor){codeeditor.current=editor;});cm.refresh();codeeditor.instances.push(cm);CodeMirror.on(window,"beforeunload",codeeditor.beforeUnload);CodeMirror.on(textarea.form,"submit",function(){CodeMirror.off(window,"beforeunload",codeeditor.beforeUnload);});}
CodeMirror.commands.save=function(cm){var form,submit;form=cm.getTextArea().form;submit=document.createElement("input");submit.setAttribute("type","submit");form.appendChild(submit);submit.click();form.removeChild(submit);}
CodeMirror.commands.toggleFullscreen=function(cm){cm.setOption("fullScreen",!cm.getOption("fullScreen"));}
CodeMirror.commands.togglePreview=function(cm){var wrapper=cm.getWrapperElement(),preview;if(!cm.cmbMayPreview){return;}
if(wrapper.previousSibling&&wrapper.previousSibling.className.indexOf("codeeditor_preview")>=0)
{preview=wrapper.previousSibling;preview.parentNode.removeChild(preview);cm.setOption("onBlur",null);if(cm.cmbFullscreen){delete cm.cmbFullscreen;CodeMirror.commands.toggleFullscreen(cm);}}else{if(cm.getScrollerElement().className.indexOf("codeeditor_fullscreen")>=0){CodeMirror.commands.toggleFullscreen(cm);cm.cmbFullscreen=true;}
preview=document.createElement("div");preview.className="codeeditor_preview";preview.innerHTML=cm.getValue();wrapper.parentNode.insertBefore(preview,wrapper);cm.setOption("onBlur",function(){CodeMirror.commands.togglePreview(cm);});}}
CodeMirror.commands.toggleFolding=function(cm){cm.foldCode(cm.getCursor());}
CodeMirror.commands.toogleLineWrapping=function(cm){cm.setOption('lineWrapping',!cm.getOption('lineWrapping'));}
CodeMirror.commands.browseImages=function(cm){if(typeof codeeditor.filebrowser=='function'){codeeditor.filebrowser('images');}}
CodeMirror.commands.browseDownloads=function(cm){if(typeof codeeditor.filebrowser=='function'){codeeditor.filebrowser('downloads');}}
CodeMirror.commands.browseMedia=function(cm){if(typeof codeeditor.filebrowser=='function'){codeeditor.filebrowser('media');}}
CodeMirror.commands.browseUserfiles=function(cm){if(typeof codeeditor.filebrowser=='function'){codeeditor.filebrowser('userfiles');}}