<?php

/**
 * Sets the body-tag class attribute.
 *
 * Adds 'sidebar-left', 'sidebar-right' or 'sidebars' classes as needed.
 */
function phptemplate_body_class($left, $right) {
  if ($left != '' && $right != '') {
    $class = 'sidebars';
  }
  else {
    if ($left != '') {
      $class = 'sidebar-left';
    }
    if ($right != '') {
      $class = 'sidebar-right';
    }
  }

  if (isset($class)) {
    print ' class="'. $class .'"';
  }
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */
function phptemplate_breadcrumb($breadcrumb) {
  if (!empty($breadcrumb)) {
    return '<div class="breadcrumb">'. implode(' › ', $breadcrumb) .'</div>';
  }
}

/**
 * Override or insert PHPTemplate variables into the templates.
 */
function phptemplate_preprocess_page(&$vars) {
  $vars['tabs2'] = menu_secondary_local_tasks();

  // Hook into color.module
  if (module_exists('color')) {
    _color_page_alter($vars);
  }
}
function vp_preprocess_page(&$vars) {
if  ($node = menu_get_object()) {
    $vars['node'] = $node;
    $suggestions = array();
    $template_filename = 'page';
    $template_filename = $template_filename . '-' . $vars['node']->type;
    $suggestions[] = $template_filename;
    $vars['template_files'] = $suggestions;
   }
}
/**
 * Add a "Comments" heading above comments except on forum pages.
 */
function garland_preprocess_comment_wrapper(&$vars) {
  if ($vars['content'] && $vars['node']->type != 'forum') {
    $vars['content'] = '<h2 class="comments">'. t('Comments') .'</h2>'.  $vars['content'];
  }
}

/**
 * Returns the rendered local tasks. The default implementation renders
 * them as tabs. Overridden to split the secondary tasks.
 *
 * @ingroup themeable
 */
function phptemplate_menu_local_tasks() {
  return menu_primary_local_tasks();
}

/**
 * Returns the themed submitted-by string for the comment.
 */
function phptemplate_comment_submitted($comment) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

/**
 * Returns the themed submitted-by string for the node.
 */
function phptemplate_node_submitted($node) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}

/**
 * Generates IE CSS links for LTR and RTL languages.
 */
function phptemplate_get_ie_styles() {
  global $language;

  $iecss = '<link type="text/css" rel="stylesheet" media="all" href="'. base_path() . path_to_theme() .'/fix-ie.css" />';
  if ($language->direction == LANGUAGE_RTL) {
    $iecss .= '<style type="text/css" media="all">@import "'. base_path() . path_to_theme() .'/fix-ie-rtl.css";</style>';
  }

  return $iecss;
}
////////////////////add by dale
/*
 * theme_form_element() 
 * */
function vp_form_element($element, $value) {//dpm($element,'$element');dpm($value,'$value');
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  $output = '<div class="form-item"';
  if (!empty($element['#id'])) {
    $output .= ' id="' . $element['#id'] . '-wrapper"';
  }
  $output .= ">\n";
  $required = !empty($element['#required']) ? '<span class="form-required" title="' . $t('This field is required.') . '">*</span>' : '';

  if (!empty($element['#title'])) {
    $title = $element['#title'];
    if (!empty($element['#id'])) {
      $output .= ' <label for="' . $element['#id'] . '">' . $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) . "</label>\n";
    }
    else {
      $output .= ' <label>' . $t('!title: !required', array('!title' => filter_xss_admin($title), '!required' => $required)) . "</label>\n";
    }
  }
	if (!empty($element['#description'])&&$element['#name']=='title') {
	    $output .= ' <div class="description">' . $element['#description'] . "</div>\n";
	  }

  $output .= " $value\n";
	if (!empty($element['#description'])&& ($element['#name']!='title')) {
	    $output .= ' <div class="description">' . $element['#description'] . "</div>\n";
	}
  
  $output .= "</div>\n";

  return $output;
}

