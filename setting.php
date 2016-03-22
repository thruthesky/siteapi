<style>
    input[name='<?php echo SITEAPI_OPTION?>[site_description]'] {
        width: 100%;
        box-sizing: border-box;
    }
    .photo img {
        max-width:100%;
        height:auto;
    }
    textarea[name="<?php echo SITEAPI_OPTION?>[html_bottom]"],
    textarea[name="<?php echo SITEAPI_OPTION?>[html_head]"]
    {
        width:100%;
        height: 14em;
    }
</style>
<div class="wrap">
    <h2><?php _e("Site Settings", 'siteapi')?></h2>
</div>
<?php
if ( ! isset( $_REQUEST['settings-updated'] ) )
    $_REQUEST['settings-updated'] = false;
?>

<div class="wrap">
    <?php


    ?>
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
        <div class="updated fade"><p><strong><?php _e( 'Settings saved.', 'siteapi' ); ?></strong></p></div>
    <?php endif; ?>

    <form method="post" action="options.php"><!-- action 의 항상 options.php 이어야 한다. -->
        <?php settings_fields( 'siteapi' ); /** nonce 라든지 각종 필수 Hidden 필드를 출력 */?>
        <?php $options = get_option( SITEAPI_OPTION ); ?>

        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <?php _e("Site Description", 'siteapi')?>
                </th>
                <td>
                    <input type='text' name="<?php echo SITEAPI_OPTION?>[site_description]" value='<?php echo esc_attr( $options['site_description'] ); ?>' />
                    사이트 설명을 한글 50 글자 이내로 입력하십시오.
                </td>
            </tr>
            <tr value="top">
                <th scope="row">
                    <?php _e("Site Photo", 'siteapi')?>
                </th>
                <td>
                    <?php
                    if(function_exists( 'wp_enqueue_media' )){
                        wp_enqueue_media();
                    }
                    else{
                        wp_enqueue_style('thickbox');
                        wp_enqueue_script('media-upload');
                        wp_enqueue_script('thickbox');
                    }
                    $option_name = 'site_photo';
                    $name = SITEAPI_OPTION . "[$option_name]";
                    $src = $options[$option_name];
                    ?>
                    <input type="hidden" type="text" name="<?php echo $name?>" value="<?php echo $src?>">
                    <div>
                        <div class="upload-button">
                        <div class="photo">
                            <img src="<?php echo $src?>"/></div>
                            <div class="button">
                                사이트 사진 등록 하기 ( 너비 512 픽셀, 높이 512 픽셀 )
                            </div>
                        </div>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            $('.upload-button').click(function(e) {
                                e.preventDefault();

                                var custom_uploader = wp.media({
                                        title: '사이트 사진 선택',
                                        button: {
                                            text: '선택하기'
                                        },
                                        multiple: false
                                    })
                                    .on('select', function() {
                                        var attachment = custom_uploader.state().get('selection').first().toJSON();
                                        $('input[name="<?php echo $name?>"]').val(attachment.url);
                                        $('.photo img').attr('src', attachment.url);
                                    })
                                    .open();
                            });
                        });
                    </script>
                </td>
            </tr>



            <tr valign="top">
                <th scope="row">
                    HTML HEAD
                </th>
                <td>
                    <textarea name="<?php echo SITEAPI_OPTION?>[html_head]"><?php echo esc_attr( $options['html_head'] ); ?></textarea>
                    Input Javascript, Style that will be placed right before &lt;/head&gt; tag.<br>
                    It is a good place to put META tags, Javascript, Styles.
                </td>
            </tr>


            <tr valign="top">
                <th scope="row">
                    HTML Bootom
                </th>
                <td>
                    <textarea name="<?php echo SITEAPI_OPTION?>[html_bottom]"><?php echo esc_attr( $options['html_bottom'] ); ?></textarea>
                    Input Javascript, CSS, HTML codes that will be placed right before &lt;/body&gt; tag.
                </td>
            </tr>



        </table>

        <input type="submit">
    </form>

</div>