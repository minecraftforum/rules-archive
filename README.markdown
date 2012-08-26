This repository is a collection of the minecraftforum.net rules, both global and
sectional.

I chose to use Markdown because Markdown is easy to write, that's what it was
designed for. Although BBCode isn't /difficult/ to write it can be annoying,
it creates extra stuff in the way of the text when reading. It's much easier to 
read:

```
### Title here
This is some text [with a url](http://google.com) 
```

Than it is:

```
[size=6][font=arial, helvetica, sans-serif]Title here[/font][/size]
This is some text [url="http://google.com"]with a url[/url]
```

Full markdown documentation can be found
[here](http://daringfireball.net/projects/markdown/).

# Minecraftforum.net rules "system":

A single destination to find all rules that includes sectional rules. When the 
global rules are updated the message on the forum is updated to tell a user they 
need to read the updated rules. When a user reads the rules it will update their
"last read" value to the latest commit (time, or id?)

When posting a new post if the sectional rules have changed then the changes to 
the rules will be shown on the screen above the post box with the user 
required(?) to acknowledge the new rules.

## Format

Each section should have a folder which contains meta.json and rules.markdown. 

The folder should be titled as the section is, all lowercase with underscores
separating each word. For example show_your_creations, servers, game_modes. 

### meta.json

```json
{
    "id":"0", // forum id, 
    "title":"Global Rules", // title of the section
    "last_updated":"2012-08-23 17:47" // last updated (BST)
}
```

For example Show Your Creation would be:

```json
{
    "id":"58",
    "title":"Show Your Creation",
    "last_updated":"2012-08-23 17:47"
}
```

### rules.markdown

This is a markdown file that contains the actual rules. The deploy process will
convert from markdown to bbcode.

```markdown
# Section Title

## Sub title

### Sub Sub title
```

There should only be one "Sectional title" in the document.

### deployment

Deployment process does the following:

1. Combine all the individual rules into 1
2. Build the contents using the headings to decide where everything goes
3. Parse markdown into HTML

### display on forum

Rule View Field ID: field_16

All rule changes are manually outputted into the page like:

```html
<div id="rules">
    <div id="rule_{time}">Summary of rule changed</div>
</div>
```

Then they are collected into an array based on time; each one is compared
against the last rule viewed time, if it's greater than then it's hidden.

If a user hasn't ever viewed the rules before then a simple summary is displayed

The group flash embed:

```
<!--
    citricsquid's magical -- and terrible system for showing rule updates
    forgive me for my sins
-->
<style>
#citric_rules_box{
    padding:10px;
}
#citric_rules_box p{
    padding:5px 0;
}
#citric_rules_box h3{
    margin-bottom:5px;
}
#citric_updated_rules_list li{
    list-style-type:square;
    margin-left:15px;
}
#citric_updated_rules_list > li{
    display:none;
}
</style>
<div id="citric_rules_box" style="display:none;">
    <div id="citric_rules_new_user" style="display:none;">
        <h3>Welcome to minecraftforum.net {name}</h3>
        <p>
            Please make sure to read through our rules before posting. If you
            have any questions or concerns you can contact a member of the staff
            <a href="#">here</a>. This message will be hidden after you read the
            rules. When new rules are added or previous rules updated this 
            message will return.
        </p>
        <ul class="topic_buttons" style="margin-left:-10px; margin-top:20px;">
            <li style="float:left;"><a href="http://rules-mcf-li.dev/" title="View Full Rules">View Rules</a></li>
        </ul>
        <div style="clear:both;"></div>
    </div>
    <div id="citric_rules_updated" style="display:none;">
        <h3>Minecraftforum.net rules have been updated</h3>
        <p>Summaries of each change since you last reviewed our rules are as follows:</p>
        <ul id="citric_updated_rules_list">
            <li id="1345956772" style="display:none;">rule update summary 1 here</li>
            <li id="1345956779" style="display:none;">rule update summary 2 here</li>
            <li id="1345956781" style="display:none;">rule update summary 3 here</li>
        </ul>
        <p>
            Please spend a couple of minutes reviewing our updated rules. The most important change is that we no longer allow profanity in any capacity. A full explanation of this new rule and the way it is enforced are available in the updated rules.
        </p>
        <ul class="topic_buttons" style="margin-left:-10px; margin-top:10px;">
            <li style="float:left;"><a href="http://rules-mcf-li.dev/changes/{field_16}/{member_id}" title="View Full Rules">View Updated Rules</a></li>
        </ul>
        <div style="clear:both;"></div>
    </div>
</div>
<script type="text/javascript">
    var last_rule_view = parseInt("{field_16}");
    if(isNaN(last_rule_view)) {
        jQuery('#citric_rules_new_user').show();
        jQuery('#citric_rules_box').show();
    } else {
        jQuery('#citric_updated_rules_list').children().each(function(){
            if(jQuery(this).attr("id") > last_rule_view) {
                jQuery(this).show();
                jQuery('#citric_rules_updated').show();
                jQuery('#citric_rules_box').show();
            }
        });
    }
</script>
```