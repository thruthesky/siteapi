<?php
/**
 * Plugin Name: SiteAPI
 * Plugin URI: http://dev.phlgo.com
 * Author: JaeHo Song
 * Description: SiteAPI for Family Sites.
 * Version: 0.0.2
 */
include plugin_dir_path(__FILE__) . '/wp-include/library.php';

/**
 * @brief /siteapi/info 정보 추출
 */
if ( segment(0) == 'siteapi' ) {
    if ( segment(1) == 'info' ) {
        $data = [];
        $data['name'] = get_bloginfo('name');
        $option = get_option( '_option' );

        $desc = esc_attr($option['site_description']);
        if ( $desc ) $data['site_description'] = $desc;
        else $data['site_description'] = get_bloginfo('description');

        $photo = esc_attr($option['site_photo']);
        if ( $photo ) $data['site_photo'] = $photo;
        else if ( has_site_icon() ) {
            $data['site_photo'] =  get_site_icon_url();
        }

        wp_send_json( $data );
    }
}



add_action( 'admin_init', function() {
    /**
     * 아래에서
     * 첫번째 파라메타 siteapi 는 영역이다. 주의: 이 값은 settings_fields() 에 사용되는 값과 동일해야 한다. 그렇지 않으면 "Error: options page not found." 가 발생한다.
     * 두번째 파라메타 siteapi 는 변수명이다.
     * 즉, siteapi 영역에 siteapi 라는 변수명으로 값을 저장한다.
     * 편의를 위해서 변수는 배열로 저정한다.
     * 즉, HTML FORM 에서 name="siteapi[description]", name="siteapi[no]" 와 같이 지정하면
     * 추가적인 register_setting 을 하지 않아도 전체 값이 하나의 siteapi 배열에 저장된다.
     */
    register_setting( 'siteapi', '_option' );
});
add_action( 'wp_before_admin_bar_render', function () {
    global $wp_admin_bar; // 관리자 툴바
    $wp_admin_bar->add_menu( array(
        'id' => 'siteapi_toolbar',
        'title' => '패밀리사이트',
        'href' => home_url('wp-admin/admin.php?page=siteapi%2Findex.php')
    ) );
});
add_action('admin_menu', function () {
    add_menu_page(
        'SiteAPI Index', // 페이지 제목. ( 사실상 웹 브라우저 TITLE 창에 제목으로 표시된다. )
        '패밀리사이트', // 관리자 페이지에서 표시 될 메뉴 이름.
        'manage_options', // 권한. manage_options 권한이 있는 사용자만 이 메뉴를 볼 수 있음.
        'siteapi/index.php', // slug id. 메뉴가 클릭되면 /wp-admin/philgo-usage 와 같이 slug 로 URL 경로가 나타남.
        '',
        plugin_dir_url( __FILE__ ) . 'icon/siteapi.png', // 메뉴 아이콘
        '23.45' // 표시 우선 순위.
    );
    add_submenu_page(
        'siteapi/index.php', // parent slug id 가 파일인 경우,
        'Site Information',
        '설정',
        'manage_options',
        'siteapi/setting.php',
        ''
    );
} );


/**
 * Hooks for SiteAPI Plugin
 */
add_action( 'wp_head', function () {
    $option = get_option( '_option' );
    $html = $option['html_head'];
    if ( ! empty( $html ) ) {
        echo $html;
    }
});
add_action( 'wp_footer', function () {
    $option = get_option( '_option' );
    $html = $option['html_bottom'];
    if ( ! empty( $html ) ) {
        echo $html;
    }
});
