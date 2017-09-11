@extends('layouts.template')

@section('content')
    <main id="main-page-content" class="valign-wrapper">
        <div class="row no-margin " id="content-inner">
            <div class="col s12">
                <div class="container grey-text text-darken-2 body resume">
                    <div class="inner ">
                        <div class="row">
                            <div class="col s12">
                                <h5 class="teal-text">Self-Summary</h5>
                                I have put a great deal of effort into learning skills relevant to both web programming and design, keeping myself up to date with
                                latest trends and best practices as well as new and emerging technologies. It is my passion for learning, pushing myself and
                                broadening my skillset that has sparked me to seek new opportunities in the design and programming field.

                                I am currently looking to relocate my talents to the Southern California area.
                            </div>
                        </div>
                        <div class="row stack_for_web">
                            <div class="col s12 ">
                                <h5 class="teal-text">My Stack</h5>
                                <div class="chip">PHP 7</div>
                                <div class="chip">MySQL</div>
                                <div class="chip">HTML 5</div>
                                <div class="chip">CSS 3</div>
                                <div class="chip">Sass</div>
                                <div class="chip">Adobe Photoshop</div>
                                <div class="chip">Bootstrap</div>
                                <div class="chip">SEO</div>
                                <div class="chip">GIT</div>
                                <div class="chip">Atlassian</div>
                                <div class="chip">Apache</div>
                                <div class="chip">Docker</div>
                                <div class="chip">Javascript</div>
                                <div class="chip">Jquery</div>
                                <div class="chip">Ajax</div>
                                <div class="chip">Twig</div>
                                <div class="chip">Mustache</div>
                                <div class="chip">Blade</div>
                                <div class="chip">Responsive Design</div>
                                <div class="chip">Laravel</div>
                                <div class="chip">CodeIgniter</div>
                                <div class="chip">Doctrine</div>
                                <div class="chip">Symfony</div>
                            </div>
                        </div>

                        <div class="stack_for_print">
                            <h5 class="teal-text">My Stack</h5>
                            PHP 7 &bull;
                            MySQL &bull;
                            HTML 5 &bull;
                            CSS 3 &bull;
                            Sass &bull;
                            Adobe Photoshop &bull;
                            Bootstrap &bull;
                            SEO &bull;
                            GIT &bull;
                            Atlassian &bull;
                            Apache &bull;
                            Docker &bull;
                            Javascript &bull;
                            Jquery &bull;
                            Ajax &bull;
                            Twig &bull;
                            Mustache &bull;
                            Blade &bull;
                            Responsive Design &bull;
                            Laravel &bull;
                            CodeIgniter &bull;
                            Doctrine &bull;
                            Symfony
                            <br>
                            <br>
                        </div>

                        <div class="row">
                            <div class="col s12">
                                <h5 class="teal-text">Experience</h5>
                                <div class="row">
                                    <div class="col l12">
                                        <strong>
                                            PHP Programmer: TeamWorld, Inc
                                            <br>
                                            May 2016 - Current
                                        </strong>
                                        <br>
                                        Assisted in the development of internal business applications and provided ongoing support and improvements
                                        to existing platforms. Designed, built and launched a company-wide merchandise return application and production
                                        scheduler. Assisted in multiple interface and backend overhauls of a proprietary eCommerce system. Debugged many
                                        problem legacy applications and assisted with multiple large pack-outs by automating the box filling process.
                                        <br><br>
                                        Recently redesigned the Shake Shack retail website, as well as assisted in much of the backend development.
                                        <br><br>
                                        <strong>
                                            Web Designer: TeamWorld, Inc
                                            <br>
                                            May 2015 - May 2016
                                        </strong>
                                        <br>
                                        Designed a base template for a proprietary eCommerce application that future stores would be built upon.
                                        Re-themed and branded this template for individual clients based on their brand guidelines or taste. Designed,
                                        built and shipped multiple email promotions. Assisted with small scale programming projects wherever there was
                                        time for it.
                                        <br><br>
                                        <strong>
                                            Web Project Manager: Sweet Home Productions
                                            <br>
                                            April 2014 - May 2015
                                        </strong>
                                        <br>
                                        Coordinated and organized existing websites and delegated tasks for ongoing projects. Fielded customer requests
                                        and concerns, and acted as the face of the company. Presented marketing strategies to increase company growth.
                                        Assisted in the creation of a custom transportation tracking application for the Oneonta, NY area.
                                        <br><br>
                                        <strong>
                                            Website Designer: Sweet Home Productions
                                            <br>
                                            April 2013 - April 2014
                                        </strong>
                                        <br>
                                        Worked directly with the client to design websites based on specific needs and tastes. Converted photoshop wireframes
                                        to live websites, implemented custom WordPress plugins, optimized SEO, completed various data-entry tasks and helped
                                        coordinate and design marketing materials for the Catskill Film Festival.
                                        <br><br>
                                        <strong>
                                            Freelance Web Design / Development
                                            <br>
                                            2010 - 2013
                                        </strong>
                                        <br>
                                        Broadened my skillset by working with numerous clients, each with varying needs. During this time, I built many eCommerce
                                        websites, custom forum applications, a gaming social network, and more. I strengthened my skills with PHP and MySQL and
                                        became familiar with the DOs and DON’Ts of good UX design. I took time to teach myself structural programming by utilizing
                                        Udemy and W3Schools, and attained a handful of certificates.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row center resume-print hide-on-small-and-down">
                            <div class="col l12">
                                <h3>I'm printer friendly!</h3>
                                <button class="btn z-depth-0" onclick="window.print();">Print Me</button> or
                                <a class="btn z-depth-0" href="https://docs.google.com/document/d/1s-2qoQPhTEpk_eZqWFYaWgbJmUas92qQ5UgEgaP-8vc/edit?usp=sharing" target="_blank">View In Drive</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection