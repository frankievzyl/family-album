<div class="cover"></div>
<div class="popup-layer-1">
    <form name="signupform" class="sign-up-form" method="get">
        <span>Please enter a username:</span>
        <input type="text" name="Name">
        <input type="hidden" name="action" value="sign_up">
        <input type="hidden" name="controller" value="user">
        <button class="confirm-btn v-btn" type="submit">Sign-up</button>
        <button class="cancel-btn v-btn" type="button" onclick="hide_signup()">Cancel</button>
    </form>
</div>
<div class="login-container">        
    <form name="loginform" class="log-in-form" method="get">
        <button class="user-login-button" type="submit" name="userPK" value="1"><img src="media/icons/defaultUser.jpg" alt=""><span>user A</span></button>
        <button class="user-login-button" type="submit" name="userPK" value="1"><img src="media/icons/defaultUser.jpg" alt=""><span>user B</span></button>
        <button class="user-login-button" type="submit" name="userPK" value="1"><img src="media/icons/defaultUser.jpg" alt=""><span>user C</span></button>
        <input type="hidden" name="action" value="show_all">
        <input type="hidden" name="controller" value="album">
    </form>
    <button id="sign-up-link" class="v-btn" onclick="display_signup()">New user? Click here to sign up</button>
</div>