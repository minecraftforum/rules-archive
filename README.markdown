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

### deployment

Deployment process does the following:

1. Combine all the individual rules into 1
2. Build the contents using the headings to decide where everything goes
3. Parse markdown into HTML