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
[here](http://daringfireball.net/projects/markdown/). There is also a utility
for testing markdown available here: 
<http://michelf.ca/projects/php-markdown/dingus/>

A brief summary of the relevant markdown:

#### Links
```
[title](http://link.com)
```

#### Auto link a URL
```
<http://link.com>
```

#### Headings
```
# Heading
```

#### Lists
```
* list item #1
* list item #2
    * sub-list item #1
        * sub-sub list item #1
* list item #3
```

# Minecraftforum.net rules "system":

A single destination to find all rules that includes sectional rules. When the 
global rules are updated the message on the forum is updated to tell a user they 
need to read the updated rules. When a user reads the rules it will update their
"last read" value to the latest commit (time, or id?)

When posting a new post if the sectional rules have changed then the changes to 
the rules will be shown on the screen above the post box with the user 
required(?) to acknowledge the new rules.

### rules.markdown

This is a markdown file that contains the actual rules. The deploy process will
convert from markdown to bbcode.

```markdown
# Section Title

## Sub title

### Sub Sub title
```

There should only be one "Sectional title" in the document.

**PLEASE NOTE:** each heading MUST be totally unique. If a heading already
exists and you make another it will not be usable for the jump to and linking. 
For example if someone has already done 

```
### Posting Restrictions
```

and you do

```
## Posting Restrictions
```

it won't work! don't do that! If you have to add an extra word or something, 
do that!

### Style / format guide

* Topics are topics (not threads)
* Address users as members, NO: "Users should always...", YES: "Members should always..."
* Do not use colons in headings, NO: "Restrictions:", YES: "Restrictions"
* List items should not end with a full stop (unless it's the paragraph
    description of the item)
* Do not address the user, NO: "You cannot bump threads", YES: "Bumping threads
    is not allowed"
* Refer to minecraftforum.net as "we". NO: "minecraftforun.net staff will..." 
    YES: "We will..."
* Try to use links as rarely as possible. Rules should be easy to read without
    any need to navigate away. Links are okay as long as they are necessary
    and provide value that cannot (reasonably) provided within the rules.
* Use 2 hyphens for a dash, NO: -, YES: --
* Positive framing, if a an issue can be presented in a positive way, do that. 
    YES: "Do post in a polite manner", NO: "Don't be a dick!"
* (as above) Explain why an issue is *good* for the user, NO: "Search because
    if you don't people will shout at you", YES: "Search, it will get you an 
    answer faster!"
* Plain English, rules should be understandable by anyone of any age (with a 
    passable level of English). If a word can be open to interpretation don't 
    use it!
* List items with a description should have the description as a paragraph and
    the title in bold (using 2 underscores):

NO: 

```markdown
* Be Nice -- Every member deserves to be treated with respect
* Search -- Search before posting...
```

YES:

```markdown
* __Be Nice__

    Every member deserves to be treated with respect

* __Search__

    Search before posting...
```

* Frequently new line, having long sentences that extend way beyond any 
    reasonable text editors screen size is unreasonable. The Markdown parser
    will treat double enters as a new line; a single return will not trigger
    a new line.

```
* This will all
    show on one line
    instead of across multiple lines
```

Produces:

* This will all show on one line instead of across multiple lines

```
This will

show across

multiple lines
```

Produces:

This will

show across

multiple lines

## Format

Each section should have a folder which contains meta.json and rules.markdown. 

The folder should be titled as the section is, all lowercase with underscores
separating each word. For example show_your_creations, servers, game_modes. 

### meta.json

```json
{
    "id":"0", // forum id, 
    "position":"0", // position of the rules in the list
    "title":"Global Rules", // title of the section
    "last_updated":"2012-08-23 17:47", // last updated (BST)
    "hidden":"0" // 1 or 0. If 1 rules won't be compiled
}
```

For example Show Your Creation would be:

```json
{
    "id":"58",
    "position":"1",
    "title":"Show Your Creation",
    "last_updated":"2012-08-23 17:47",
    "hidden":"0"
}
```