<?php
class Top_Walker_Nav_Menu extends Walker_Nav_Menu
{


    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
	{
		$menu_item = $data_object;

		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ($depth) ? str_repeat($t, $depth) : '';

		$classes   = empty($menu_item->classes) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;

		$args = apply_filters('nav_menu_item_args', $args, $menu_item, $depth);

		$class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $menu_item, $args, $depth));

		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth);

		$li_atts          = array();
		$li_atts['id']    = !empty($id) ? $id : '';
		$li_atts['class'] = !empty($class_names) ? $class_names : '';
		$li_atts['class'] .= ' nav_item';

		$li_atts       = apply_filters('nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth);
		$li_attributes = $this->build_atts($li_atts);

		$output .= $indent . '<li' . $li_attributes . '>';

		$atts           = array();
		$atts['title']  = !empty($menu_item->attr_title) ? $menu_item->attr_title : '';
		$atts['target'] = !empty($menu_item->target) ? $menu_item->target : '';
		if ('_blank' === $menu_item->target && empty($menu_item->xfn)) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}

		if (!empty($menu_item->url)) {
			if (get_privacy_policy_url() === $menu_item->url) {
				$atts['rel'] = empty($atts['rel']) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
			}

			$atts['href'] = $menu_item->url;
		} else {
			$atts['href'] = '';
		}

		$atts['aria-current'] = $menu_item->current ? 'page' : '';

		$atts       = apply_filters('nav_menu_link_attributes', $atts, $menu_item, $args, $depth);
		$attributes = $this->build_atts($atts);

		$title = apply_filters('the_title', $menu_item->title, $menu_item->ID);

		$title = apply_filters('nav_menu_item_title', $title, $menu_item, $args, $depth);


        $class_admin_arr = $menu_item->classes;
		//$class_admin = implode(" ", ($menu_item->classes) ? $menu_item->classes : []);
		//$menu_item_classes = [$menu_item->classes];
		$class_admin = implode(" ", $class_admin_arr );
		$class_admin = mb_substr($class_admin, 0, mb_strpos($class_admin, ' menu-item '));
		
		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
        $item_output .= "{$args->link_before}
		<div class='nav_img'><span class='top_{$class_admin}'></span></div>
		<span class='nav_title'>{$title}</span>{$args->link_after}";
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args);
	}
}


class Submenu_Top_Walker_Nav_Menu extends Walker_Nav_Menu
{

	public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
	{
		$menu_item = $data_object;

		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ($depth) ? str_repeat($t, $depth) : '';

		$classes   = empty($menu_item->classes) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;

		$args = apply_filters('nav_menu_item_args', $args, $menu_item, $depth);

		$class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $menu_item, $args, $depth));

		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth);

		$li_atts          = array();
		$li_atts['id']    = !empty($id) ? $id : '';
		$li_atts['class'] = !empty($class_names) ? $class_names : '';
		$li_atts['class'] .= ' submenu_top_item';

		$li_atts       = apply_filters('nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth);
		$li_attributes = $this->build_atts($li_atts);

		$output .= $indent . '<li' . $li_attributes . '>';

		$atts           = array();
		$atts['title']  = !empty($menu_item->attr_title) ? $menu_item->attr_title : '';
		$atts['target'] = !empty($menu_item->target) ? $menu_item->target : '';
		if ('_blank' === $menu_item->target && empty($menu_item->xfn)) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}

		if (!empty($menu_item->url)) {
			if (get_privacy_policy_url() === $menu_item->url) {
				$atts['rel'] = empty($atts['rel']) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
			}

			$atts['href'] = $menu_item->url;
		} else {
			$atts['href'] = '';
		}

		$atts['aria-current'] = $menu_item->current ? 'page' : '';

		$atts       = apply_filters('nav_menu_link_attributes', $atts, $menu_item, $args, $depth);
		$attributes = $this->build_atts($atts);

		$title = apply_filters('the_title', $menu_item->title, $menu_item->ID);

		$title = apply_filters('nav_menu_item_title', $title, $menu_item, $args, $depth);


        $class_admin_arr = $menu_item->classes;
		//$class_admin = implode(" ", ($menu_item->classes) ? $menu_item->classes : []);
		//$menu_item_classes = [$menu_item->classes];
		$class_admin = implode(" ", $class_admin_arr );
		$class_admin = mb_substr($class_admin, 0, mb_strpos($class_admin, ' menu-item '));

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= "{$args->link_before}
		<div class='submenu_top_img'><span class='sub_top_{$class_admin} pirog'></span></div>
		<p class='submenu_top_title'>{$title}</p>{$args->link_after}";
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args);
	}
}
class Submenu_Bottom_Walker_Nav_Menu extends Walker_Nav_Menu
{

