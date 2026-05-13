<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="id" lang="id">
<head>
	<title>Print Document
		<?php __('&ouml;&ouml;&ouml;&nbsp;');
		echo "&nbsp;&ouml;&ouml;&ouml;&nbsp;--&nbsp;" ;
		//echo $title_for_layout; ?>
	</title>
	<style type="text/css" media="print">
        @page 
        {
            size: auto;   /* auto is the initial value */
            margin: 0mm;  /* this affects the margin in the printer settings */
			
        }
		
		@media print {
			#header, #footer { 
				visibility: hidden !important;
				display: none !important;
			}
		}

        body 
        {
            background-color:#FFFFFF; 
            /* border: solid 1px black ; */
            margin: 0px;  /* this affects the margin on the content before sending to printer */
			
			font-family: sans-serif;
			
			color: black;	
       }
	   
	   #BrowserPrintDefaults{display:none} 
	   
	   #menu { 
			display: none; 
		}
			
		#wrapper, 
		#content { 
			width: auto; 
			margin: 0 5%; 
			padding: 0; 
			border: 0; 
			float: none !important; 
			color: black; 
			background: transparent none;
			font-size: 16pt;
		}
			
		div#content { 
			margin-left: 10%; 
			padding-top: 1em; 
			border-top: 1px solid #930; 
		}
			
		div#mast { 
			margin-bottom: -8px; 
		}
			
		div#mast img { 
			vertical-align: bottom; 
		}
			
		a:link, 
		a:visited { 
			color: #520; 
			background: transparent; 
			font-weight: bold; 
			text-decoration: underline; 
		}
			
		#content a:link:after, 
		#content a:visited:after { 
			content: " (" attr(href) ") "; 
			font-size: 90%; 
		}
    </style>
</head>	
<script type="text/javascript">

window.print();
window.onfocus=function(){ window.close();}

</script>
<body>
<div id="main" align="left">
	<div class="content">
		<?= $this->fetch('content') ?>
	</div>
</div>
</body>
</html>