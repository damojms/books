{{*<!--
        Name:		 Calibre PHP webserver
        License:	 GPL v3
        Copyright:	 2010, Charles Haley <charles@haleys.org
-->*}}
<div style="float:none; border-width: thin; border-style: groove; background-color: #00FFFF; font-size: 75%; font-family: 'Arial Rounded MT Bold';">
    <div style="float:right;">Current library: {{$current_library}}</div>
    <div style="float:left;">Current date: {{$current_date}}</div>
    <br>
    <div style="float:right;">Current version: {{$current_version}}</div>
    {{if $logged_in_as}}<div style="float:left;">logged in as: {{$logged_in_as}}</div>{{/if}}
    <br>
</div>
</body>
</html>