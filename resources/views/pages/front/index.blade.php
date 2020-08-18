@extends('layouts.app')

@section('content')
    <!-- Start Header -->
    <section id="slide" class="slide background-withcolor">
        <div class="content-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6" data-aos="fade-right">
                        <p class="mb-0">With us you will</p>
                        <h2>succeed</h2>
                        <p>Proactively syndicate open-source e-markets after low-risk high-yield synergy. Professionally
                            simplify visionary technology.
                        </p>
                        <a href="#" class="btn btn-primary btn-white shadow btn-theme"><span>Read More</span></a>
                    </div>
                    <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                        <img src="{{asset('fox/img/mobile-1.png')}}" class="img-fluid d-block mx-auto" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Header -->

    <!-- Start Boxes -->
    <section id="boxes" class="boxes padding-100">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12">
                    <div class="box" data-aos="fade-up">
                        <div class="icon">
                            <span class="lnr lnr lnr-magic-wand"></span>
                        </div>
                        <div class="space-20"></div>
                        <h4>Creative Design</h4>
                        <div class="space-15"></div>
                        <p>Proactively syndicate open-source e-markets after low-risk high-yield synergy.</p>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="box" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon">
                            <span class="lnr lnr-rocket"></span>
                        </div>
                        <div class="space-20"></div>
                        <h4>Free support</h4>
                        <div class="space-15"></div>
                        <p>Proactively syndicate open-source e-markets after low-risk high-yield synergy.</p>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="box" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon">
                            <span class="lnr lnr-diamond"></span>
                        </div>
                        <div class="space-20"></div>
                        <h4>Exclusive Design</h4>
                        <div class="space-15"></div>
                        <p>Proactively syndicate open-source e-markets after low-risk high-yield synergy.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Boxes -->

    <!-- Start Why Us -->
    <section id="about" class="why-us padding-100 background-fullwidth background-fixed "
        style="background-image: url({{asset('fox/img/gray-bg.jpg')}});">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center" data-aos="fade-right">
                    <img src="{{asset('fox/img/mobile-2.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-md-6" data-aos="fade-zoom-in" data-aos-delay="200">
                    <h3>Make Business Easy With Us</h3>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem
                    </p>
                    <div class="space-50"></div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12" data-aos="zoom-in" data-aos-delay="400">
                            <div class="why-us-icon">
                                <span class="lnr lnr-rocket"></span>
                                <p>Intrinsically aggregate cutting-edge internal or "organic" sources through pandemic.
                                </p>
                            </div>
                            <div class="space-25"></div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12" data-aos="zoom-in" data-aos-delay="600">
                            <div class="why-us-icon">
                                <span class="lnr lnr-rocket"></span>
                                <p>It doesn't matter if you are in an office or on an airplane. You will never lose a
                                    second.
                                </p>
                            </div>
                        </div>
                        <div class="space-25"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12" data-aos="zoom-in" data-aos-delay="800">
                            <div class="why-us-icon">
                                <span class="lnr lnr-rocket"></span>
                                <p>It doesn't matter if you are in an office or on an airplane. You will never lose a
                                    second.
                                </p>
                            </div>
                            <div class="space-25"></div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12" data-aos="zoom-in" data-aos-delay="1000">
                            <div class="why-us-icon">
                                <span class="lnr lnr-rocket"></span>
                                <p>Intrinsically aggregate cutting-edge internal or "organic" sources through pandemic.
                                </p>
                            </div>
                            <div class="space-25"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Why Us -->

    <!-- Start Main Features -->
    <section id="main_features" class="main-features padding-100">
        <div class="container">
            <div class="row">
                <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                    <h3>Main
                        <span>Features</span>
                    </h3>
                    <div class="space-25"></div>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem ipsum amet madolor sit amet.</p>
                    <div class="space-25"></div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-3 text-lg-right left-side">
                    <div class="one-feature one" data-aos="fade-right" data-aos-delay="1000">
                        <h5>Lorem ipsum</h5>
                        <span class="lnr lnr-rocket"></span>
                        <p>Our system is a comprehensive system of applied creativity.</p>
                    </div>
                    <div class="one-feature" data-aos="fade-right" data-aos-delay="1400">
                        <h5>Lorem ipsum</h5>
                        <span class="lnr lnr-cog"></span>
                        <p>For more than 5 years, we’ve been passionate about achieving better.</p>
                    </div>
                    <div class="one-feature" data-aos="fade-right" data-aos-delay="1800">
                        <h5>Lorem ipsum</h5>
                        <span class="lnr lnr-cloud"></span>
                        <p>Our system is a comprehensive system of applied creativity.</p>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="features-circle">
                        <div class="circle-svg" data-aos="zoom-in" data-aos-delay="400">
                            <svg version="1.1" id="features_circle" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="543px"
                                height="542.953px" viewBox="0 0 543 542.953" enable-background="new 0 0 543 542.953"
                                xml:space="preserve">
                                <g>
                                    <circle fill="none" stroke="#" stroke-width="3" stroke-miterlimit="10"
                                        stroke-dasharray="11.9474,11.9474" cx="271.5" cy="271.516" r="270" />
                                    <animateTransform attributeName="transform" type="rotate" from="0" to="360"
                                        dur="50s" repeatCount="indefinite"></animateTransform>
                                </g>
                            </svg>
                        </div>
                        <img data-aos="fade-up" data-aos-delay="200" src="{{asset('fox/img/mobile-3.png')}}" class="img-fluid"
                            alt="">
                    </div>
                </div>
                <div class="col-lg-3 right-side">
                    <div class="one-feature" data-aos="fade-left" data-aos-delay="1000">
                        <h5>Lorem ipsum</h5>
                        <span class="lnr lnr-construction"></span>
                        <p>Our system is a comprehensive system of applied creativity.</p>
                    </div>
                    <div class="one-feature" data-aos="fade-left" data-aos-delay="1400">
                        <h5>Lorem ipsum</h5>
                        <span class="lnr lnr-gift"></span>
                        <p>For more than 5 years, we’ve been passionate about achieving better.</p>
                    </div>
                    <div class="one-feature" data-aos="fade-left" data-aos-delay="1800">
                        <h5>Lorem ipsum</h5>
                        <span class="lnr lnr-database"></span>
                        <p>For more than 5 years, we’ve been passionate about achieving better.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Main Features -->

    <!-- Start Other Features -->
    <section id="other_features" class="other-features padding-100 background-withcolor">
        <div class="container-fluid">
            <div class="row">
                <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                    <h3>Other
                        <span class="white"> Awesome </span> Features
                    </h3>
                    <div class="space-25"></div>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem ipsum amet madolor sit amet.</p>
                    <div class="space-50"></div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="other-features-slider" data-aos="fade-up">

                        <div class="item text-center">
                            <span class="lnr lnr-rocket"></span>
                            <h4>Creative Design</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et atque eos amet vel
                                voluptatibus
                                incidunt.
                            </p>
                        </div>
                        <div class="item text-center">
                            <span class="lnr lnr-cog"></span>
                            <h4>Easy Login</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et atque eos amet vel
                                voluptatibus
                                incidunt.
                            </p>
                        </div>
                        <div class="item text-center">
                            <span class="lnr lnr-cloud"></span>
                            <h4>Fast Install</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et atque eos amet vel
                                voluptatibus
                                incidunt.
                            </p>
                        </div>
                        <div class="item text-center">
                            <span class="lnr lnr-construction"></span>
                            <h4>Data Protect</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et atque eos amet vel
                                voluptatibus
                                incidunt.
                            </p>
                        </div>
                        <div class="item text-center">
                            <span class="lnr lnr-gift"></span>
                            <h4>High Resolution</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et atque eos amet vel
                                voluptatibus
                                incidunt.
                            </p>
                        </div>
                        <div class="item text-center">
                            <span class="lnr lnr-database"></span>
                            <h4>Clean Code</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et atque eos amet vel
                                voluptatibus
                                incidunt.
                            </p>
                        </div>
                        <div class="item text-center">
                            <span class="lnr lnr-gift"></span>
                            <h4>Quick Support</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et atque eos amet vel
                                voluptatibus
                                incidunt.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Other Features  -->

    <!-- Start Watch Video -->
    <section id="watch_video" class="watch-video padding-100">
        <div class="container-fluid">
            <div class="row">
                <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                    <h3>Watch
                        <span> Video</span>
                    </h3>
                    <div class="space-25"></div>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem ipsum amet madolor sit amet.</p>
                    <div class="space-50"></div>
                </div>
                <div class="col-md-6 offset-md-3" data-aos="fade-up">
                    <div class="video" style="background-image: url('https://via.placeholder.com/699x351')">
                        <img src="{{asset('fox/img/mobile-4-4.png')}}" class="img-fluid d-block mx-auto" alt="">
                        <a href="http://www.youtube.com/watch?v=XSGBVzeBUbk" data-lity></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Watch Video  -->

    <!-- Start Screenshots -->
    <section id="screenshots" class="screenshots padding-100 background-fullwidth background-fixed"
        style="background-image: url({{asset('fox/img/gray-bg.jpg)')}};">
        <div class="container-fluid">
            <div class="row">
                <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                    <h3>Awesome
                        <span> Screenshots</span>
                    </h3>
                    <div class="space-25"></div>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem ipsum amet madolor sit amet.</p>
                    <div class="space-50"></div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="screenshots-slider" data-aos="fade-up">


                        <div class="item text-center">
                            <img src="{{asset('fox/img/mobile-5.png')}}" class="img-fluid d-block mx-auto" alt="">
                        </div>
                        <div class="item text-center">
                            <img src="{{asset('fox/img/mobile-5.png')}}" class="img-fluid d-block mx-auto" alt="">
                        </div>
                        <div class="item text-center">
                            <img src="{{asset('fox/img/mobile-5.png')}}" class="img-fluid d-block mx-auto" alt="">
                        </div>
                        <div class="item text-center">
                            <img src="{{asset('fox/img/mobile-5.png')}}" class="img-fluid d-block mx-auto" alt="">
                        </div>
                        <div class="item text-center">
                            <img src="{{asset('fox/img/mobile-5.png')}}" class="img-fluid d-block mx-auto" alt="">
                        </div>
                        <div class="item text-center">
                            <img src="{{asset('fox/img/mobile-5.png')}}" class="img-fluid d-block mx-auto" alt="">
                        </div>
                        <div class="item text-center">
                            <img src="{{asset('fox/img/mobile-5.png')}}" class="img-fluid d-block mx-auto" alt="">
                        </div>
                        <div class="item text-center">
                            <img src="{{asset('fox/img/mobile-5.png')}}" class="img-fluid d-block mx-auto" alt="">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Screenshots -->

    <!-- Start Clients Testimonial -->
    <section id="testimonial" class="clients-testimonial padding-100">
        <div class="container">
            <div class="row">
                <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                    <h3>Clients
                        <span> Testimonial</span>
                    </h3>
                    <div class="space-25"></div>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem ipsum amet madolor sit amet.</p>
                    <div class="space-50"></div>
                </div>
                <div class="col-12">
                    <div class="testimonial-slider" data-aos="fade-up">
                        <div class="item">
                            <div class="client-testimonial">
                                <p>
                                    Completely build backend ROI whereas cross-media metrics. Collaboratively deploy
                                    customer directed web-readiness via global testing procedures. Appropriately
                                    reinvent distributed innovation.
                                </p>
                            </div>
                            <div class="client-info d-flex align-items-center">
                                <figure>
                                    <img src="https://via.placeholder.com/60x60" class="img-fluid" alt="">
                                </figure>
                                <div>
                                    <h3>Mohamed Kamel</h3>
                                    <h6>CEO - Company Name</h6>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="client-testimonial">
                                <p>
                                    If you can design one thing you can design everything with Front. Just believe it.
                                    Collaboratively repurpose performance based e-commerce without cost. It's beautiful
                                    and the coding is done quickly and seamlessly.
                                </p>
                            </div>
                            <div class="client-info d-flex align-items-center">
                                <figure>
                                    <img src="https://via.placeholder.com/60x60" class="img-fluid" alt="">
                                </figure>
                                <div>
                                    <h3>Mohamed Kamel</h3>
                                    <h6>CEO - Company Name</h6>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="client-testimonial">
                                <p>
                                    If you can design one thing you can design everything with Front. Just believe it.
                                    Collaboratively repurpose performance based e-commerce without cost. It's beautiful
                                    and the coding is done quickly and seamlessly.
                                </p>
                            </div>
                            <div class="client-info d-flex align-items-center">
                                <figure>
                                    <img src="https://via.placeholder.com/60x60" class="img-fluid" alt="">
                                </figure>
                                <div>
                                    <h3>Mohamed Kamel</h3>
                                    <h6>CEO - Company Name</h6>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="client-testimonial">
                                <p>
                                    Completely build backend ROI whereas cross-media metrics. Collaboratively deploy
                                    customer directed web-readiness via global testing procedures. Appropriately
                                    reinvent distributed innovation.
                                </p>
                            </div>
                            <div class="client-info d-flex align-items-center">
                                <figure>
                                    <img src="https://via.placeholder.com/60x60" class="img-fluid" alt="">
                                </figure>
                                <div>
                                    <h3>Mohamed Kamel</h3>
                                    <h6>CEO - Company Name</h6>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="client-testimonial">
                                <p>
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit fugit dignissimos
                                    nihil deleniti sunt enim cupiditate quia
                                    officia suscipit est saepe atque expedita, natus numquam animi inventore harum
                                    esse
                                    ut.
                                </p>
                            </div>
                            <div class="client-info d-flex align-items-center">
                                <figure>
                                    <img src="https://via.placeholder.com/60x60" class="img-fluid" alt="">
                                </figure>
                                <div>
                                    <h3>Mohamed Kamel</h3>
                                    <h6>CEO - Company Name</h6>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="client-testimonial">
                                <p>
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit fugit dignissimos
                                    nihil deleniti sunt enim cupiditate quia
                                    officia suscipit est saepe atque expedita, natus numquam animi inventore harum
                                    esse
                                    ut.
                                </p>
                            </div>
                            <div class="client-info d-flex align-items-center">
                                <figure>
                                    <img src="https://via.placeholder.com/60x60" class="img-fluid" alt="">
                                </figure>
                                <div>
                                    <h3>Mohamed Kamel</h3>
                                    <h6>CEO - Company Name</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Clients Testimonial  -->

    <!-- Start Fun Facts -->
    <section id="facts" class="fun-facts padding-100 background-withcolor">
        <div class="container">
            <div class="row">
                <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                    <h3>Fun
                        <span class="white"> Facts</span>
                    </h3>
                    <div class="space-25"></div>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem ipsum amet madolor sit amet.</p>
                    <div class="space-50"></div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="fact-box text-center" data-aos="fade-up" data-aos-delay="400">
                        <span class="lnr lnr-coffee-cup"></span>
                        <h5>245</h5>
                        <h6>Coffee Cups</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="fact-box text-center" data-aos="fade-up" data-aos-delay="800">
                        <span class="lnr lnr-code"></span>
                        <h5>3000</h5>
                        <h6>Line Code</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="fact-box text-center" data-aos="fade-up" data-aos-delay="1200">
                        <span class="lnr lnr-download"></span>
                        <h5>763</h5>
                        <h6>Download</h6>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="fact-box text-center" data-aos="fade-up" data-aos-delay="1600">
                        <span class="lnr lnr-heart"></span>
                        <h5>360</h5>
                        <h6>Shere</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Fun Facts  -->

    <!-- Start App Price -->
    <section id="prices" class="prices padding-100">
        <div class="container">
            <div class="row">
                <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                    <h3>App
                        <span> Price</span>
                    </h3>
                    <div class="space-25"></div>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem ipsum amet madolor sit amet.</p>
                    <div class="space-50"></div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="price-table text-center" data-aos="fade-right" data-aos-delay="400">
                        <div class="top background-fullwidth" style="background-image: url({{asset('fox/img/gray-bg.jpg)')}};">
                            <h4>Personal</h4>
                            <h3>
                                <span>$</span>30
                            </h3>
                            <h5>Per year</h5>
                        </div>
                        <div class="bottom">
                            <ul>
                                <li>100 MB Disk Space</li>
                                <li>2 Subdomains</li>
                                <li>5 Email Accounts</li>
                                <li>Webmail Support</li>
                                <li>Customer Support 24/7</li>
                            </ul>
                            <div class="space-50"></div>
                            <a href="#" class="btn btn-primary btn-white btn-theme"><span>choose plan</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="price-table text-center" data-aos="fade-up" data-aos-delay="800">
                        <div class="top background-fullwidth" style="background-image: url({{asset('fox/img/gray-bg.jpg);')}}">
                            <span class="offer">offer</span>
                            <h4>Business</h4>
                            <h3>
                                <span>$</span>50
                            </h3>
                            <h5>Per year</h5>
                        </div>
                        <div class="bottom">
                            <ul>
                                <li>100 MB Disk Space</li>
                                <li>2 Subdomains</li>
                                <li>5 Email Accounts</li>
                                <li>Webmail Support</li>
                                <li>Customer Support 24/7</li>
                            </ul>
                            <div class="space-50"></div>
                            <a href="#" class="btn btn-primary btn-white btn-theme"><span>choose plan</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="price-table text-center" data-aos="fade-left" data-aos-delay="1200">
                        <div class="top background-fullwidth" style="background-image: url({{asset('fox/img/gray-bg.jpg)')}};">
                            <h4>Enterprise</h4>
                            <h3>
                                <span>$</span>80
                            </h3>
                            <h5>Per year</h5>
                        </div>
                        <div class="bottom">
                            <ul>
                                <li>100 MB Disk Space</li>
                                <li>2 Subdomains</li>
                                <li>5 Email Accounts</li>
                                <li>Webmail Support</li>
                                <li>Customer Support 24/7</li>
                            </ul>
                            <div class="space-50"></div>
                            <a href="#" class="btn btn-primary btn-white btn-theme"><span>choose plan</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End App Price  -->

    <!-- Start Our Team -->
    <section id="team" class="our-team padding-100 background-fullwidth background-fixed"
        style="background-image: url({{asset('fox/img/gray-bg.jpg)')}};">
        <div class="container">
            <div class="row">
                <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                    <h3>Our
                        <span> Team</span>
                    </h3>
                    <div class="space-25"></div>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem ipsum amet madolor sit amet.</p>
                    <div class="space-50"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="team-slider" data-aos="fade-up">
                        <div class="item person text-center">
                            <img src="https://via.placeholder.com/200x200" class="img-fluid d-block mx-auto" alt="">
                            <div class="space-20"></div>
                            <h3>Emilia Noah</h3>
                            <div class="space-20"></div>
                            <h5>Front-End Developer</h5>
                            <div class="space-20"></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio provident dolores.
                            </p>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="item person text-center">
                            <img src="https://via.placeholder.com/200x200" class="img-fluid d-block mx-auto" alt="">
                            <div class="space-20"></div>
                            <h3>Harry Henry</h3>
                            <div class="space-20"></div>
                            <h5>Front-End Developer</h5>
                            <div class="space-20"></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio provident dolores.
                            </p>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="item person text-center">
                            <img src="https://via.placeholder.com/200x200" class="img-fluid d-block mx-auto" alt="">
                            <div class="space-20"></div>
                            <h3>Poppy Reuben</h3>
                            <div class="space-20"></div>
                            <h5>Front-End Developer</h5>
                            <div class="space-20"></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio provident dolores.
                            </p>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="item person text-center">
                            <img src="https://via.placeholder.com/200x200" class="img-fluid d-block mx-auto" alt="">
                            <div class="space-20"></div>
                            <h3>Alexander Thomas</h3>
                            <div class="space-20"></div>
                            <h5>Front-End Developer</h5>
                            <div class="space-20"></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio provident dolores.
                            </p>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="item person text-center">
                            <img src="https://via.placeholder.com/200x200" class="img-fluid d-block mx-auto" alt="">
                            <div class="space-20"></div>
                            <h3>Emilia Noah</h3>
                            <div class="space-20"></div>
                            <h5>Front-End Developer</h5>
                            <div class="space-20"></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio provident dolores.
                            </p>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="item person text-center">
                            <img src="https://via.placeholder.com/200x200" class="img-fluid d-block mx-auto" alt="">
                            <div class="space-20"></div>
                            <h3>Harry Henry</h3>
                            <div class="space-20"></div>
                            <h5>Front-End Developer</h5>
                            <div class="space-20"></div>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio provident dolores.
                            </p>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Our Team -->

    <!-- Start FAQ -->
    <section id="faq" class="faq padding-100">
        <div class="container">
            <div class="row">
                <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                    <h3>Common
                        <span> FAQ</span>
                    </h3>
                    <div class="space-25"></div>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem ipsum amet madolor sit amet.</p>
                    <div class="space-50"></div>
                </div>
            </div>
            <div class="row align-items-center">
                <!--align-items-center-->
                <div class="col-md-8 col-12" data-aos="fade-right">
                    <div class="accordion" id="faqAccordion">
                        <div class="card shadow">
                            <div class="card-header" id="heading_1">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                        data-target="#collapse_1" aria-expanded="true" aria-controls="collapse_1">
                                        What Is fox
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse_1" class="collapse show" aria-labelledby="heading_1"
                                data-parent="#faqAccordion">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum tenetur dicta
                                    commodi, totam atque fugit ut magnam laboriosam
                                    dignissimos dolorum minus quia sed distinctio in mollitia laborum sint delectus
                                    accusamus!
                                    <br> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum tenetur
                                    dicta
                                    commodi,
                                    totam atque fugit ut magnam.
                                </div>
                            </div>
                        </div>
                        <div class="card shadow">
                            <div class="card-header" id="heading_2">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapse_2" aria-expanded="false" aria-controls="collapse_2">
                                        How To Use The App
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse_2" class="collapse" aria-labelledby="heading_2"
                                data-parent="#faqAccordion">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum tenetur dicta
                                    commodi, totam atque fugit ut magnam laboriosam
                                    dignissimos dolorum minus quia sed distinctio in mollitia laborum sint delectus
                                    accusamus!
                                    <br> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum tenetur
                                    dicta
                                    commodi,
                                    totam atque fugit ut magnam.
                                </div>
                            </div>
                        </div>
                        <div class="card shadow">
                            <div class="card-header" id="heading_3">
                                <h5 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapse_3" aria-expanded="false" aria-controls="collapse_3">
                                        How To Connect With The Support
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse_3" class="collapse" aria-labelledby="heading_3"
                                data-parent="#faqAccordion">
                                <div class="card-body">
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum tenetur dicta
                                    commodi, totam atque fugit ut magnam laboriosam
                                    dignissimos dolorum minus quia sed distinctio in mollitia laborum sint delectus
                                    accusamus!
                                    <br> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Harum tenetur
                                    dicta
                                    commodi,
                                    totam atque fugit ut magnam.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12" data-aos="fade-left" data-aos-delay="400">
                    <img src="{{asset('fox/img/mobile-1.png')}}" class="img-fluid b-block mx-auto" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- End FAQ  -->

    <!-- Start Fun Facts -->
    <section id="logos" class="logos background-withcolor">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="logos-slider">
                        <div class="item">
                            <img src="{{asset('fox/img/logo-1.png')}}" class="img-fluid mx-auto b-block" alt="">
                        </div>
                        <div class="item">
                            <img src="{{asset('fox/img/logo-2.png')}}" class="img-fluid mx-auto b-block" alt="">
                        </div>
                        <div class="item">
                            <img src="{{asset('fox/img/logo-3.png')}}" class="img-fluid mx-auto b-block" alt="">
                        </div>
                        <div class="item">
                            <img src="{{asset('fox/img/logo-4.png')}}" class="img-fluid mx-auto b-block" alt="">
                        </div>
                        <div class="item">
                            <img src="{{asset('fox/img/logo-5.png')}}" class="img-fluid mx-auto b-block" alt="">
                        </div>
                        <div class="item">
                            <img src="{{asset('fox/img/logo-6.png')}}" class="img-fluid mx-auto b-block" alt="">
                        </div>
                        <div class="item">
                            <img src="{{asset('fox/img/logo-1.png')}}" class="img-fluid mx-auto b-block" alt="">
                        </div>
                        <div class="item">
                            <img src="{{asset('fox/img/logo-2.png')}}" class="img-fluid mx-auto b-block" alt="">
                        </div>
                        <div class="item">
                            <img src="{{asset('fox/img/logo-3.png')}}" class="img-fluid mx-auto b-block" alt="">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Fun Facts  -->

    <!-- Start Recent News -->
    <section id="recent_news" class="recent-news padding-100">
        <div class="container">
            <div class="row">
                <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                    <h3>Recent
                        <span> News</span>
                    </h3>
                    <div class="space-25"></div>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem ipsum amet madolor sit amet.</p>
                    <div class="space-50"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="recent-news-slider" data-aos="fade-up">
                        <div class="item">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <img src="https://via.placeholder.com/540x335" class="img-fluid" alt="">
                                </div>
                                <div class="col-md-6 col-12">
                                    <h3>fox Discover The World</h3>
                                    <div class="space-15"></div>
                                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor coli
                                        incidit labore lorem Lorem ipsum madolor sit amet, consectetur adipisicing
                                        elit.
                                    </p>
                                    <div class="space-15"></div>
                                    <ul class="news-meta">
                                        <li>
                                            <span class="lnr lnr-user"></span> By Admin</li>
                                        <li>
                                            <span class="lnr lnr-clock"></span> Feb 26, 2018</li>
                                    </ul>
                                    <div class="space-15"></div>
                                    <a href="news-single.html"
                                        class="btn btn-primary shadow btn-colord btn-theme"><span>Read
                                            More</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <img src="https://via.placeholder.com/540x335" class="img-fluid" alt="">
                                </div>
                                <div class="col-md-6 col-12">
                                    <h3>Inspired Design Decisions</h3>
                                    <div class="space-15"></div>
                                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor coli
                                        incidit labore lorem Lorem ipsum madolor sit amet, consectetur adipisicing
                                        elit.
                                    </p>
                                    <div class="space-15"></div>
                                    <ul class="news-meta">
                                        <li>
                                            <span class="lnr lnr-user"></span> By Admin</li>
                                        <li>
                                            <span class="lnr lnr-clock"></span> Feb 26, 2018</li>
                                    </ul>
                                    <div class="space-15"></div>
                                    <a href="news-single.html"
                                        class="btn btn-primary shadow btn-colord btn-theme"><span>Read
                                            More</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-12">
                                    <img src="https://via.placeholder.com/540x335" class="img-fluid" alt="">
                                </div>
                                <div class="col-md-6 col-12">
                                    <h3>Exploring The Latest Web Design Trends.</h3>
                                    <div class="space-15"></div>
                                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                        tempor coli
                                        incidit labore lorem Lorem ipsum madolor sit amet, consectetur adipisicing
                                        elit.
                                    </p>
                                    <div class="space-15"></div>
                                    <ul class="news-meta">
                                        <li>
                                            <span class="lnr lnr-user"></span> By Admin</li>
                                        <li>
                                            <span class="lnr lnr-clock"></span> Feb 26, 2018</li>
                                    </ul>
                                    <div class="space-15"></div>
                                    <a href="news-single.html"
                                        class="btn btn-primary shadow btn-colord btn-theme"><span>Read
                                            More</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Recent News  -->

    <!-- Start Download App -->
    <section id="download_app" class="download-app padding-100 pb-0 background-fullwidth background-fixed"
        style="background-image: url({{asset('fox/img/gray-bg.jpg)')}};">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-12" data-aos="fade-right">
                    <h2>Download our free trial App</h2>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem
                    </p>
                    <a href="#" class="btn btn-primary shadow btn-colord btn-theme" tabindex="0">
                        <i class="fab fa-apple"></i>
                        <span>Git it on
                            <br>APP STORE</span>
                    </a>
                    <a href="#" class="btn btn-primary shadow  btn-colord btn-theme" tabindex="0">
                        <i class="fab fa-google-play"></i>
                        <span>Git it on
                            <br>GOOGLE PLAY</span>
                    </a>
                </div>
                <div class="col-lg-6 col-12" data-aos="fade-left" data-aos-delay="400">
                    <img src="{{asset('fox/img/mobile-6.png')}}" class="img-fluid d-block mx-auto" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- End Download App -->

    <!-- Start  Git in touch -->
    <section id="git_in_touch" class="git-in-touch padding-100">
        <div class="container">
            <div class="row">
                <div class="text-center col-12 section-title" data-aos="fade-zoom-in">
                    <h3>Git
                        <span> in </span>touch
                    </h3>
                    <div class="space-25"></div>
                    <p>Lorem ipsum madolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor coli
                        incidit
                        labore
                        lorem ipsum amet madolor sit amet.</p>
                    <div class="space-50"></div>
                </div>
            </div>
            <form data-aos="fade-up">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter Your Name">
                            <span class="focus-border"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Enter Your Email">
                            <span class="focus-border"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Enter Your Subject">
                            <span class="focus-border"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <textarea class="form-control" rows="4" placeholder="Enter Your Message"></textarea>
                            <span class="focus-border"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="space-25"></div>
                        <button type="submit" class="btn btn-primary shadow btn-colord btn-theme"><span>Send
                                Message</span></button>
                    </div>
                </div>
            </form>
            <div class="space-50"></div>
            <div class="row contact-info">
                <div class="col-md-4 col-12 text-center">
                    <div class="info-box" data-aos="fade-right" data-aos-delay="400">
                        <span class="lnr lnr-map-marker"></span>
                        <h5>28 Green Tower, Street Name New York City, USA</h5>
                    </div>
                </div>
                <div class="col-md-4 col-12 text-center">
                    <div class="info-box" data-aos="fade-up" data-aos-delay="800">
                        <span class="lnr lnr-phone"></span>
                        <h5>+2 012 345 6789</h5>
                        <h5>+2 02 345 6789</h5>
                    </div>
                </div>
                <div class="col-md-4 col-12 text-center">
                    <div class="info-box" data-aos="fade-left" data-aos-delay="1200">
                        <span class="lnr lnr-envelope"></span>
                        <a href="mailto:info@yourcompany.com">info@yourcompany.com</a>
                        <a href="mailto:sales@yourcompany.com">sales@yourcompany.com</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End  Git in touch  -->

    <!-- Start  Map -->
    <section class="map">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55251.37709962986!2d31.22344494535329!3d30.059483810352845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583fa60b21beeb%3A0x79dfb296e8423bba!2sCairo%2C+Cairo+Governorate!5e0!3m2!1sen!2seg!4v1540147674461"
            style="border:0" allowfullscreen></iframe>
    </section>
    <!-- End  Map  -->
@endsection