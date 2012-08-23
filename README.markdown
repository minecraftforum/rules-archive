This repository is a collection of the minecraftforum.net rules, both global and
sectional.

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

```
{
    "id":"0", // forum id, 
    "title":"Global Rules", // title of the section
    "last_updated":"2012-08-23 17:47" // last updated (BST)
}
```

For example Show Your Creation would be:

```
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

The global rules will be combined with the sectional rules to create a full rule
post including automatically generated navigation to each sections rules.