	public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
	{
		$menu_item = $data_object;

		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ($depth) ? str_repeat($t, $depth) : '';

		$classes   = empty($menu_item->classes) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;

		$args = apply_filters('nav_menu_item_args', $args, $menu_item, $depth);

		$class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $menu_item, $args, $depth));

		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth);

		$li_atts          = array();
		$li_atts['id']    = !empty($id) ? $id : '';
		$li_atts['class'] = !empty($class_names) ? $class_names : '';
		$li_atts['class'] .= ' submenu_bottom_item';

		$li_atts       = apply_filters('nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth);
		$li_attributes = $this->build_atts($li_atts);

		$output .= $indent . '<li' . $li_attributes . '>';

		$atts           = array();
		$atts['title']  = !empty($menu_item->attr_title) ? $menu_item->attr_title : '';
		$atts['target'] = !empty($menu_item->target) ? $menu_item->target : '';
		if ('_blank' === $menu_item->target && empty($menu_item->xfn)) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}

		if (!empty($menu_item->url)) {
			if (get_privacy_policy_url() === $menu_item->url) {
				$atts['rel'] = empty($atts['rel']) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
			}

			$atts['href'] = $menu_item->url;
		} else {
			$atts['href'] = '';
		}

		$atts['aria-current'] = $menu_item->current ? 'page' : '';

		$atts       = apply_filters('nav_menu_link_attributes', $atts, $menu_item, $args, $depth);
		$attributes = $this->build_atts($atts);

		$title = apply_filters('the_title', $menu_item->title, $menu_item->ID);

		$title = apply_filters('nav_menu_item_title', $title, $menu_item, $args, $depth);

        $class_admin_arr = $menu_item->classes;
		//$class_admin = implode(" ", ($menu_item->classes) ? $menu_item->classes : []);
		//$menu_item_classes = [$menu_item->classes];
		$class_admin = implode(" ", $class_admin_arr );
		$class_admin = mb_substr($class_admin, 0, mb_strpos($class_admin, ' menu-item '));

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= "{$args->link_before}
		<span class='submenu_bottom sub_bottom_{$class_admin}'></span>{$args->link_after}";
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args);
	}
}
class Footer_Menu_Walker_Nav_Menu extends Walker_Nav_Menu
{

	public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
	{
		$menu_item = $data_object;

		if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ($depth) ? str_repeat($t, $depth) : '';

		$classes   = empty($menu_item->classes) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;

		$args = apply_filters('nav_menu_item_args', $args, $menu_item, $depth);

		$class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $menu_item, $args, $depth));

		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth);

		$li_atts          = array();
		$li_atts['id']    = !empty($id) ? $id : '';
		$li_atts['class'] = !empty($class_names) ? $class_names : '';

		$li_atts       = apply_filters('nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth);
		$li_attributes = $this->build_atts($li_atts);

		$output .= $indent . '<li' . $li_attributes . '>';

		$atts           = array();
		$atts['title']  = !empty($menu_item->attr_title) ? $menu_item->attr_title : '';
		$atts['target'] = !empty($menu_item->target) ? $menu_item->target : '';
		if ('_blank' === $menu_item->target && empty($menu_item->xfn)) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}

		if (!empty($menu_item->url)) {
			if (get_privacy_policy_url() === $menu_item->url) {
				$atts['rel'] = empty($atts['rel']) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
			}

			$atts['href'] = $menu_item->url;
		} else {
			$atts['href'] = '';
		}

		$atts['aria-current'] = $menu_item->current ? 'page' : '';

		$atts       = apply_filters('nav_menu_link_attributes', $atts, $menu_item, $args, $depth);
		$attributes = $this->build_atts($atts);

		$title = apply_filters('the_title', $menu_item->title, $menu_item->ID);

		$title = apply_filters('nav_menu_item_title', $title, $menu_item, $args, $depth);

		$item_output  = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= "{$args->link_before}
		<span class='pie_img'></span><span>{$title}</span>{$args->link_after}";
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args);
	}
}