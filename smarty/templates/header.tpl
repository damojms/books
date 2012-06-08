{{*<!--
        Name:		 Calibre PHP webserver
        License:	 GPL v3
        Copyright:	 2010, Charles Haley <charles@haleys.org
-->*}}
<html lang="en">

<head>
<title>{{$title}}</title>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
</head>

<body>
<div style="border-width: thin; border-style: groove; background-color: #00FFFF; font-family: 'Arial Rounded MT Bold';">
<table width="100%">
    <tr>
    <td>
        <span style="font-size:large">{{$page_title}}<br></span><span style="font-size:medium">{{$title}}</span>

    </td>
    <td>&nbsp;</td>
    <td align="right">
        <form action="index.php" method="get" >
            <div>
                <input name="query" type="text">
                <input style="vertical-align:top" name="search" type="submit" value="Search">
                <input type="hidden" name="m" value="search">
            </div>
            <div style="font-size:80%">
                Current search: {{$last_search}}
                {{if $search_error}}<br>{{$search_error}}{{/if}}
            </div>
        </form>
    </td>
    </tr>
    <tr>
{{if $page}}
    <form action="index.php" method="get" >
        <td>
            {{if $page_back}}<a href="{{$page_back}}">prev</a>{{else}}prev{{/if}}
            &nbsp;&nbsp;&nbsp;Page <input name="p" type="text" size="1" value="{{$page}}">
            <input name="gotopage" type="submit" value="Go!"> of {{$maxpage}}&nbsp;&nbsp;&nbsp;
            {{foreach from=$prev_next item=item}}
                <input type="hidden" name="{{$item[0]}}" value="{{$item[1]}}">
            {{/foreach}}
            {{if $page_forw}}<a href="{{$page_forw}}">next</a>{{else}}next{{/if}}
          </td>
    </form>
    <form action="index.php" method="get" >
        <td>
            Sort on:
            <select name="sort_by" id="sortable">
            {{foreach from=$sortable_fields item=sortable}}
                <option value="{{$sortable}}" {{if $sortable == $current_sortable}}SELECTED{{/if}}>{{$sortable}}</option>
            {{/foreach}}
            </select>
            &nbsp;
            <select name="sort_direction">
                <option value="0" {{if $current_sort_direction == 0}}SELECTED{{/if}}>Ascending</option>
                <option value="1" {{if $current_sort_direction != 0}}SELECTED{{/if}}>Descending</option>
            </select>
            <input type="hidden" name="m" value="sort">
            <input name="sort" type="submit" value="Go!">
        </td>
    </form>
{{else}}
    <td>&nbsp;</td>
    <td>&nbsp;</td>
{{/if}}
    <td align="right" valign="top">
    <span style="font-size:small">
        {{if $use_back}}<a href="javascript: history.go(-1)">Back</a>{{/if}}
        <a href="index.php">Home</a>
        {{if $up_url}}<a href="{{$up_url}}">Up</a>{{else}}Up{{/if}}
    </span>
    </td>
    </tr>
</table>
</div>