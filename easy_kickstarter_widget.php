<?php
/*
Plugin Name: Easy Kickstarter Widget
Plugin URI: http://www.marijnrongen.com/wordpress-plugins/easy-kickstarter-widget/
Description: Easily place a Kickstarter widget on your WordPress blog.
Version: 1.0
Author: Marijn Rongen
Author URI: http://www.marijnrongen.com
*/

class MR_Kickstarter_Widget extends WP_Widget {
	function MR_Kickstarter_Widget() {
		$widget_ops = array( 'classname' => 'MR_Kickstarter_Widget', 'description' => 'Easily place a Kickstarter widget on your WordPress blog.' );
		$control_ops = array( 'id_base' => 'mr-kickstarter-widget' );
		$this->WP_Widget( 'mr-kickstarter-widget', 'Easy Kickstarter Widget', $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance) {
		extract( $args );
		$layout = empty($instance['layout']) ? 'horizontal' : $instance['layout'];
		if (!empty($instance['url'])) {
			echo $before_widget;
			echo '<iframe frameborder="0" height="380px" src="http://www.kickstarter.com/projects/'.$instance['url'].'/widget/card.html" width="220px"></iframe>';
			echo $after_widget;
		}
	}
	
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$url = strip_tags($new_instance['url']);
		$parts = array('http://','www.','kickstarter.com/','projects/','/widget','/card.html');
		$repl = array('', '', '', '', '', '');
		$url = str_replace($parts, $repl, $url);
		$instance['url'] = $url;
		return $instance;
	}
	
	function form($instance) {
		$instance = wp_parse_args((array) $instance, array( 'url' => ''));
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'url' ); ?>">Kickstarter project URL:<br/>(You can omit &quot;http://www.kickstarter.com/projects/&quot;)</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" value="<?php echo $instance['url']; ?>" />
		</p>	
		<?php
	}
}
add_action('widgets_init', create_function('', 'return register_widget("MR_Kickstarter_Widget");'));
?>