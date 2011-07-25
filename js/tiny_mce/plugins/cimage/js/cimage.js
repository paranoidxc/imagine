tinyMCEPopup.requireLangPack();

var CimageDialog = {
  init : function(ed) {;
    tinyMCEPopup.resizeToInnerSize();
	},
// 	insert : function(file,title) {
 	insert : function(html) {
		var ed = tinyMCEPopup.editor, dom = ed.dom;
//    var filetype='png,jpg,jpeg,gif';
 //   var _type = file.substring( file.lastIndexOf('.')+1,file.lenght).toLowerCase();
  //  if( filetype.indexOf( _type ) == -1 ) {
     // var h = "<p><em>文件: <a href='"+file+"' title='"+title+"' target='_blank'/>点击下载</em></p>";
   // }else{
      //var h = "<p><img src='"+file+"' title='"+title+"' alt='"+title+"'/></p>";
    //}
    tinyMCEPopup.execCommand('mceInsertContent', false, html );
	}
};

tinyMCEPopup.onInit.add(CimageDialog.init, CimageDialog);
