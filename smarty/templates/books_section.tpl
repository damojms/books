{{*<!--
        Name:		 Calibre PHP webserver
        License:	 GPL v3
        Copyright:	 2010, Charles Haley <charles@haleys.org
-->*}}
<table style="font-family: 'Arial Rounded MT Bold';">
{{section name=book loop=$books}}
    <tr>
        <td width="150px" valign="top">
            <img src="{{$books[book].cover}}"><br>
        </td>
        <td valign="top" width="20%" style="font-size: '110%';">
            <div style="font-size: '110%';">{{$books[book].title}}</div>
            <div style="font-size: '80%';">{{$books[book].field_authors}}</div>
            {{if $books[book].rating_url}}<img style="vertical-align: middle" src="{{$books[book].rating_url}}"><br>{{/if}}
            <div style="font-size: '80%';">
            {{section name=format loop=$books[book].formats}}
                <a href="{{$books[book].formats[format].URL}}">{{$books[book].formats[format].format}}</a> {{$books[book].formats[format].size}}<br>
            {{/section}}
            </div>
        </td>
        <td valign="top" width="30%" style="font-size: 80%;">
            {{section name=field loop=$books[book].field_names}}
	             {{$books[book].field_names[field]}}: {{$books[book].field_values[field]}}<br>
            {{/section}}
            {{if $books[book].details_url}}
                <div style="font-size: '80%';">
                    <a href={{$books[book].details_url}}>Book details</a><br>
                </div>
            {{/if}}
        </td>
        <td valign="top" width="40%" style="font-size: 70%;">
            {{if $books[book].comments != ''}}{{$books[book].comments}}<br>{{/if}}
            {{section name=cust loop=$books[book].custom_comments_names}}
                {{$books[book].custom_comments_names[cust]}}:{{$books[book].custom_comments_values[cust]}}
            {{/section}}
        </td>
    <tr>
        <td colspan="4"><hr></td>
    </tr>
    </tr>
{{/section}}
</table>