function vp_plus1_widget($node, $score = 0, $logged_in = FALSE, $is_author = FALSE, $voted = FALSE, $teaser = FALSE, $page = TRUE) {
  static $javascript_added = FALSE;

  // Defining CSS hooks to be used in the JavaScript.
  $widget_class = check_plain(variable_get('plus1_widget_class', 'plus1-widget'));
  $link_class = check_plain(variable_get('plus1_link_class', 'plus1-link'));
  $message_class = check_plain(variable_get('plus1_msg_class', 'plus1-msg'));
  $score_class = check_plain(variable_get('plus1_score_class', 'plus1-score'));
  $vote_class = 'plus1-vote-class';  // Is this used any more?

  if (!$javascript_added) {
    // Load the JavaScript and CSS files.
    // You are free to load your own JavaScript files in your theming function to override.
    drupal_add_js(drupal_get_path('module', 'plus1') . '/jquery.plus1.js');
    drupal_add_css(drupal_get_path('module', 'plus1') . '/plus1.css');

    // Attaching these hooks names to the Drupal.settings.plus1 JavaScript object.
    // So these class names are NOT hard-coded in the JavaScript.
    drupal_add_js(array('plus1' => array('widget_class' => $widget_class, 'vote_class' => $vote_class, 'message_class' => $message_class, 'score_class' => $score_class)), 'setting');

    $javascript_added = TRUE;
  }

  // And now we output the HTML.
  $output_content = '';
  if (!$logged_in && !user_access('vote on content')) {
    if ($login_text = variable_get('plus1_login_to_vote', 'Log in to vote')) {
      $output_content .= l(t($login_text), 'user', array('html' => TRUE, 'query' => drupal_get_destination()));
     }
  }
  elseif ($voted) { // User already voted.
    if ($voted_text = variable_get('plus1_you_voted', 'You voted')) {
      $output_content .= check_plain(t(filter_xss_admin($voted_text)));
    }
  }
  elseif (user_access('vote on content')) {
    // Is this the user's own content and do we allow them to vote on it?
    if (1) {//$is_author && variable_get('plus1_vote_on_own', 1) //dale 2011/12/8 dpm(__FILE__.__LINE__,'needto2');
      if ($vote_text = variable_get('plus1_vote', 'Vote')) {
        // User is eligible to vote.
        // The class name provided by Drupal.settings.plus1.vote_class what
        // we will search for in our jQuery later.
        $output_content .= '<form class="' . $vote_class . '" action="'
          . url("plus1/vote/$node->nid",
            array('query' => 'token=' . drupal_get_token($node->nid) . '&' . drupal_get_destination()))
          . '" method="post"><div>';

        $output_content .= '<button type="submit"><span>' . t(filter_xss_admin($vote_text)) . '</span></button>';

        $author_text = variable_get('plus1_author_text', 'Your content');
        if ($author_text) {
          $output_content .= '<div class="plus1-author-text">' . t(filter_xss_admin($author_text)) . '</div>';
        }

        $output_content .= '</div></form>';
      }
    }
  }

  if ($output_content) {
    $output_content = '<div class="' . $message_class . '">' . $output_content . '</div>';
  }

  $output = '<div class="' . $widget_class . '">';
  $output .= '<div class="' . $score_class . '">' . $score . '</div>';
  $output .= $output_content;
  $output .= '</div>';
  return $output;
}

/*function vp_phptemplate_user_register($form) {
  return _phptemplate_callback('user-register', array('form' => $form));
}*/
/**
 * Theme to display the privatemsg list.
 *
 * This theme builds a table with paging based on the data which has been built
 * by the header and field theme patterns.
 */
