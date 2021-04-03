<?php for($i=1; $i<= 5; $i++): ?>
<div class=" ticket-section card-section mt-5 p-2">
    <div class="cart-item">
        <div class="d-sm-flex">
            <div class="text-center"><img src="img/product-thumb-1.jpg" alt=""></div>
            <div class="off-item-title d-flex flex-column">
                <div class="p-2">
                    <span>شماره سفارش </span>
                    <span>100285221</span>
                    <span> - </span>
                    <span>30/11/1399</span>
                    <span>بن تخفیف 10 درصدی استخر بهار</span>
                </div>
                <div class="d-flex p-2 mt-auto">
                    <div>
                        <span>قیمت اصلی: </span>
                        <span>1,000</span>
                        <span>تومان</span>
                    </div>
                    <div class="pl-2 text-success">
                        <span>پرداخت شما : </span>
                        <span>1,000</span>
                        <span>تومان</span>
                    </div>
                    <div class="pl-2 text-danger">
                        <span>مقدار سود شما : </span>
                        <span>1,000</span>
                        <span>تومان</span>
                    </div>
                </div>
            </div>
            <div class="align-self-center theme-btn green-btn ml-auto"><span><i class="fa-regular fa-print"></i> </span>چاپ بلیط</div>
        </div>
        <hr>
        <div class="d-sm-flex justify-content-around">
            <div class="text-center">
                <div class="font-weight-bold">کد QR</div>
                <div><img class="thumb-qr-code" src="img/qrcode.png" alt=""></div>
            </div>

            <div class="text-center d-flex flex-column  justify-content-between">
                <div class="font-weight-bold">مدت اعتبار</div>
                <div><span class="text-danger">1399/10/30</span><span> تا </span><span class="text-danger">13399/12/30</span></div>
            </div>

            <div class="text-center d-flex flex-column  justify-content-between">
                <div class="font-weight-bold">کد تخفیف</div>
                <div>125FGDGD6546546</div>
            </div>

            <div class="text-center d-flex flex-column  justify-content-between">
                <div class="font-weight-bold">وصعیت تخفیف</div>
                <div class="text-success">فعال</div>
            </div>
        </div>
    </div><!-- .cart-item -->
</div><!-- .ticket-section -->
<?php endfor; ?>
