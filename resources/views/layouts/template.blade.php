<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>Lynne Kirsch - Web Developer and Designer</title>
    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Share+Tech+Mono" rel="stylesheet">
    <link href="css/styles.css" type="text/css" rel="stylesheet" media="screen,projection,print"/>
</head>
<body>

<div id="header">
    <div class="navbar-fixed">
        <nav class="cyan darken-1" role="navigation">
            <div class="nav-wrapper container ">
                <a id="logo-container" href="/" class="brand-logo white-text">LYNNE KIRSCH</a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="/introduction">Introduction</a></li>
                    <li><a href="/code">Code</a></li>
                    <li><a href="/design">Design</a></li>
                    <li><a href="/resume">Resume</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>

                <ul id="nav-mobile" class="side-nav">
                    <li><a href="/introduction">Introduction</a></li>
                    <li><a href="/code">Code</a></li>
                    <li><a href="/design">Design</a></li>
                    <li><a href="/resume">Resume</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
                <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
            </div>
        </nav>
    </div>
</div>

<main class="valign-wrapper">
    @yield('content')
</main>

<footer class="page-footer grey darken-4">
    <div class="container">
        <div class="row web_footer">
            <div class="col l6 s6">Lynne Kirsch &copy; 2017</div>
            <div class="col l6 s6 right-align">lynne.kirsch@gmail.com &bull; 607.342.5016</div>
        </div>
        <div class="row resume_footer">
            <div class="col l6 s6">lynne.kirsch@gmail.com</div>
            <div class="col l6 s6 right-align">607.342.5016</div>
        </div>
    </div>
</footer>


<!--  Scripts-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/bin/materialize.js"></script>
<script src="js/init.js"></script>
</body>
</html>
<!--
---- Hey there! I see you're checking out my code. I built this website using Laravel
---- and the materialize css frontend framework. It's similar to bootstrap but with
---- a touch of Google.
----
---- If you want to see more of the meat and bones, of which there isn't much, you can
---- see it where it lives: https://github.com/LynneKirsch/lynnekirschsite
--!>
