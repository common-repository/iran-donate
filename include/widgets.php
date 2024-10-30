<?php
class wps_widget extends WP_Widget {

function __construct() {
parent::__construct(
'ezp_form_wight',

__('فرم پرداخت', 'ezp_form_wight'),

array( 'description' => __( 'نمایش فرم پرداخت به کاربران جهت حمایت از سایت شما', 'ezp_form_wight' ), )
);
}

public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
$description=  $instance['description'] ;
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

    echo '<p>'.$description.'</p>';
    include IRDONATE_TPL_DIR.'html-user-form.php';


echo $args['after_widget'];
}


public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
$description= $instance[ 'description' ];

}
else {
$title = __( 'عنوان جدید', 'wps_widget_domain' );
}

?>
<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>">عنوان فرم پداخت :</label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    <label for="<?php echo $this->get_field_id( 'description' ); ?>">توضیحات دلخواه شما :</label>
    <textarea style="height: 100px;" class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>">
    <?php echo  $description ; ?>
    </textarea>
</p>
<?php
}

public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance[ 'description' ] = ( ! empty( $new_instance['description'] ) ) ?  $new_instance['description']  : '';
    return $instance;
}
} // Class wps_widget ends here

function wps_load_widget() {
    register_widget( 'wps_widget' );
}
add_action( 'widgets_init', 'wps_load_widget' );