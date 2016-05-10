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

<script>
    jQuery(function($) {
        $('.delete-button').click(function(){
            var name = $(this).attr('target-name');
            var $target = $('.photo-upload-button[target-name="'+name+'"]');
            $target.find('input').val('');
            $target.find('img').attr('src', '');
        });
    });

    jQuery(document).ready(function($) {
        $('.photo-upload-button').click(function(e) {
            e.preventDefault();
            var $this = $(this);
            var custom_uploader = wp.media({
                    title: '사이트 사진 선택',
                    button: {
                        text: '선택하기'
                    },
                    multiple: false
                })
                .on('select', function() {
                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                    $this.find('input').val(attachment.url);
                    $this.find('img').attr('src', attachment.url);
                })
                .open();
        });
    });
</script>

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
            <tr valign="top">
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

                    <div class="photo-upload-button" target-name="<?php echo $name?>">
                        <input type="hidden" type="text" name="<?php echo $name?>" value="<?php echo $src?>">
                        <div>
                            <div class="photo">
                            <img src="<?php echo $src?>"/></div>
                            <div class="button">
                                사이트 대표 아이콘(사진) 등록 하기 ( jpg 또는 png 파일. 너비 512 픽셀, 높이 512 픽셀 )
                            </div>
                        </div>
                    </div>

                    <div class="button delete-button" target-name="<?php echo $name?>">
                        사진 삭제
                    </div>
                </td>
            </tr>




            <tr valign="top">
                <th scope="row">
                    <?php _e("Site Title Image", 'siteapi')?>
                </th>
                <td>
                    <?php
                    $option_name = 'site_title_image';
                    $name = SITEAPI_OPTION . "[$option_name]";
                    if ( isset($options[$option_name]) ) $src = $options[$option_name];
                    else $src = '';
                    ?>
                    <div class="photo-upload-button" target-name="<?php echo $name?>">
                        <input type="hidden" type="text" name="<?php echo $name?>" value="<?php echo $src?>">
                        <div>
                            <div class="photo">
                                <img src="<?php echo $src?>"/></div>
                            <div class="button">
                                사이트 상단 헤더(타이틀 이미지) ( jpg 또는 png 파일. 너비 1600 픽셀, 높이 200 ~ 400 픽셀 )
                            </div>
                        </div>
                    </div>
                    <div class="button delete-button" target-name="<?php echo $name?>">사진 삭제</div>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">
                    <?php _e("Site Temp Image", 'siteapi')?>
                </th>
                <td>
                    <?php
                    $option_name = 'site_temp_image_1';
                    $name = SITEAPI_OPTION . "[$option_name]";
                    if ( isset($options[$option_name]) ) $src = $options[$option_name];
                    else $src = '';
                    ?>
                    <div class="photo-upload-button" target-name="<?php echo $name?>">
                        <input type="hidden" type="text" name="<?php echo $name?>" value="<?php echo $src?>">
                        <div>
                            <div class="photo">
                                <img src="<?php echo $src?>"/></div>
                            <div class="button">
                                임시 사진. 나중에 필요 할 때 사용.
                            </div>
                        </div>
                    </div>
                    <div class="button delete-button" target-name="<?php echo $name?>">사진 삭제</div>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">
                    <?php _e("Site Title Image", 'siteapi')?>
                </th>
                <td>
                    <?php
                    $option_name = 'site_temp_image_2';
                    $name = SITEAPI_OPTION . "[$option_name]";
                    if ( isset($options[$option_name]) ) $src = $options[$option_name];
                    else $src = '';
                    ?>
                    <div class="photo-upload-button" target-name="<?php echo $name?>">
                        <input type="hidden" type="text" name="<?php echo $name?>" value="<?php echo $src?>">
                        <div>
                            <div class="photo">
                                <img src="<?php echo $src?>"/></div>
                            <div class="button">
                                임시 사진 2. 나중에 필요 할 때 사용.
                            </div>
                        </div>
                    </div>
                    <div class="button delete-button" target-name="<?php echo $name?>">사진 삭제</div>
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