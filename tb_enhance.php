<?php
/*
Plugin Name: TB Enhance
Plugin URI: http://www.akm3.de/
Description: This plugin evaluates a hook in the Textbroker Wordpress plugin to automatically highlight the SEO-keywords as bold and push them to All-in-One SEO post_meta entry 
Version: 0.1
Author: AKM3
Author URI: http://www.akm3.de/

This plugin evaluates a hook in the Textbroker Wordpress plugin to automatically highlight the SEO-keywords as bold and push them to All-in-One SEO post_meta entry 
*/    
        add_filter("textbroker_publish_post", 'textbroker_publish_post_func',10,3);
        
        function textbroker_publish_post_func($postTitle, $postContent, $postType) {
        
 
          $postContent = preg_replace('#</span>#Uui','</strong>' , $postContent);  
          
          
          $postContent = preg_replace('#<span[^>]*>#Uui','<strong>' , $postContent);
          
          $postStatus = 'draft';
        
          return array(
            $postTitle,
            $postContent,
            $postStatus,
            $postType
          );
        }
        
        add_filter("textbroker_add_keywords", 'textbroker_add_keywords_func',10,3);
        
        function textbroker_add_keywords_func($postID, $postContent) {
        
          global $wpdb;
        
 
          preg_match_all('#<strong>(.*)</strong>#Uui', $postContent, $keywords);
          
          
          $metakey	= "_aioseop_keywords";
          $metavalue	= implode(',', array_unique($keywords[1]));
          
          $wpdb->query( 
            $wpdb->prepare( 
          	  '
          		  INSERT INTO '. $wpdb->postmeta .'
          		  ( post_id, meta_key, meta_value )
          		  VALUES ( %d, %s, %s )
          	  ', 
              $postID, 
          	  $metakey, 
          	  $metavalue  
            ) 
          );
          
        }        
        
        
        
        
        
        
        
        