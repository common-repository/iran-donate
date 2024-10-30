<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if ($has_error): ?>
    <div class="massage error">
        <p><?php echo $massage; ?></p>
    </div>
<?php endif;?>
<form id="irdonateay_from" action="" method="post" >
    <p>
        <span>نام و نام خانوادگی :</span>
        <span><input type="text" name="fullname" placeholder="محمد محمدی"></span>
    </p>
    <p>
        <span>رایانامه :</span>
        <span><input type="text" name="email" placeholder="test@gmail.com"></span>
    </p>
    <p>
        <span>تلفن همراه :</span>
        <span><input type="text" name="mobile" placeholder="09123456789"></span>
    </p>
    <p>
        <span>مبلغ مورد نطر (ریال) : </span>
        <span><input type="text" name="amount" placeholder="20000"></span>
    </p>
    <p>
        <span>توضیحات :</span>
        <span><textarea name="description" placeholder="توضیحات  شما"></textarea></span>
    </p>
    <p>
        <span>پرداخت با درگاه :</span>
                <span>
                    <input type="radio" name="bank" value="faragate" id="faragate">
                    <label for="faragate">درگاه فرا گیت </label>
                    <input type="radio" name="bank" value="zarinpal" id="zarinpal" checked="">
                    <label for="zarinpal">درگاه زرین پال</label>
                </span>
    </p>
    <p style="text-align: center;">
        <?php wp_nonce_field('irdonate_payment','irdonate_nonce'); ?>
        <input type="submit" name="irdonateay_submit" value="پرداخت">
    </p>
</form>