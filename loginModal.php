<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="tab" role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#login" role="tab" data-toggle="tab">Log
                                In</a></li>
                        <li role="presentation"><a href="#register" role="tab" data-toggle="tab">Sign Up</a></li>
                    </ul>
                    <div class="tab-content" id="myModalLabel2">
                        <div role="tabpanel" class="tab-pane fade in active" id="login">
                            <img src="assets/img/logo.png" class="img-responsive" alt=""/>

                            <div class="subscribe wow fadeInUp">
                                <form class="form-inline" method="post" action="login.php">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control"
                                                   placeholder="E-mail" required="">
                                            <input type="password" name="password" class="form-control"
                                                   placeholder="Password" required="">
                                            <br>
                                            <input type="checkbox" name="remember" value="Yes">
                                            <label for="remember">Remember me</label>
                                            <br>
                                            </span> Forgot Password? <a href="lost-password.php" class="cl-success">Click Here</a>
                                            <div class="center">
                                                <button type="submit" id="login-btn" class="submit-btn" name="login"> Login
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="register">
                            <img src="assets/img/logo.png" class="img-responsive" alt=""/>

                            <form class="form-inline" method="post" action="login.php">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="text"  name="name" class="form-control" placeholder="Your Full Name*" required="">
                                        <input type="email"  name="email" class="form-control" placeholder="Your Email*" required="">
                                        <input type="tel" name="phone" class="form-control"  placeholder="Your Phone Number">
                                        <input type="password" name="password" class="form-control"  placeholder="Password*" required="">
                                        <select name="type" class="form-control" required="">
                                            <option value="0">Register for a Candidate Account</option>
                                            <option value="1">Register for a Company Account</option>
                                        </select>
                                        <div class="center">
                                            <button type="submit" id="subscribe" class="submit-btn" name="signup"> Create Account </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
