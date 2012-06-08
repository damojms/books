{{*<!--
        Name:		 Calibre PHP webserver
        License:	 GPL v3
        Copyright:	 2010, Charles Haley <charles@haleys.org
-->*}}
{{include file="header.tpl" title="Home"}}

<form action="index.php" method="post">
<table align="center">
<tr>
<td style="text-align:center;" colspan="2">
    {{$message}}<br>Please Login
</td>
</tr>
<tr>
<td>
    User name:</td>
<td>
    <input name="name" type="text"></td>
</tr>
<tr>
<td>
    Password:
</td>
<td>
    <input name="password" type="password"></td>
</tr>
<tr>
<td style="text-align:center;" colspan="2">
    <input name="Login" type="submit" value="login">
</td>
</tr>
</table>
    </form>
{{include file='footer.tpl' foo='bar'}}

