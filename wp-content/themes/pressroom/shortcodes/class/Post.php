<?php
class Pr_Post
{
	public $blog_type;
	public $featured_post;
	public $is_review;
	public $post_format;
	public $featured_image_size;
	public $show_post_icon;
	public $show_post_date;
	public $show_post_categories;
	public $show_post_excerpt;
	public $show_post_author;
	public $post_details_layout;
	public $post_list_style;
	public $category_filter;
	public $i;
	public $themename;
	
	public function __construct($blog_type, $featured_post, $is_review, $post_format, $featured_image_size, $show_post_icon, $show_post_date, $show_post_categories, $show_post_excerpt, $show_post_author, $post_details_layout, $post_list_style, $category_filter, $i, $themename)
	{
		$this->blog_type = $blog_type;
		$this->featured_post = $featured_post;
		$this->is_review = $is_review;
		$this->post_format = $post_format;
		$this->featured_image_size = $featured_image_size;
		$this->show_post_icon = $show_post_icon;
		$this->show_post_date = $show_post_date;
		$this->show_post_categories = $show_post_categories;
		$this->show_post_excerpt = $show_post_excerpt;
		$this->show_post_author = $show_post_author;
		$this->post_details_layout = $post_details_layout;
		$this->post_list_style = $post_list_style;
		$this->category_filter = (array)$category_filter;
		$this->i = $i;
		$this->themename = $themename;
	}
	
	public function getLiCssClass()
	{
		$post_classes = get_post_class("post");
		$output = '<li class="' . ($this->featured_post!="-" && $this->i>0 && substr($this->post_list_style,0,6)=="simple" ? 'bullet style_' . substr($this->post_list_style, -1) : '');
		if(substr($this->post_list_style,0,6)!="simple" || $this->featured_post=="-" || $this->i==0)
			foreach($post_classes as $key=>$post_class)
				$output .= $post_class . ($key+1<count($post_classes) ? ' ' : '');
		$output .= '">';
	
		$output = '';
		$post_classes = get_post_class("post");
		$output .= '<li class="' . ($this->blog_type=="medium" && $this->featured_post!="-" && $this->i>0 && substr($this->post_list_style,0,6)=="simple" ? 'bullet style_' . substr($this->post_list_style, -1) : '');
		if($this->blog_type!="medium" || (substr($this->post_list_style,0,6)!="simple" || $this->featured_post=="-" || $this->i==0))
			foreach($post_classes as $key=>$post_class)
				$output .= $post_class . ($key+1<count($post_classes) ? ' ' : '');
		$output .= '">';
		return $output;
	}
	
	public function getThumbnail($default_image_size = null)
	{
		$output = '';
		if(has_post_thumbnail())
		{
			if($this->blog_type=="small")
				$output .= '<a class="post_image" href="' . get_permalink() . '" title="' . esc_attr(get_the_title()) . '">' . ($this->show_post_icon ? (($this->is_review=="percentage" || $this->is_review=="points") && $this->post_format!="video" && $this->post_format!="gallery" ? '<span class="icon small review"></span>' : '') . ($this->post_format=="video" || $this->post_format=="gallery" ? '<span class="icon' . ($this->featured_post!="-" && $this->i>0 ? ' small' : '') . ' ' . $this->post_format . '"></span>' : '') : '') . get_the_post_thumbnail(get_the_ID(), ($this->featured_image_size!="default" ? $this->featured_image_size : $this->themename . "-small-thumb"), array("alt" => get_the_title(), "title" => "")) . '</a>';	
			else
				$output .= '<a class="post_image" href="' . get_permalink() . '" title="' . esc_attr(get_the_title()) . '">' . ($this->show_post_icon ? (($this->is_review=="percentage" || $this->is_review=="points") && $this->post_format!="video" && $this->post_format!="gallery" ? ($this->featured_post!="-" && $this->i>0 ? '<span class="icon small review"></span>' : '<span class="icon"><span>' . get_post_meta(get_the_ID(), $this->themename . "_review_average", true) . ($this->is_review=="percentage" ? '%' : '') . '</span></span>') : '') . ($this->post_format=="video" || $this->post_format=="gallery" ? '<span class="icon' . ($this->featured_post!="-" && $this->i>0 ? ' small' : '') . ' ' . $this->post_format . '"></span>' : '') : '') . get_the_post_thumbnail(get_the_ID(), ($this->featured_image_size!="default" ? $this->featured_image_size : ($this->featured_post!="-" && $this->i>0 ? $this->themename . "-small-thumb" : $default_image_size)), array("alt" => get_the_title(), "title" => "")) . '</a>';
		}
		return $output;
	}
	
