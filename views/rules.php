<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Minecraftforum.net Rules &mdash; mcf.li</title>
    <link rel="author" href="humans.txt" />
    <link rel="stylesheet" href="<?php echo APP_URL; ?>assets/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo APP_URL; ?>assets/css/style.css" type="text/css" />
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo APP_URL; ?>assets/js/generated_toc.js"></script>
    <script type="text/javascript" src="<?php echo APP_URL; ?>assets/js/op.js"></script>

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-29439846-16']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
    </script>
</head>
<body>
    <div class="container" id="content">
        <div class="row">
            <div class="span10 rules">
                <h1 id="rules">Minecraftforum.net rules</h1>
                <p>
                    The rules and guidelines outlined below must be followed at all times by members of minecraftforum.net. The rules are enforced to ensure that minecraftforum.net remains a safe and friendly enviromment for all members. Anyone of any age is welcome to use minecraftforum.net, although we strictly enforce our profanity rules we cannot guarantee that the forum will never contain <em>bad</em> content, as such parents should always monitor their young childrens usage of minecraftforum.net.
                </p>
                <p>
                    When the rules are updated a message will display at the top of the forum alerting all members to the new rules. New rules (since last acknowledgement) are displayed with a green background. A full history of all our rules can be viewed via our <a href="https://github.com/minecraftforum/rules">git repository on github</a>. Proposals of changes to the rules are always welcome and will be discussed.
                </p>
            </div>
            <div class="span10 rules">
                <div id="table-of-contents" class="rules" style="min-height:<?php echo $this->toc_height; ?>px"></div>
                <?php echo $this->rules; ?>
            </div>
            <div class="span10" id="footer">
                <a href="#rules">Return to top</a>
            </div>
        </div>
    </div>
</body>
</html>