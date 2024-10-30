<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="wrap">

    <h2><?php _e('مدیریت پرداخت ها', 'irdonate'); ?></h2>
    <?php if($has_error): ?>
        <div class="error">
            <p>
                <?php echo $massage;?>
            </p>
        </div>
    <?php elseif($success): ?>
        <div class="updated">
            <p>
                <?php echo $massage;?>
            </p>
        </div>
    <?php endif; ?>
    <table class="wp-list-table widefat fixed paymants">
        <thead>
        <tr>
            <th scope="col" id="cd" class="manage-column column-cb check-column">
                <input id="cb-select-all-1" type="checkbox">
            </th>
            <th scope="col" id="title" class="manage-column">بانک</th>
            <th scope="col" id="title" class="manage-column">نام و نام خانوادگی</th>
            <th scope="col" id="title" class="manage-column">ایمیل</th>
            <th scope="col" id="title" class="manage-column">موبایل</th>
            <th scope="col" id="title" class="manage-column">توضیحات</th>
            <th scope="col" id="title" class="manage-column">مبلغ</th>
            <th scope="col" id="title" class="manage-column">شناسه سفارش</th>
            <th scope="col" id="title" class="manage-column">شماره ارجاع</th>
            <th scope="col" id="title" class="manage-column">تاریخ</th>
            <th scope="col" id="title" class="manage-column">وضعیت</th>
            <th scope="col" id="title" class="manage-column">عملیات</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th scope="col" id="cd" class="manage-column column-cb check-column">
                <input id="cb-select-all-1" type="checkbox">
            </th>
            <th scope="col" id="title" class="manage-column">بانک</th>
            <th scope="col" id="title" class="manage-column">نام و نام خانوادگی</th>
            <th scope="col" id="title" class="manage-column">ایمیل</th>
            <th scope="col" id="title" class="manage-column">موبایل</th>
            <th scope="col" id="title" class="manage-column">توضیحات</th>
            <th scope="col" id="title" class="manage-column">مبلغ</th>
            <th scope="col" id="title" class="manage-column">شناسه سفارش</th>
            <th scope="col" id="title" class="manage-column">شماره ارجاع</th>
            <th scope="col" id="title" class="manage-column">تاریخ</th>
            <th scope="col" id="title" class="manage-column">وضعیت</th>
            <th scope="col" id="title" class="manage-column">عملیات</th>
        </tr>
        </tr>
        </tfoot>
        <tbody id="the-list">
        <?php if (count($all_payments) > 0): ?>
            <?php foreach ($all_payments as $pay): ?>
                <tr>
                    <th scope="row" class="check-column">
                        <label class="screen-reader-text" for="cb-select-<?php echo $pay->ID; ?>"></label>
                        <input id="cb-select-<?php echo $pay->ID; ?>" type="checkbox" name="selected[]"
                               value="<?php echo $pay->ID; ?>">
                    </th>
                    <td><?php echo $pay->bank; ?></td>
                    <td><?php echo $pay->name; ?></td>
                    <td><?php echo $pay->email; ?></td>
                    <td><?php echo $pay->mobile; ?></td>
                    <td><?php echo $pay->description; ?></td>
                    <td><?php echo $pay->amount; ?></td>
                    <td><?php echo $pay->order_id; ?></td>
                    <td><?php echo $pay->ref_id; ?></td>
                    <td><?php echo jdate("y/m/d",$pay->date); ?></td>
                    <td><?php echo irdonate_get_status($pay->status); ?></td>
                    <td>
                        <a title="خذف کردن این پرداخت" href="<?php echo admin_url('admin.php?page=irdonate_main&action=delete&item_id='.$pay->ID); ?>"><span class="dashicons dashicons-trash"></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>
            <tr class="no-items">
                <td class="colspanchange" colspan="4">هیچ موردی یافت نشد!</td>
            </tr>
        <?php endif; ?>

        </tbody>
    </table>

</div>