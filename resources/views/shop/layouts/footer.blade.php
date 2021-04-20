<footer id="footer">
    <div class="container">
        <div class="footer-ribbon">
            <span>در ارتباط باشید</span>
        </div>
        <div class="row py-5 my-4">
            <div class="col-md-6 col-lg-4 mb-4 mb-lg-0 pb-2 pb-lg-0">
                <h5 class="text-3 mb-3">خبرنامه</h5>
                <p class="pr-1">از آخرین ویژگی ها و به‌روزرسانی های ما با خبر شوید. ایمیل خود را وارد کرده و مشترک خبرنامه ما شوید.</p>
                <div class="alert alert-success d-none" id="newsletterSuccess">
                    <strong>موفقیت!</strong> شما به لیست ایمیل ما افزوده شدید.
                </div>
                <div class="alert alert-danger d-none" id="newsletterError"></div>
                <form id="newsletterForm" action="php/newsletter-subscribe.php" method="POST" class="mr-md-4 mb-3" novalidate="novalidate">
                    <div class="input-group input-group-rounded">
                        <input class="form-control form-control-sm bg-light text-left" placeholder="آدرس ایمیل" dir="ltr" name="newsletterEmail" id="newsletterEmail" type="text">
                        <span class="input-group-append">
										<button class="btn btn-light text-color-dark" type="submit"><strong>برو!</strong></button>
									</span>
                    </div>
                </form>
            </div>
            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0 pb-2 pb-lg-0">
                <h5 class="text-3 mb-3">جدیدترین توییت ها</h5>
                <div id="tweet" class="twitter mb-2" data-plugin-tweets="" data-plugin-options="{'username': 'rtltheme', 'count': 2}">
                    <p class="mb-0">لطفا منتظر باشید ...</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 mb-4 mb-md-0 pb-2 pb-md-0">
                <div class="contact-details">
                    <h5 class="text-3 mb-3">تماس با ما</h5>
                    <ul class="list list-icons list-icons-lg mb-2">
                        <li class="mb-1"><i class="far fa-dot-circle text-color-primary"></i><p class="m-0">تبریز، فلکه دانشگاه، برج بلور، طبقه 456</p></li>
                        <li class="mb-1"><i class="fab fa-whatsapp text-color-primary"></i><p class="m-0"><a href="tel:8001234567" class="ltr-text">(+98) 123-4567</a></p></li>
                        <li class="mb-1"><i class="far fa-envelope text-color-primary"></i><p class="m-0"><a href="mailto:mail@example.com">mail@example.com</a></p></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-2">
                <h5 class="text-3 mb-3 pb-1">ما را دنبال کنید</h5>
                <ul class="social-icons">
                    <li class="social-icons-facebook"><a href="http://www.facebook.com/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="social-icons-twitter"><a href="http://www.twitter.com/" target="_blank" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                    <li class="social-icons-linkedin"><a href="http://www.linkedin.com/" target="_blank" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container py-2">
            <div class="row py-4">
                <div class="col-lg-1 d-flex align-items-center justify-content-center justify-content-lg-start mb-2 mb-lg-0 mt-1 mt-lg-0">
                    <a href="index.html" class="logo pr-0 pr-lg-3">
                        <img alt="" src="" class="opacity-5" height="33">
                    </a>
                </div>
                <div class="col-lg-7 d-flex align-items-center justify-content-center justify-content-lg-start mb-4 mb-lg-0">
                    <p> </p>
                </div>
                <div class="col-lg-4 d-flex align-items-center justify-content-center justify-content-lg-end">
                    <nav id="sub-menu">
                        <ul>
                            <li><i class="fas fa-angle-left"></i><a href="page-faq.html" class="ml-1 text-decoration-none"> سوالات متداول</a></li>
                            <li><i class="fas fa-angle-left"></i><a href="sitemap.html" class="ml-1 text-decoration-none"> نقشه سایت</a></li>
                            <li><i class="fas fa-angle-left"></i><a href="contact-us.html" class="ml-1 text-decoration-none"> تماس با ما</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</footer>