function vp_privatemsg_list($form) {
  $has_posts = !empty($form['#data']);

  drupal_add_css(drupal_get_path('module', 'privatemsg') .'/styles/privatemsg-list.css');

  // Load the table columns.
  $columns = array_merge(array('subject', 'last_updated'), array_filter(variable_get('privatemsg_display_fields', array('participants'))));

  // Load the themed list headers based on the available data.
  $headers = _privatemsg_list_headers(!empty($form['#data']), $columns);
  // sort the headers array based on the #weight property.

  usort($headers, 'element_sort');

  $themed_rows = array();
  // Check if there is atleast a single thread.
  if ($has_posts) {
  	$output = '';
    foreach ($form['#data'] as $thread_id => $data) {
      // Theme the row.
      $row = _privatemsg_list_thread($data);
			///////
			$participants =explode(',', $data['participants']);
			$participant =$participants['1'];//admin, 郭向科 取第二个
			global $user;
			if($participant==$user->uid)$participant =$participants['0'];
			$participant_user = user_load($participant);
			$thread_id=$data['thread_id'];
			$is_new=$data['is_new'];
			//谁发起的私信？
			$sql = 'select pm.author uid from {pm_message} pm
			INNER JOIN pm_index pi ON pm.mid = pi.mid
			where  pi.mid=%d limit 0,1';
			global $user;
			$who_send=(db_result(db_query($sql,$thread_id))==$participant)?1:$user;
			//发起人如果是参与的第二个人，else是自己。
			//如果没有标题？不可能～！我把正文隐藏，必须有标题，回复私信时用body
			//共计N/2条私信？
			$sql = 'select count(*) from pm_message pm
			INNER JOIN pm_index pi ON pm.mid = pi.mid
			where  pi.thread_id	=%d';
			$pm_counts =db_result(db_query($sql,$thread_id))/2;
			$output.='<div class="pm-message">
				<div class="pm-message-picture"> '.
				l(theme('imagecache', 'small_picture', $participant_user->picture, $participant_user->name, $participant_user->name, array('class'=>'pm-message-picture-img')),"UCenter/0/$participant_user->uid",array('html'=>TRUE,'attributes'=>array('class'=>'pm-message-picture-link')))
				.'</div>
				<div class="pm-message-content">
					<span class="pm-message-who">'.(is_object($who_send)?'发给 ':'').l($participant_user->name,"UCenter/0/$participant_user->uid").'：</span>
					<span class="pm-message-text">'.l($data['subject'],'messages/view_vp/'.$thread_id).'</span>'.($is_new?'<span class="marker">新</span>':'').'
					<div class="pm-message-info">
						<span class="pm-message-time">'.date("Y-m-d  H:i",$data['last_updated']).'</span>
						<span class="pm-message-option">'.l('共'.$pm_counts.'条私信','messages/view_vp/'.$thread_id).'|'.l('回复',"messages/view_vp/$thread_id",array('fragment'=>'privatemsg-new')).'</span>
					</div>
				</div>
			</div>';			

      $data = array();
      // Render the checkbox.
      $data[] = array('data' => drupal_render($form['threads'][$thread_id]), 'class' => 'privatemsg-list-select');

      // Store the #rows data in the same order as the header is, the key property of the header refers to the field that belongs to it.
      foreach ($headers as $header) {
        if (!empty($header['key'])) {
          if (isset($row['data'][$header['key']])) {
            $data[] = $row['data'][$header['key']];
          }
          else {
            // Store a empty value so that the order is still correct.
            $data[] = '';
          }
        }
      }
      // Replace the data
      $row['data'] = $data;
      $themed_rows[] = $row;
    }
  }
  else {
    // Display a message if now messages are available.
    $themed_rows[] = array(array('data' => t('No messages available.'), 'colspan' => count($headers)));
  }

  // Remove any data in header that we don't need anymore.
  

  // Theme the table, pass all generated information to the table theme function.
  $form['list'] = array('#value' => theme('table', $headers, $themed_rows, array('class' => 'privatemsg-list')), '#weight' => 5);
  return $output;//drupal_render($form).
}
