<!-- Footer Start -->
<footer>
    <div id="footer_top">
        <div class="container">
            <div class="row">
                <div class="footer_teaser col-sm-6">
                    <h3>Sobre Nós</h3>
                    <p><a href="{{ url('/') }}">App</a>, é um portal que possuí campanhas de entidades sociais. Breve descrição aqui!</p>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-map-marker"></i> XX - XX</li>
                        <li class="number"><i class="fa fa-phone"></i> (51) XXXX-XXXX</li>
                        <li><i class="fa fa-envelope"></i> contato@site.com.br</li>
                    </ul>
                    <div class="space"></div>
                </div>

                <div class="footer_teaser col-sm-6">
                    <h3>Fale Conosco</h3>
                    <p> Entre em Contato conosco, teremos o maior prazer em atendê-lo! Nos siga nas redes sociais também:</p>
                    <ul class="list-unstyled mt15">
                        <li><i class="fa fa-facebook"></i> /site</li>
                        <li><i class="fa fa-twitter"></i> @site</li>
                        <li><i class="fa fa-instagram"></i> /site</li>
                    </ul>
                    <div class="space"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom-bar">
        <div class="container">
            <div class="copyright">@ Copyright {{ date('Y') }} App - www.site.com.br</div>
        </div>
    </div>
</footer>
<!-- Footer End -->

<!-- Got to top -->
<a id="gotop"><i class="fa fa-arrow-circle-up"></i></a> </div>

<!-- Placed at the end of the document so the pages load faster -->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
<script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-migrate.min.js') }}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<!-- include jQuery + carouFredSel plugin -->
<script src="{{ asset('assets/js/jquery.carouFredSel-6.2.1-packed.js') }}"></script>
<!-- Flex slider Blog-->
<script src="{{ asset('assets/js/jquery.flexslider.js') }}"></script>
<!-- Jquery zoom on detail page-->
<script src="{{ asset('assets/js/zoomsl-3.0.min.js') }}"></script>
<!-- Jquery Validation-->
<script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
<!-- Jquery Latest Tweet-->
<script src="{{ asset('assets/js/jquery.tweet.js') }}"></script>
<!-- Jquery Countdown-->
<script src="{{ asset('assets/js/jquery.countdown.js') }}"></script>
<!-- Social -->
<script src="{{ asset('assets/js/socialstream.jquery.js') }}"></script>
<!-- Jquery Map -->
<script src="https://maps.google.com/maps/api/js?sensor=true"></script>
<script src="{{ asset('assets/js/jquery.gmap.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/js/jquery.sparkline.min.js') }}"></script>
<!-- Cloud -->
<script src="{{ asset('assets/js/jqcloud-1.0.4.js') }}"></script>
<!-- Ratina View -->
<script src="{{ asset('assets/js/retina-1.1.0.min.js') }}"></script>
<!-- Custom -->
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/jquery.style-switcher.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/jquery.fancybox.js') }}"></script>
@yield('page-js')
<script>
    $(document).ready(function() {
        $('#styleswitch').styleSwitcher();
        $("#styleswitch h3").click(function() {
            if ($(this).parent().css("left") == "-200px") {
                $(this).parent().animate({
                    left: '0px'
                }, {
                    queue: false,
                    duration: 500
                });
            } else {
                $(this).parent().animate({
                    left: '-200px'
                }, {
                    queue: false,
                    duration: 500
                });
            }
        });
    });
</script>
