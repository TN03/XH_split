{
  selector: "%SELECTOR%",
  theme: "modern",
  skin: "lightgray",
  toolbar_items_size: "small",
  menubar:false,
  plugins: [
    "advlist anchor autolink autosave charmap code contextmenu emoticons fullscreen hr imagetools",
    "image importcss insertdatetime link lists media nonbreaking paste",
    "save searchreplace table textcolor visualblocks visualchars wordcount"
  ],
  toolbar1: "save | fullscreen code formatselect fontselect fontsizeselect styleselect",
  toolbar2: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify cut copy paste pastetext | bullist numlist outdent indent blockquote",
  toolbar3: "undo redo | link unlink anchor image media | hr nonbreaking removeformat visualblocks visualchars | forecolor backcolor | searchreplace | charmap",
  toolbar4: "emoticons subscript superscript | table inserttime help",
  image_advtab: true,
  image_title: true,
  file_browser_callback: "%FILEBROWSER_CALLBACK%",
  content_css: "%STYLESHEET%",
  importcss_append:true,
  importcss_selector_filter: /(?:([a-z0-9\-_]+))(\.[a-z0-9_\-\.]+)$/i,
// %LANGUAGE% = language:"en" (fallback) or language_url = path to tinymce language file (in regard to the TinyMCE CDN Variant  
  %LANGUAGE%
  element_format: "%ELEMENT_FORMAT%",
// %PAGEHEADERS% = h1...hx for new pages, %NAMED_PAGEHEADERS% =  1. Level pageheader=h1 ...hx, %HEADERS% = remaining hy...h6
  block_formats: "%HEADERS%;p=p;div=div;%PAGEHEADERS%;code=code;pre=pre;dt=dt;dd=dd",
  "insertdatetime_formats": ["%H:%M:%S", "%d.%m.%Y", "%I:%M:%S %p", "%D"],
  relative_urls: true,
  convert_urls: false,
  entity_encoding: "raw",
  paste_data_images: true,
  images_upload_url : "./?filebrowser=imageuploader&editor=tinymce4",
//  images_upload_base_path :"",
  images_upload_credentials: true,
  save_onsavecallback: function() {
    var editor = tinymce.activeEditor;
    editor.uploadImages(function(success) {
      formObj = tinymce.DOM.getParent(editor.id, 'form');
      if (formObj) {
        editor.isNotDirty = true;
        if (!formObj.onsubmit || formObj.onsubmit()) {
          if (typeof formObj.submit == "function") {
            formObj.submit();
          } else {
            editor.windowManager.alert("Error: Form submit field collision.");
          }
        }
//        editor.nodeChanged();
      } else {
        editor.windowManager.alert("Error: No form element found.");
      }
//      console.log("Uploaded images and posted content as an ajax request.");
    });
  }
 }