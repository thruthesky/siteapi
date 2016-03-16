<style>
    input[name='_option[site_description]'] {
        width: 100%;
        box-sizing: border-box;
    }
    .photo img {
        max-width:100%;
        height:auto;
    }
</style>
<div class="wrap">
    <h2>패밀리사이트 설정</h2>
</div>
<?php
if ( ! isset( $_REQUEST['settings-updated'] ) )
    $_REQUEST['settings-updated'] = false;
?>

<div class="wrap">
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
    <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
        <div class="updated fade"><p><strong><?php _e( '설정이 저장되었습니다.', 'siteapi' ); ?></strong></p></div>
    <?php endif; ?>

    <form method="post" action="options.php"><!-- action 의 항상 options.php 이어야 한다. -->
        <?php settings_fields( 'siteapi' ); /** nonce 라든지 각종 필수 Hidden 필드를 출력 */?>
        <?php $options = get_option( '_option' ); ?>

        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    사이트 설명
                </th>
                <td>
                    <input type='text' name="_option[site_description]" value='<?php echo esc_attr( $options['site_description'] ); ?>' />
                    사이트 설명을 한글 50 글자 이내로 입력하십시오.
                </td>
            </tr>
            <tr value="top">
                <th scope="row">
                    사이트 사진
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
                    $name = "_option[$option_name]";
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
        </table>

        <input type="submit">
    </form>

</div>