<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

if ( $user_id ) {
	$user_name = sprintf( '<a href="%s">%s</a>', get_edit_user_link( $user_id ), $user_name );
}

$site_link = sprintf( '<a href="%s">%s</a>', esc_url( home_url() ), esc_html( get_bloginfo( 'name' ) ) );

$text = __( sprintf( '%s has downloaded the following files from your Google Drive via %s', $user_name, $site_link ), 'integrate-google-drive' );
if ( 'upload' == $type ) {
	$text = __( sprintf( '%s has uploaded the following files to your Google Drive via %s', $user_name, $site_link ), 'integrate-google-drive' );
} elseif ( 'delete' == $type ) {
	$text = __( sprintf( '%s has deleted the following files from your Google Drive via %s', $user_name, $site_link ), 'integrate-google-drive' );
}

?>

<!------------- Top Spacing ----------->
<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
    <tbody>
    <tr>
        <td>
            <div style="Margin:0px auto;max-width:600px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                       style="width:100%;">
                    <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;text-align:center;vertical-align:top;">
                            <div class="mj-column-per-100 outlook-group-fix"
                                 style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                       style="vertical-align:top;" width="100%">
                                    <tbody>
                                    <tr>
                                        <td style="font-size:0px;word-break:break-word;">
                                            <div style="height:25px;">&nbsp;</div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
    </tbody>
</table>


<div class="email-wrap" style="max-width: 600px;margin: auto;box-shadow: 1px 4px 11px 0px rgb(0 0 0 / 15%);">

    <!------------- Header ------------>
    <table width="100%" border="0" align="center">
        <tbody>

        <tr>
            <td height="25" style="background:#28ABE1;padding:15px;border-collapse:collapse;margin:0">
                <p style="margin-top:0;margin-bottom:0;color: #fff;font-size: 1.2rem;">
					<?php esc_html_e( 'Hi There,', 'integrate-google-drive' ); ?>
                    <br>
					<?php

					echo wp_kses( $text, array(
						'a' => array(
							'href'  => array(),
							'title' => array()
						)
					) );

					?>
                </p>

            </td>
        </tr>

        <tr>
            <td height="25"
                style="background:#29abe1;padding:0;font-size:1px;border-collapse:collapse;margin:0;height:5px"></td>
        </tr>
        </tbody>
    </table>

    <!-------------- File list --------------->
    <table cellpadding="0" cellspacing="0" border="0"
           style="width:100%;font-family:HelveticaNeue,Roboto,sans-serif;font-size:15px">

        <tbody>
		<?php
		if ( ! empty( $files ) ) {
			foreach ( $files as $file ) { ?>
                <tr>
                    <td style="padding:8px;background:#fff;width: 30px;">
                        <img src="<?php echo igd_get_mime_icon( $file['type'] ); ?>"
                             alt="<?php echo esc_attr( $file['name'] ); ?>"
                             height="30" width="30">
                    </td>
                    <td style="padding:8px;background:#fff;">
                        <a href="<?php echo esc_url( $file['webViewLink'] ); ?>">
							<?php echo esc_html( $file['name'] ); ?>
                        </a>
                    </td>
                    <td style="padding:8px;background:#fff;">
						<?php echo size_format( $file['size'] ); ?>
                    </td>
                </tr>
			<?php }
		} ?>
        </tbody>
    </table>
</div>

<!------------- Bottom Spacing --------->
<table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="width:100%;">
    <tbody>
    <tr>
        <td>
            <div style="Margin:0px auto;max-width:600px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                       style="width:100%;">
                    <tbody>
                    <tr>
                        <td style="direction:ltr;font-size:0px;padding:20px 0;padding-bottom:0;text-align:center;vertical-align:top;">
                            <div class="mj-column-per-100 outlook-group-fix"
                                 style="font-size:13px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                                <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                                       style="vertical-align:top;" width="100%">
                                    <tbody>
                                    <tr>
                                        <td style="font-size:0px;word-break:break-word;">
                                            <div style="height:25px;">&nbsp;</div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
    </tbody>
</table>

<!------------- Footer ----------------->
<div style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;width:100%;clear:both;color:#999;margin:0;padding:20px">
    <table width="100%"
           style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">
        <tbody>
        <tr style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:14px;margin:0">
            <td align="center" valign="top"
                style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;box-sizing:border-box;font-size:12px;vertical-align:top;color:#999;text-align:center;margin:0;padding:0 0 20px">
                <p>
					<?php _e( 'This email has been generated from Integrate Google Drive at', 'integrate-google-drive' ); ?>
                    <a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ) ?></a>.
                </p>
            </td>
        </tr>
        </tbody>
    </table>
</div>

