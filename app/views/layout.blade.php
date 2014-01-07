<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en" itemscope itemtype="http://schema.org/Product"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>Home | Implementing Laravel Blog</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

    <link rel="stylesheet" href="/css/gumby.css">

    <script src="/js/libs/modernizr-2.6.2.min.js"></script>
</head>

<body>

    <div class="navbar">
        <div class="row">
            <a class="toggle" gumby-trigger="#nav1 > .row > ul" href="#"><i class="icon-menu"></i></a>
            <h1 class="four columns logo">
                <a href="/">
                    <img src="/img/gumby_mainlogo.png" gumby-retina />
                </a>
            </h1>
            <ul class="eight columns">
                <li><a href="/">Home</a></li>
                <li><a href="/admin/article">Admin</a></li>
            </ul>
        </div>
    </div>

    <div class="row" id="content">
        {{ $content }}
    </div>

    <script>
    var oldieCheck = Boolean(document.getElementsByTagName('html')[0].className.match(/\soldie\s/g));
    if(!oldieCheck) {
    document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"><\/script>');
    } else {
    document.write('<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"><\/script>');
    }
    </script>
    <script>
    if(!window.jQuery) {
    if(!oldieCheck) {
      document.write('<script src="/js/libs/jquery-2.0.2.min.js"><\/script>');
    } else {
      document.write('<script src="/js/libs/jquery-1.10.1.min.js"><\/script>');
    }
    }
    </script>

    <script src="/js/libs/gumby.min.js"></script>
    <script src="/js/plugins.js"></script>
    <script src="/js/main.js"></script>

    <!-- Change UA-XXXXX-X to be your site's ID -->
    <!--<script>
    window._gaq = [['_setAccount','UAXXXXXXXX1'],['_trackPageview'],['_trackPageLoadTime']];
    Modernizr.load({
      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
    });
    </script>-->

    <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
    <!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->

<body>
</body>
</html>
