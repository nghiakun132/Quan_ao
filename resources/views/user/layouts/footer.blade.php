<footer class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="footer-left">
                    <div class="footer-logo">
                        <a href="#"><img src="{{ asset('user/img/footer-logo.png') }}" alt=""></a>
                    </div>
                    <ul>
                        <li>Phone: +65 11.188.888</li>
                        <li>Email: Tuong@gmail.com</li>
                    </ul>
                    <div class="footer-social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-1">
                <div class="footer-widget">
                    <h5>Thông tin</h5>
                    <ul>
                        <li><a href="#">Về chúng tôi</a></li>
                        <li><a href="#">Thanh toán</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="footer-widget">
                    <h5>Tài khoản của tôi</h5>
                    <ul>
                        <li><a href="{{route('user.profile')}}">Tài khoản của tôi</a></li>
                        <li><a href="{{route('user.cart')}}">Giỏ hàng</a></li>
                        <li><a href="#">Danh sách yêu thích</a></li>
                        <li>
                            <a href="{{route('user.order')}}">
                                Đơn hàng của tôi
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="newslatter-item">
                    <h5>Đăng ký nhận tin</h5>
                    <p>Đăng ký nhận tin để nhận thông tin mới nhất từ chúng tôi</p>
                    <form action="#" class="subscribe-form" method="POST">
                        <input type="text" placeholder="Enter Your Mail" name="email">
                        <button type="submit">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-reserved">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-text">
                        Vĩnh Tường © {{ date('Y') }}
                    </div>
                    <div class="payment-pic">
                        <img src="{{ asset('user/img/payment-method.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
