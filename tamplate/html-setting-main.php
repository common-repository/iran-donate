<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap">

    <h2><?php _e('تنظیمات', 'irdonate');
        ?></h2>
		 جهت نمایش فرم پرداخت از شورت کد [irdonateay_form] استفاده نمایید.
    <h2 class="nav-tab-wrapper">
        <?php foreach ($tabs as $tab => $title):
            $class = ($tab == $current_tab) ? 'nav-tab-active' : '';
            echo "<a class='nav-tab $class' href='?page=irdonate_setting&tab=$tab'>$title</a>";
        endforeach; ?>
    </h2>
    <form action="" method="POST">

        <table class="form-table">

            <?php switch ($current_tab) {

                case 'general';

                    ?>

                    <tr valign="top">
                        <th scope="row">فعال بودن فرم پرداخت :</th>
                        <td>
                            <input type="checkbox"
                                   name="irdonate_active" <?php echo intval(get_option('irdonate_active')) ? 'checked' : ''; ?>/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">شماره همراه مدیر وب سایت :</th>
                        <td>
                            <input type="text" name="irdonate_admin_mobile"
                                   value="<?php echo get_option('irdonate_admin_mobile'); ?>"/>
                        </td>
                    </tr>
                    <?php break;
                case 'banks';
                    ?>
						<tr valign="top">
                        <th scope="row">جهت نمایش فرم پرداخت از شورت کد [irdonateay_form] استفاده نمایید.</th>
                    </tr>
                    <tr valign="top">
                        <th scope="row">مرچنت کد زرین پال :</th>
                        <td>
                            <input type="text" name="irdonate_zarinpal_username"
                                   value="<?php echo get_option('irdonate_zarinpal_username'); ?>"/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">مرچنت کد فرا گیت :</th>
                        <td>
                            <input type="text" name="irdonate_faragatepal_username"
                                   value="<?php echo get_option('irdonate_faragatepal_username'); ?>"/>
                        </td>
                    </tr>


                    <?php break;
                case 'massage';
                    ?>
                    <tr>
                        <td colspan="2">
                            <h2>تنظیمات فرا پیامک</h2>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">نام کاربری</th>
                        <td>
                            <input type="text" name="irdonate_fp_username" value="<?php echo get_option('irdonate_fp_username'); ?>"/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">کلمه عبور </th>
                        <td>
                            <input type="text" name="irdonate_fp_password" value="<?php echo get_option('irdonate_fp_password'); ?>"/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">شماره پنل</th>
                        <td>
                            <input type="text" name="irdonate_fp_from" value="<?php echo get_option('irdonate_fp_from'); ?>"/>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">متن پیام بعد از پرداخت کاربر : </th>
                        <td>
                            <textarea style="width: 300px;height: 150px;" name="irdonate_massage_tpl"><?php echo get_option('irdonate_massage_tpl'); ?></textarea>

                            <p>
                                <?php foreach ($massage_tpl as $key=>$value): ?>
                                   <small> <?php echo $value.' : '.$key;?></small>
                                <?php endforeach;?>
                            </p>

                        </td>
                    </tr>
                    <?php break;
            } ?>
        </table>
        <?php wp_nonce_field('save_irdonate_setting', 'irdonate_nonce'); ?>
        <?php submit_button('ذخیره تنظیمات'); ?>

    </form>
</div>