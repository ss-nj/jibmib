<!-- _______________Footer__________________________-->
<footer class="theme-footer w-100">
    <?php  ?>
    <section class="row">
        <div class="col-md-4 po-relative ">
            <?php  ?>
            <div class="footer-top-semicircle"></div>
            <div class="footer-bottom-semicircle"></div>
            <div class="footer-right-side">
                <div class="footer-right-side-container">
                    <div class="text-center"><img src="{{asset(trim($siteSettings['site_logo']->value_fa))}}" alt=""></div>
                    <div class="text-justify">
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشدم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.

                    </div>
                </div><!--footer-right-side-container-->
            </div>
        </div>
        <div class="col-md-8">
            <div class="footer-left-side">
                <div class="row">
                    <div class="col-12">
                        <div class="row footer-address-container">
                            <div class="col-xl-4 col-md-6 mt-3">
                                <div class="footer-contact-container m-auto">
                                    <span>آدرس :</span>
                                    <span>اصفهان، خ کاوه بسمت شهدا پ ۸۴</span>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mt-3">
                                <div class="footer-contact-container m-auto">
                                    <p><span>تلفن تماس :</span><span>۳۳۳۷۰۰۹۴</span></p>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mt-3">
                                <div class="footer-contact-container m-auto">
                                    <span>پست الکترونیکی :</span>
                                    <span>support@jibmib.com</span>
                                </div>
                            </div>
                        </div><!--row-->
                    </div><!--col-12-->

                    <div class="col-12">
                        <div class="footer-cols-container d-sm-flex">
                            <div class="footer-menus-container d-sm-flex justify-content-between">

                                <ul class="d-flex flex-column mr-4">
                                    @foreach($cashed_menus->where('menu','footer_1') as $cashed_menu1)
                                        <li><span class="footer-menu-line"></span><a href="{{$cashed_menu1->link}}"> {{$cashed_menu1->name}} </a></li>
                                    @endforeach
                                </ul>
                                <ul class="d-flex flex-column mr-4">
                                    @foreach($cashed_menus->where('menu','footer_2') as $cashed_menu2)
                                         <li><span class="footer-menu-line"></span><a href="{{$cashed_menu2->link}}"> {{$cashed_menu2->name}} </a></li>
                                    @endforeach
                                </ul>
                                <ul class="d-flex flex-column mr-4">
                                    @foreach($cashed_menus->where('menu','footer_3') as $cashed_menu3)
                                         <li><span class="footer-menu-line"></span><a href="{{$cashed_menu3->link}}"> {{$cashed_menu3->name}} </a></li>
                                    @endforeach
                                </ul>
                                <ul class="d-flex flex-column mr-4">
                                    @foreach($cashed_menus->where('menu','footer_4') as $cashed_menu4)
                                         <li><span class="footer-menu-line"></span><a href="{{$cashed_menu4->link}}"> {{$cashed_menu4->name}} </a></li>
                                    @endforeach
                                </ul>


                            </div><!--footer-menus-container-->
                            <div class="img-nemad-container text-center"><img src="{{asset($path_user.'img/nemad.png').'?ver='.$ver}}" alt="" width="80"></div>

{{--                            <div class="img-nemad-container text-center"><a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=207613&amp;Code=fgsOSyeaciNUuhEul30U"><img referrerpolicy="origin" src="https://Trustseal.eNamad.ir/logo.aspx?id=207613&amp;Code=fgsOSyeaciNUuhEul30U" alt="" style="cursor:pointer" id="fgsOSyeaciNUuhEul30U"></a></div>--}}
{{--                            <div class="img-nemad-container text-center"><img src="{{asset($path_user.'img/nemad-2.png').'?ver='.$ver}}" alt="" width="80"></div>--}}

                        </div><!--footer-cols-container-->
                    </div><!--col-12-->

                    <div class="col-12">
                        <div class="d-sm-flex copyright-container">
                            <div class="bottom-footer-copyright text-center">
                                <span><i class="fa-regular fa-copyright"></i></span>
                                <span> حقوق مادی و معنوی این سامانه متعلق به شرکت فناوری اطلاعات طراحان داتیس ایرانیان تحت برند طراحان ایرانیان می‌باشد
                                </span>
                            </div><!--bottom-footer-copyright-->
                            <div class="bottom-footer-creator text-center"><a href="#">
                                    <span>طراحی وب سایت </span>
                                    <span><img src="{{asset($path_user.'img/tarahan-logo.png').'?ver='.$ver}}" alt="" width="30"></span>
                                    <span>طراحان ایرانیان</span>
                                </a></div><!--bottom-footer-creator-->
                        </div><!--d-flex-->
                    </div><!--.col-12-->

                </div><!--row-->
            </div><!--.footer-left-side-->
        </div><!--.col-md-8-->

{{--        <div class="social-side">--}}
{{--            <div class="social-side-icon-container"><i class="fa-brands fa-whatsapp"></i></div><!--social-side-icon-container-->--}}
{{--            <div class="social-side-icon-container"><i class="fa-brands fa-tumblr"></i></div><!--social-side-icon-container-->--}}
{{--            <div class="social-side-icon-container"><i class="fa-brands fa-twitter"></i></div><!--social-side-icon-container-->--}}
{{--            <div class="social-side-icon-container"><i class="fa-brands fa-linkedin-in"></i></div><!--social-side-icon-container-->--}}
{{--            <div class="social-side-icon-container"><i class="fa-brands fa-facebook-f"></i></div><!--social-side-icon-container-->--}}
{{--        </div><!--social-side-->--}}
    </section>

        <img class="footer-side footer-side-right" src="{{asset($path_user.'img/footer-side.svg').'?ver='.$ver}}" alt="">
        <img class="footer-side footer-side-left" src="{{asset($path_user.'img/footer-side.svg').'?ver='.$ver}}" alt="">

        @include('front.layouts.scripts')

</footer>

</body>
</html>
