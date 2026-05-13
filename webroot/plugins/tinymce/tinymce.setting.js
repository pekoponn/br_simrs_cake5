tinymce.init({
	selector:'textarea',
	height: 450,
    plugins: [
    	"advlist autolink link image lists charmap preview hr anchor pagebreak spellchecker",
     	"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
     	"save table contextmenu directionality template paste textcolor"
	],
	
	toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | preview fullpage | forecolor backcolor", 
	style_formats: [
		{title: 'Bold text', inline: 'b'},
		{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
		{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
		{title: 'Example 1', inline: 'span', classes: 'example1'},
		{title: 'Example 2', inline: 'span', classes: 'example2'},
		{title: 'Table styles'},
		{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
	],
	menu: {
		edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
		insert: {title: 'Insert', items: 'link media | template hr'},
		view: {title: 'View', items: 'visualaid'},
		format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
		table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
		tools: {title: 'Tools', items: 'code'}
	},
	language: 'id'

});
//content_css: "css/content.css",