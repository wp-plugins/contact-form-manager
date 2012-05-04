<?php

function cfm_install(){
	
	global $wpdb;
	
	add_option("xyz_cfm_paging_limit",20);
	add_option("xyz_cfm_tinymce_filter",1);
	add_option("xyz_cfm_mandatory_sign",1);
	add_option("xyz_cfm_credit_link",1);
	
	$queryForm = "CREATE TABLE IF NOT EXISTS `xyz_cfm_form` (
	  `id` int(20) NOT NULL AUTO_INCREMENT,
	  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `status` int(1) NOT NULL,
	  `form_content` longtext COLLATE utf8_unicode_ci NOT NULL,
	  `submit_mode` int(1) NOT NULL,
	  `to_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `from_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `sender_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `reply_sender_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `reply_sender_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `cc_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `mail_type` int(1) NOT NULL,
	  `mail_subject` text COLLATE utf8_unicode_ci NOT NULL,
	  `mail_body` longtext COLLATE utf8_unicode_ci NOT NULL,
	  `to_email_reply` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `reply_subject` text COLLATE utf8_unicode_ci NOT NULL,
	  `reply_body` longtext COLLATE utf8_unicode_ci NOT NULL,
	  `reply_mail_type` int(1) NOT NULL,
	  `enable_reply` int(1) NOT NULL,
	  `redirection_link` text COLLATE utf8_unicode_ci NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ";
	$wpdb->query($queryForm);
	
	$queryFormElements = "CREATE TABLE IF NOT EXISTS `xyz_cfm_form_elements` (
	  `id` int(20) NOT NULL AUTO_INCREMENT,
	  `form_id` int(11) NOT NULL,
	  `element_diplay_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `element_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `element_type` int(1) NOT NULL,
	  `element_required` int(1) NOT NULL,
	  `css_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `max_length` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
	  `default_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
	  `cols` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
	  `rows` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
	  `options` longtext COLLATE utf8_unicode_ci NOT NULL,
	  `file_size` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
	  `file_type` text COLLATE utf8_unicode_ci NOT NULL,
	  `re_captcha` int(1) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 " ;
	$wpdb->query($queryFormElements);
	
}