	public function getPostDetails()
	{
		$output = '';
		if($this->show_post_date || $this->show_post_categories)
		{
			$output .= '<ul class="post_details' . (($this->featured_post!="-" && $this->i>0 && $this->blog_type!="small") || $this->post_details_layout=="simple" ? ' simple' : '') . '">';
			if($this->show_post_categories)
			{
				$categories = get_the_category();
				$primary_category = get_post_meta(get_the_ID(), $this->themename. "_primary_category", true);
				$category_container_class = "category";
				if(isset($primary_category) && $primary_category!="-" && $primary_category!="")
				{
					$primary_category_object = get_category($primary_category);
					if(is_object($primary_category_object))
						$category_container_class .= ' container-category-' . $primary_category_object->term_id;
				}
				else if(count($categories)==1)
					$category_container_class .= ' container-category-' . $categories[0]->term_id;
			$output .= '<li class="' . esc_attr($category_container_class) . '">';
				if(isset($primary_category) && $primary_category!="-" && $primary_category!="" && is_object($primary_category_object))
				{
					$additional_categories = array();
					if(count($this->category_filter))
					{
						$found = false;
						$additional_categories = array();
						foreach($this->category_filter as $category_filter)
						{
							if($category_filter==$primary_category_object->slug)
							{
								$found = true;
								$additional_categories = array();
								break;
							}
							else
								$additional_categories[] = $category_filter;
						}
					}
					$output .= '<a class="category-' . $primary_category_object->term_id . '" href="' . get_category_link($primary_category) . '" ';
						if(empty($primary_category_object->description))
							$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $primary_category_object->name) . '"';
						else
							$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $primary_category_object->description, $primary_category_object))) . '"';
						$output .= '>' . $primary_category_object->name . '</a>';
					if(count($additional_categories))
					{
						foreach($categories as $key=>$category)
						{
							if(in_array($category->slug, $additional_categories))
							{
								$output .= ', <a class="category-' . $category->term_id . '" href="' . get_category_link($category->term_id) . '" ';
								if(empty($category->description))
									$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $category->name) . '"';
								else
									$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
								$output .= '>' . $category->name . '</a>';
							}
						}
					}
				}
				else
				{
					foreach($categories as $key=>$category)
					{
						$output .= '<a class="category-' . $category->term_id . '" href="' . get_category_link($category->term_id) . '" ';
						if(empty($category->description))
							$output .= 'title="' . sprintf(__('View all posts filed under %s', 'pressroom'), $category->name) . '"';
						else
							$output .= 'title="' . esc_attr(strip_tags(apply_filters('category_description', $category->description, $category))) . '"';
						$output .= '>' . $category->name . '</a>' . ($category != end($categories) ? ', ' : '');
					}
				}
			$output .= '</li>';
			}
			if($this->show_post_date)
			{
				$output .= '<li class="date' . (!$this->show_post_categories ? ' full_border' : '') . '">' . date_i18n(get_option('date_format'), get_post_time()) . '</li>';
			}
			$output .= '</ul>';
		}
		if($this->show_post_excerpt && (($this->featured_post=="-" || $this->i==0) || $this->blog_type=="small"))
			$output .= apply_filters('the_excerpt', get_the_excerpt());
		if($this->show_post_author)
			$output .= '<div class="author_row"><span class="author_by">' . __("By ", 'pressroom') . '</span><a class="author" href="' . get_author_posts_url(get_the_author_meta('ID')) . '" title="' . esc_attr(get_the_author()) . '">' . get_the_author() . '</a></div>';
		return $output;
	}
	
	public function getReviewAverage($post_id=null, $is_review=null, $themename=null)
	{
		if($post_id==null)
			$post_id = get_the_ID();
		if($is_review==null)
			$is_review = $this->is_review;
		if($themename==null)
			$themename = $this->themename;
		$review_average = false;
		if($is_review=="percentage" || $is_review=="points")
		{
			$review_label = get_post_meta($post_id, $themename. "_review_label", true);
			$review_value = get_post_meta($post_id, $themename. "_review_value", true);
			$review_details_count = count(array_values(array_filter((array)$review_label)));
			$review_sum = 0;
			for($j=0; $j<$review_details_count; $j++)
				$review_sum += $review_value[$j];
			if($review_details_count)
				$review_average = round($review_sum/$review_details_count, 1);
			else
				$review_average = 0;
		}
		return $review_average;
	}
}