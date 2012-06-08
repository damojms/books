{{*<!--
		Name:		 Calibre PHP webserver
		License:	 GPL v3
		Copyright:	 2010, Charles Haley <charles@haleys.org
-->*}}
{{include file="header.tpl" title="Home"}}
<table><tr><td>
<div style="padding-right: 20px; float: left; width: 200px; font-family: 'Arial Rounded MT Bold';">
	<a href="index.php?m=titles&amp;p=1">
	<img style="vertical-align: middle" src="images/book.png" border="0"><span style="padding-left:10px">Titles</span></a>
	[{{$title_count}}]
</div>
{{section loop=$categories name=cat}}
<div style="padding-right: 20px; float: left; width: 200px; font-family: 'Arial Rounded MT Bold';">
	<a href="{{$categories[cat].href}}">
	<img style="vertical-align: middle" src="{{$categories[cat].icon}}" border="0"><span style="padding-left:10px">{{$categories[cat].name}}</span></a>
	[{{$categories[cat].count}}]
</div>
{{/section}}
</td></tr></table>
{{include file='footer.tpl' foo='bar'}}

