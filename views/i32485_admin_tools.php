<div id="nbd-background-wrap" class="nbd-tool-section">
    <h2><?php esc_html_e('Update background image list', 'web-to-print-online-designer'); ?></h2>
    <p>
        <?php esc_html_e('Use FTP or cPanel upload images into the folder: ', 'web-to-print-online-designer'); ?>
        <code><?php echo NBDESIGNER_DATA_DIR . '/backgrounds'; ?></code>
    </p>
    <div>
        <button class="button-primary" id="nbd-update-background-list" <?php if(!current_user_can('update_nbd_data')) echo "disabled"; ?>><?php esc_html_e('Updates', 'web-to-print-online-designer'); ?></button>
        <span style="display: none" id="nbd-background-status"><span id="nbd-background-done"></span> / <span id="nbd-background-total"></span> <span><?php esc_html_e('Processing...', 'web-to-print-online-designer'); ?></span></span>
    </div>
</div>
<script language="javascript">
    jQuery( document ).ready( function($) {
        var currentNbdBackground = 0, totalNbdBackground;
        function updateNbdBackgroundList(){
            if( typeof totalNbdBackground == 'undefined' || currentNbdBackground < totalNbdBackground ){
                $.post(admin_nbds.url, {'action': 'nbd_i32485_update_backgrouds', 'current': currentNbdBackground}, function(_data){
                    var data = JSON.parse(_data);
                    if ( data.flag == 1 ) {
                        currentNbdBackground++;
                        totalNbdBackground = data.total;
                        $('#nbd-background-done').text( currentNbdBackground );
                        $('#nbd-background-total').text( totalNbdBackground );
                        updateNbdBackgroundList();
                    }else{
                        $('#nbd-background-status').hide();
                        alert( data.mes );
                    }
                });
            }else{
                $('#nbd-background-status').hide();
            }
        }
        $('#nbd-update-background-list').on('click', function(e){
            $('#nbd-background-status').show();
            updateNbdBackgroundList();
        });
    });
</script>