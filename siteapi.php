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

/**
 * @brief /siteapi/info 정보 추출
 */
if ( segment(0) == 'siteapi' ) {
    if ( segment(1) == 'info' ) {
        $data = [];
        $data['name'] = get_bloginfo('name');
        $desc = esc_attr( get_option( 'siteapi_site_description' ) );
        if ( $desc ) {
            $data['description'] = $desc;
        }
        else {
            $data['description'] = get_bloginfo('description');
        }
        if ( has_site_icon() ) {
            $data['site_icon'] =  get_site_icon_url();
        }
        wp_send_json( $data );
    }
}


/**
 * Dashboard ==> Settings ==> General ==> Site Description
 */
add_action( 'admin_init', function() {
    // 위에 추가한 section 에 필드 추가. INPUT 박스를 추가한다.
    add_settings_field(
        'siteapi_site_description', // field id. 이 값은 callback 에서 출력하는 HTML FORM INPUT 태그의 name 값과 동일 해야 한다.
        '사이트 설명', // 필드 제목. 관리자 페이지 설정에 표시 됨.
        function () {
            $setting = esc_attr( get_option( 'siteapi_site_description' ) );
            echo "<input type='text' name='siteapi_site_description' value='$setting' />";
        }, // 콜백. 실제 HTMl FORM INPUT 태그를 echo 해야 함.
        'general', // 어느 페이지에 출력 할 지 페이지 이름.
        'default' // section 이름. 어느 section 에 추가 할지 지정.
    );
    register_setting( 'general', 'siteapi_site_description' );
});


add_action( 'wp_before_admin_bar_render', function () {
    global $wp_admin_bar; // 관리자 툴바
    $wp_admin_bar->add_menu( array(
        'id' => 'siteapi_toolbar',
        'title' => 'Site API',
        'href' => home_url('wp-admin/admin.php?page=siteapi%2Findex.php')
    ) );
});

add_action('admin_menu', function () {
    add_menu_page(
        'SiteAPI Index', // 페이지 제목. ( 사실상 웹 브라우저 TITLE 창에 제목으로 표시된다. )
        'SiteAPI', // 관리자 페이지에서 표시 될 메뉴 이름.
        'manage_options', // 권한. manage_options 권한이 있는 사용자만 이 메뉴를 볼 수 있음.
        'siteapi/index.php', // slug id. 메뉴가 클릭되면 /wp-admin/philgo-usage 와 같이 slug 로 URL 경로가 나타남.
        '',
        plugin_dir_url( __FILE__ ) . 'icon/siteapi.png', // 메뉴 아이콘
        '23.45' // 표시 우선 순위.
    );

    add_submenu_page(
        'siteapi/index.php', // parent slug id 가 파일인 경우,
        'Site Information',
        'Site Info',
        'manage_options',
        'siteapi-info',
        function() {
            echo '<div class="wrap"><h2>Site Information</h2>This is the Site Information to share with other site.</div>';
        }
    );

} );

add_shortcode('intro', function ( ) {
    include plugin_dir_path(__FILE__) . 'template/intro.php';
});
