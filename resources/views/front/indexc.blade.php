<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="Alex" content="Jasiri Sacco" />

    <!-- Stylesheets
    ============================================= -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Raleway:300,400,500,600,700|Crete+Round:400i" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/swiper.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/dark.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/magnific-popup.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ asset('theme/css/responsive.css') }}" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Document Title
    ============================================= -->
    <title>Jasiri Sacco</title>

</head>

<body class="stretched">

<!-- Document Wrapper
============================================= -->
<div id="wrapper" class="clearfix" data-loader-timeout="300">

    <!-- Header
    ============================================= -->
    <header id="header" class="transparent-header dark" data-sticky-class="not-dark">

        <div id="header-wrap">

            <div class="container clearfix">

                <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

                <!-- Logo
                ============================================= -->
                <div id="logo">
                    {{--<a href="{{ url('/') }}" class="standard-logo" data-dark-logo="{{ asset('theme/images/dark-logo1.png') }}"><img src="{{ asset('/public/theme/images/logo1.png') }}" alt="Qatalogue Logo"></a>--}}
                    {{--<a href="{{ url('/') }}" class="retina-logo" data-dark-logo="{{ asset('theme/images/dark-logo1.png') }}"><img src="{{ asset('/public/theme/images/logo1.png') }}" alt="Qatalogue Logo"></a>--}}
                </div><!-- #logo end -->

                <!-- Primary Navigation
                ============================================= -->
                <nav id="primary-menu" class="dark">

                    <ul>
                        <li class="current"><a href="{{ url('/') }}"><div>Home</div></a>
                        </li>
                        <li><a href="{{ url('register') }}"><div>Register</div></a></li>
                        <li><a href="{{ url('home') }}"><div>Login</div></a></li>
                    </ul>

                    <!-- Top Cart
                    ============================================= -->
                    {{--<div id="top-cart">--}}
                        {{--<a href="#" id="top-cart-trigger"><i class="icon-shopping-cart"></i><span>5</span></a>--}}
                        {{--<div class="top-cart-content">--}}
                            {{--<div class="top-cart-title">--}}
                                {{--<h4>Shopping Cart</h4>--}}
                            {{--</div>--}}
                            {{--<div class="top-cart-items">--}}
                                {{--<div class="top-cart-item clearfix">--}}
                                    {{--<div class="top-cart-item-image">--}}
                                        {{--<a href="#"><img src="images/shop/small/1.jpg" alt="Blue Round-Neck Tshirt" /></a>--}}
                                    {{--</div>--}}
                                    {{--<div class="top-cart-item-desc">--}}
                                        {{--<a href="#">Blue Round-Neck Tshirt</a>--}}
                                        {{--<span class="top-cart-item-price">$19.99</span>--}}
                                        {{--<span class="top-cart-item-quantity">x 2</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="top-cart-item clearfix">--}}
                                    {{--<div class="top-cart-item-image">--}}
                                        {{--<a href="#"><img src="images/shop/small/6.jpg" alt="Light Blue Denim Dress" /></a>--}}
                                    {{--</div>--}}
                                    {{--<div class="top-cart-item-desc">--}}
                                        {{--<a href="#">Light Blue Denim Dress</a>--}}
                                        {{--<span class="top-cart-item-price">$24.99</span>--}}
                                        {{--<span class="top-cart-item-quantity">x 3</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="top-cart-action clearfix">--}}
                                {{--<span class="fleft top-checkout-price">$114.95</span>--}}
                                {{--<button class="button button-3d button-small nomargin fright">View Cart</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div><!-- #top-cart end -->--}}

                    {{--<!-- Top Search--}}
                    {{--============================================= -->--}}
                    {{--<div id="top-search">--}}
                        {{--<a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>--}}
                        {{--<form action="search.html" method="get">--}}
                            {{--<input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">--}}
                        {{--</form>--}}
                    {{--</div><!-- #top-search end -->--}}

                </nav><!-- #primary-menu end -->

            </div>

        </div>

    </header><!-- #header end -->

    <section id="slider" class="slider-element slider-parallax swiper_wrapper full-screen clearfix">
        <div class="slider-parallax-inner">

            <div class="swiper-container swiper-parent">
                <div class="swiper-wrapper">
                    <div class="swiper-slide dark" style="background-image: url('theme/images/slider/swiper/7.jpg');">
                        <div class="container clearfix">
                            <div class="slider-caption slider-caption-center">
                                <h2 data-caption-animate="fadeInUp">Jasiri Sacco</h2>
                                {{--<p class="d-none d-sm-block" data-caption-animate="fadeInUp" data-caption-delay="200">From invoicing to expense tracking to accounting, Qatalogue ERP&trade; has all the tools you need to manage your money online.</p>--}}
                                <p class="d-none d-sm-block" data-caption-animate="fadeInUp" data-caption-delay="200">Our Commitement to provide customized financial solutions to individuals and corporates is our driving force,Raising bussiness from startups to world leading brands is our vision,we endevour to increase our members financial capacity by not only providing financial solutions but also bulding capacity in such fields as farming,business and individual enterprises</p>
                            </div>
                        </div>
                    </div>
                    {{--<div class="swiper-slide" style="background-image: url('pubc/theme/images/slider/swiper/3.jpg'); background-position: center top;">--}}
                        {{--<div class="container clearfix">--}}
                            {{--<div class="slider-caption">--}}
                                {{--<h2 data-caption-animate="fadeInUp">Great Performance</h2>--}}
                                {{--<p class="d-none d-sm-block" data-caption-animate="fadeInUp" data-caption-delay="200">You'll be surprised to see the Final Results of your Creation &amp; would crave for more.</p>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                </div>
                {{--<div class="slider-arrow-left"><i class="icon-angle-left"></i></div>--}}
                {{--<div class="slider-arrow-right"><i class="icon-angle-right"></i></div>--}}
            </div>

            <a href="#" data-scrollto="#content" data-offset="100" class="dark one-page-arrow"><i class="icon-angle-down infinite animated fadeInDown"></i></a>

        </div>
    </section>

    <!-- Content
    ============================================= -->
    {{--<section class="page-title-parallax page-title-dark" data-stellar-background-ratio="0.4" id="page-title">--}}
        {{--<div class="container clearfix">--}}
            {{--<h1 class="fadeInUp animated" data-animate="fadeInUp">Features</h1>--}}
            {{--<span class="fadeInUp animated" data-animate="fadeInUp" data-delay="300">Everything you need to know about Akaunting</span>--}}
        {{--</div>--}}
    {{--</section>--}}

    <section id="content">

        <div class="content-wrap">

            <div class="container clearfix">

                <div class="clear"> </div>

                <div class="col_two_third topmargin nobottommargin">

                    <div data-height-lg="535" data-height-md="442" data-height-sm="338" data-height-xs="316" data-height-xxs="201" style="position: relative;"><img alt="accounting mac" data-animate="fadeInLeft" src="{{ asset('/public/theme/images/pages/accounting-mac1.png') }}" style="position: absolute; top: 0; left: 0;" />
                        <img alt="accounting ipad" data-animate="fadeInRight" data-delay="300" src="{{ asset('/public/theme/images/pages/accounting-ipad1.png') }}" style="position: absolute; top: 0; left: 0;" />
                        <img alt="accounting iphone" data-animate="fadeInUp" data-delay="600" src="{{ asset('/public/theme/images/pages/accounting-iphone2.png') }}" style="position: absolute; top: 0; left: 0;" />
                    </div>

                </div>

                <div class="col_one_third topmargin nobottommargin col_last">
                    <h3>Service Sectors</h3>

                    {{--<div class="divider divider-short"><i class="icon-circle"></i></div>--}}

                    <ul class="iconlist iconlist-large iconlist-color">
                        <li><i class="icon-ok-sign"></i> Government Institutions</li>
                        <li><i class="icon-ok-sign"></i> Nonprofit Entities</li>
                        <li><i class="icon-ok-sign"></i> Profit companies across all spectrum</li>
                        <li><i class="icon-ok-sign"></i> Retail sector</li>
                        <li><i class="icon-ok-sign"></i> Manufacturing</li>
                        <li><i class="icon-ok-sign"></i> Financial accounting</li>

                    </ul>
                    <h3>Benefits</h3>
                    {{--<p>Qatalogue ERP provides a solutions that increase efficiency, promotes collaboration within--}}
                        {{--an organization and streamline processes to drive business success. Business processes--}}
                        {{--like sales, production, inventory and financial reporting are integrated in Qatalogue ERP--}}
                        {{--platform</p>--}}

                    {{--<p>Qatalogue ERP is an online accounting software designed for businesses to manage their finances and stay on top of their cash flow. Invoicing, accepting payments and keeping track of expenses couldn't be simpler.</p>--}}

                    {{--<p>Qatalogue ERP is built with modern technologies such as Laravel, Bootstrap, jQuery, Swift Mailer, API etc.</p>--}}

                    {{--<div class="divider divider-short"><i class="icon-circle"></i></div>--}}

                    <ul class="iconlist iconlist-large iconlist-color">
                        <li><i class="icon-ok-sign"></i> Enhances compliance with regulations</li>
                        <li><i class="icon-ok-sign"></i> Increased data security</li>
                        <li><i class="icon-ok-sign"></i> Cut operational costs</li>
                        <li><i class="icon-ok-sign"></i> Accurate financial reporting &amp; forcasts</li>
                        <li><i class="icon-ok-sign"></i> Increased efficiency</li>
                        <li><i class="icon-ok-sign"></i> Promote departmental collaboration</li>

                    </ul>


                </div>

                <div class="clear"> </div>

                <div class="divider divider-short divider-center"><i class="icon-circle"></i></div>

                <div class="heading-block title-center page-section" id="section-features">
                    <h2>Financial Services Overview</h2>
                    <span>Some of the services we provide</span>
                </div>

                <div class="container clearfix">

                    {{--<div class="col_one_third">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line-heart"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Free Accounting</h3>--}}
                            {{--<p>Completely Free. No setup fees. No hidden charges. Not a free limited version. Free means free.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}



                    {{--<div class="col_one_third col_last">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="400">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line-eye"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Open Source Accounting</h3>--}}
                            {{--<p>Take care about the privacy of your financials. Akaunting is Open Source so you can install on your host.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="clear"></div>

                    <div class="col_one_third">
                        <div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="600">
                            <div class="fbox-icon">
                                <i class="icon-line-head"></i>
                            </div>
                            <h3>Custormer Savings</h3>
                            <p>We provide an avenue where our clients can create a culture of montly savings thereby giving them an opportunity to increase their financial base.</p>
                        </div>
                    </div>

                    <div class="col_one_third">
                        <div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="800">
                            <div class="fbox-icon">
                                <i class="icon-line-paper"></i>
                            </div>
                            <h3>Loans Products</h3>
                            <p>Customized loan products which are specifically tailored to meet individuals requirements,with a higly competitive interest rate of 10% flat rate.</p>
                        </div>
                    </div>

                    <div class="col_one_third col_last">
                        <div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="1000">
                            <div class="fbox-icon">
                                <i class="icon-exchange"></i>
                            </div>
                            <h3>Self Service Customer Portal</h3>
                            <p>Information is power,we understand the need to know your financial position at any given time.we provide a self service online portal that allows our clients to manage their details and also apply loans online.</p>
                        </div>
                    </div>

                    {{--<div class="clear"></div>--}}

                    {{--<div class="col_one_third">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="1200">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-shop"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Vendor Management</h3>--}}
                            {{--<p>Create vendors so you could assign bills and payments to them and later filter their transactions easily.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col_one_third">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="1400">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-cart"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Billable Expenses</h3>--}}
                            {{--<p>Create and manage bills so your finances are always accurate and healthy. Know what and when to pay.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col_one_third col_last">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="1600">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line2-credit-card"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Various Payments</h3>--}}
                            {{--<p>Add non-billable expenses as payments in order to keep your bank/cash account balances up-to-date.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="clear"></div>--}}

                    {{--<div class="col_one_third">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="1800">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line-box"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Inventory Management</h3>--}}
                            {{--<p>Enable inventory tracking and manage goods as they come in and go out. Items also speed up invoicing.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col_one_third">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="2000">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line-book"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Bank Accounts</h3>--}}
                            {{--<p>Create unlimited bank and cash accounts and track their opening and current balances.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col_one_third col_last">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="2200">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-dollar"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Multi-Currency</h3>--}}
                            {{--<p>Send invoices and add expenses in any currency and let the system convert them in your main currency.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="clear"></div>--}}

                    {{--<div class="col_one_third">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="2400">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-building"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Multi-Company</h3>--}}
                            {{--<p>Manage the finances of multiple companies from one admin panel. Assign users to different companies.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col_one_third">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="2600">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-chart"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Powerful Reporting</h3>--}}
                            {{--<p>Get detailed financial reports to help you better visualize all the information you need to improve your business.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col_one_third col_last">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="2800">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line2-users"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Client Portal</h3>--}}
                            {{--<p>Share the transactions and invoices with your clients and accept bulk payments, online.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="clear"></div>--}}

                    {{--<div class="col_one_third">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="3000">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line2-refresh"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Recur Everything</h3>--}}
                            {{--<p>Automatically create invoices, revenues, bills, and payments for ongoing jobs.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col_one_third">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="3200">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line2-tag"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Discount</h3>--}}
                            {{--<p>Encourage client loyalty with your work by giving them a discount from the usual cost.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col_one_third col_last">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="3400">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line2-user"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Customer Summary</h3>--}}
                            {{--<p>See the customer profile, address, list of transactions, and paid, open, and overdue totals at a glance.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="clear"></div>--}}

                    {{--<div class="col_one_third">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="3600">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line-paper-clip"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Unlimited Attachments</h3>--}}
                            {{--<p>Attach your business files and/or receipts to invoices, expenses, payments for original evidence.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col_one_third">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="3800">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line-folder"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Transaction Categories</h3>--}}
                            {{--<p>Create categories for incomes, expenses and items and see the flow of your business at a glance.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col_one_third col_last">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="4000">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line-plus"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Tax Rates</h3>--}}
                            {{--<p>Set up different names for each tax, and link specific taxes to specific products or transactions to save you time.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="clear"></div>--}}

                    {{--<div class="col_one_third bottommargin-sm">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="4200">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line2-rocket"></i>--}}
                            {{--</div>--}}
                            {{--<h3>App Store</h3>--}}
                            {{--<p>Extend Akaunting without leaving the admin panel, you can install or purchase anything.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col_one_third bottommargin-sm">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="4400">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-line-flag"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Multilingual Panel</h3>--}}
                            {{--<p>Manage your finances in your language. Switch between languages easily, instantly.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col_one_third bottommargin-sm col_last">--}}
                        {{--<div class="feature-box fbox-small fbox-plain" data-animate="fadeIn" data-delay="4600">--}}
                            {{--<div class="fbox-icon">--}}
                                {{--<i class="icon-key"></i>--}}
                            {{--</div>--}}
                            {{--<h3>Fine-Grained Permissions</h3>--}}
                            {{--<p>Configure permissions on a Role level to protect and simplify their management experience.</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="clear"></div>--}}

                {{--</div>--}}

                {{--<div class="clear"> </div>--}}

            {{--</div>--}}

        </div>

    </section>


    <!-- Footer
    ============================================= -->
    <footer id="footer" class="dark">

        <div class="container">

            <!-- Footer Widgets
            ============================================= -->
            <div class="footer-widgets-wrap clearfix">

                <div class="col_two_third">

                    <div class="col_one_third">

                        <div class="widget clearfix">
                            <img src="{{ asset('theme/images/dark-logo1.png') }}" alt="Qatalogue logo grey"style="margin-bottom: 0;margin-top: 0" class="footer-logo">
                            <div>
                                Online accounting software built with modern technologies. Track your income and expenses with ease.
                            </div>
                        </div>

                    </div>

                    <div class="col_one_third" style="width:32%;margin-top: 20px">

                        <div class="widget widget_links clearfix" >
                            <h4>Links</h4>

                            <ul>
                               <li>Online Accounting</li>
                            </ul>

                        </div>

                    </div>

                    <div class="col_one_third col_last" style="width:28%;margin-top: 20px;">

                        <div class="widget widget_links clearfix">
                            <h4>Contacts</h4>
                            <ul class="">
                                <li><span><i class="icon-mail"></i>  </span>  info@qatalogue.co.ke </li>
                                <li><span><i class="icon-mail"></i>  </span>  mwaura@qatalogue.co.ke </li>
                                <li><span><i class="icon-mobile"></i>  </span>  0722 401489 / 0725 263 425 </li>
                            </ul>
                        </div>

                    </div>

                </div>

                <div class="col_one_third col_last" style="margin-top: 20px;">
                    <div class="widget subscribe-widget clearfix" >
                        <h4>Location</h4>
                        <ul>
                            <li>Westlands Arcade</li>
                            <li>2<sup>nd</sup> Floor Rm 1</li>
                        </ul>


                    </div>

                </div>

            </div><!-- .footer-widgets-wrap end -->

        </div>

        <!-- Copyrights
        ============================================= -->
        <div id="copyrights">

            <div class="container clearfix">

                <div class="col_half">
                    Copyright © {{ \Carbon\Carbon::now()->year }} Qatalogue Limited.   |   <a href="{{ url('/') }}" target="_self" style="color:#626464;">Qatalogue</a>
                </div>

                {{--<div class="col_half col_last tright">--}}
                    {{--<div class="fright clearfix">--}}
                        {{--<a href="https://github.com/akaunting" title="GitHub" target="_blank" class="social-icon si-small si-borderless si-github">--}}
                            {{--<i class="icon-github-circled"></i>--}}
                            {{--<i class="icon-github-circled"></i>--}}
                        {{--</a>--}}

                        {{--<a href="https://facebook.com/akaunting" title="Facebook" target="_blank" class="social-icon si-small si-borderless si-facebook">--}}
                            {{--<i class="icon-facebook"></i>--}}
                            {{--<i class="icon-facebook"></i>--}}
                        {{--</a>--}}

                        {{--<a href="https://twitter.com/akaunting" title="Twitter" target="_blank" class="social-icon si-small si-borderless si-twitter">--}}
                            {{--<i class="icon-twitter"></i>--}}
                            {{--<i class="icon-twitter"></i>--}}
                        {{--</a>--}}

                        {{--<a href="https://instagram.com/akaunting" title="Instagram" target="_blank" class="social-icon si-small si-borderless si-instagram">--}}
                            {{--<i class="icon-instagram"></i>--}}
                            {{--<i class="icon-instagram"></i>--}}
                        {{--</a>--}}

                        {{--<a href="https://youtube.com/channel/UCqshRM00ibu73Lxvv43Lh8w" title="YouTube" target="_blank" class="social-icon si-small si-borderless si-youtube">--}}
                            {{--<i class="icon-youtube"></i>--}}
                            {{--<i class="icon-youtube"></i>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                {{--</div>--}}

            </div>

        </div><!-- #copyrights end -->

    </footer>

</div><!-- #wrapper end -->

<!-- Go To Top
============================================= -->
<div id="gotoTop" class="icon-angle-up"></div>

<!-- External JavaScripts
============================================= -->
<script src="{{ asset('theme/js/jquery.js')}}"></script>
<script src="{{ asset('theme/js/plugins.js')}}"></script>

<!-- Footer Scripts
============================================= -->
<script src="{{ asset('theme/js/functions.js')}}"></script>

</body>
</html>