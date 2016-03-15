<?php
/**
 * Plugin Name: SiteAPI
 * Plugin URI: http://dev.phlgo.com
 * Author: JaeHo Song
 * Description: SiteAPI for Communication of Websites.
 * Version: 0.0.2
 */


if ( ! function_exists('di') ) {
    function di($o) {
        $re = print_r($o, true);
        $re = str_replace(" ", "&nbsp;", $re);
        $re = explode("\n", $re);
        echo implode("<br>", $re);
    }
}

if ( ! function_exists('segment') ) {
    function segments($n = NULL) {
        $u = strtolower(site_url());
        $u = str_replace("http://", '', $u);
        $u = str_replace("https://", '', $u);
        $r = strtolower($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        $uri = str_replace( "$u/", '', $r);
        $re = explode('/', $uri);
        if ( $n !== NULL ) return $re[$n];
        else return $re;
    }
    function segment($n) {
        return segments($n);
    }
}

if ( segment(0) == 'siteapi' ) {
    if ( segment(1) == 'info' ) {
        $data = [];
        $data['name'] = get_bloginfo('name');
        $data['description'] = get_bloginfo('description');
        if ( has_site_icon() ) {
            $data['site_icon'] =  get_site_icon_url();
        }
        wp_send_json( $data );
    }
}

