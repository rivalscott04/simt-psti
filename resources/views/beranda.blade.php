<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Beranda | Sistem Informasi Monitoring Tugas</title>
    <link rel="icon" href="{{ asset('img/logo_unram.png')}}" />


    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Animation CSS -->
    <link href="{{ asset('css/animate.css')}}" rel="stylesheet" />
    <link href="{{ asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css')}}" rel="stylesheet" />
</head>
<body id="page-top" class="landing-page no-skin-config bg-white">
    <div class="navbar-wrapper">
        <nav class="navbar navbar-default navbar-fixed-top navbar-expand-md" role="navigation">
            <div class="container">
                <a class="navbar-brand" href="/">PSTI</a>
                <div class="navbar-header page-scroll">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a class="nav-link page-scroll" href="/">Beranda</a>
                        </li>
                        <!-- <li>
                            <a class="nav-link page-scroll" href="/daftar-tugas">Daftar Tugas</a>
                        </li> -->
                        <li>
                            <a class="nav-link page-scroll" href="#contact">Kontak</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="container text-center animated fadeInDown">
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <div class="container">
                    <div class="carousel-caption">
                        <h1 class="wow zoomIn animated animated" style="visibility: visible">
                            Sistem Informasi Monitoring Tugas
                        </h1>
                        <p class="wow zoomIn animated animated" style="visibility: visible">
                            Teknik Informatika Universitas Mataram
                        </p>
                        <br />
                        <p>
                            <br />
                            <!-- <a class="btn btn-lg btn-success" href="https://form.if.unram.ac.id/index.php/u/masuk"> <i class="fa fa-lock"></i> &nbsp;Masuk </a> -->
                            <a class="btn btn-lg btn-success" href="/login">
                                <i class="fa fa-lock"></i> &nbsp;Masuk
                            </a>
                            &nbsp;
                            <!-- <a class="btn btn-lg btn-danger btn-outline" href="/daftar-tugas">
                                <i class="fa fa-calendar"></i> &nbsp;Daftar Tugas
                                &nbsp; <i class="fa fa-chevron-right"></i>
                            </a> -->
                        </p>
                    </div>
                    <div class="carousel-image wow zoomIn animated animated" style="visibility: visible">
                        <img src="{{ asset('img/monitoring.png') }}" alt="Form Mahasiswa" />
                    </div>
                </div>
                <div class="header-back"></div>
            </div>
        </div>
    </div>
    <section id="contact" class="gray-section contact">
        <div class="container">
            <div class="row m-b-lg">
                <div class="col-lg-12 text-center">
                    <div class="navy-line"></div>
                    <h1>Hubungi Kami</h1>

                </div>
            </div>
            <div class="row m-b-lg justify-content-center">
                <div class="col-lg-3">
                    <address>
                        Jl. Majapahit No. 62, Mataram<br />
                        NTB (Nusa Tenggara Barat)
                        <br>
                        <br>
                        <!-- <abbr title="Telegram Chat">
                            <i class="fa fa-paper-plane-o"></i>
                        </abbr> -->
                        <i class="fa fa-paper-plane-o"></i>
                        &nbsp;
                        <a href="https://t.me/unrampustikhelp">Help Desk </a>(chat)
                        <br>
                        <!-- <abbr title="Telegram Channel">
                            <i class="fa fa-bullhorn"></i>
                        </abbr> -->
                        <i class="fa fa-bullhorn"></i>
                        &nbsp;
                        <a href="https://t.me/unramnews">UNRAM News </a>(channel)
                        <br>
                    </address>
                </div>
                <div class="col-lg-4">
                    <p class="text-color">
                        Jika memiliki pertanyaan atau mengalami kendala selama
                        proses pengisian silakan menghubungi kami melalui
                        beberapa jalur yang tertera.
                    </p>
                    <p class="text-color">
                        Untuk
                        <strong>Help Desk</strong>
                        bisa dihubungi melalui telegram (hanya chat).
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center m-t-lg m-b-lg">
                    <p>
                        <strong>&copy; 2023 Teknik Informatika Universitas Mataram</strong><br />
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{ asset('js/popper.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.js')}}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js')}}"></script>
    <script src="{{ asset('js/plugins/wow/wow.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            $("body").scrollspy({
                target: "#navbar",
                offset: 80,
            });

            // Page scrolling feature
            $("a.page-scroll").bind("click", function (event) {
                var link = $(this);
                $("html, body")
                    .stop()
                    .animate(
                        {
                            scrollTop:
                                $(link.attr("href")).offset().top - 50,
                        },
                        500
                    );
                event.preventDefault();
                $("#navbar").collapse("hide");
            });
        });

        var cbpAnimatedHeader = (function () {
            var docElem = document.documentElement,
                header = document.querySelector(".navbar-default"),
                didScroll = false,
                changeHeaderOn = 200;
            function init() {
                window.addEventListener(
                    "scroll",
                    function (event) {
                        if (!didScroll) {
                            didScroll = true;
                            setTimeout(scrollPage, 250);
                        }
                    },
                    false
                );
            }
            function scrollPage() {
                var sy = scrollY();
                if (sy >= changeHeaderOn) {
                    $(header).addClass("navbar-scroll");
                } else {
                    $(header).removeClass("navbar-scroll");
                }
                didScroll = false;
            }
            function scrollY() {
                return window.pageYOffset || docElem.scrollTop;
            }
            init();
        })();

        // Activate WOW.js plugin for animation on scrol
        new WOW().init();
    </script>
</body>
</html>