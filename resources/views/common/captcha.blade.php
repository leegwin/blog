<input id="j_captcha" name="j_captcha" type="text" onblur="value=value.replace(/\s+/g,'')" class="style_x164 v_align" placeholder="验证码">
<img id="captcha" class="captcha_img v_align" alt="点击更换" title="点击更换" src="/api/captcha" onclick="this.src='/api/captcha?rd='+Math.random();">
