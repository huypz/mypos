<!-- LOGIN POPUP
<div class="login-dialog">
    <div class="login-dialog-scroll-container">
        <div class="login-dialog-content">
            <div class="login-container">
                <div class="close-btn" onclick="closeLoginForm()">&times;</div>
                <div class="login-form-container">
                    <div class="login-form-header">Log In</div>
                    <form action="login.php" method="post">
                        <div class="login-form-input">
                            <div class="input-container">
                                <input type="text" placeholder="Username/Email" maxlength="64">
                            </div>
                        </div>
                        <div class="login-form-input">
                            <div class="input-container">
                                <input type="password" placeholder="Password" maxlength="64">
                            </div>
                        </div>
                        <div class="login-form-button">
                            <button class="login-btn" type="submit">Log In</button>
                        </div>
                    </form>
                    <div class="register-bar">
                        <a href="#" target="_blank">Forgot Password?</a>
                        <a class="to-register">Register Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->
<?php
if (isset($errors))
?>
