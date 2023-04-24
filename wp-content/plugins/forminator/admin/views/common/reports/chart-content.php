<?php
if ( empty( $args['reports'] ) ) {
    return;
}
$reports = $args['reports']; ?>
<div class="sui-box">
    <div class="sui-accordion sui-accordion-block">
        <div class="sui-accordion-item sui-accordion-item--open">
            <div class="sui-accordion-item-header sui-accordion-item-action">
                <div class="sui-accordion-item-title">
                    <?php esc_html_e( 'Overview', 'forminator' ); ?>
                    <div class="sui-accordion-item-subtitle forminator-chart-date"><?php printf( __( 'Showing report from %s - %s', 'forminator' ),
                            date( 'F d, Y', strtotime( $args['start_date'] ) ),
                            date( 'F d, Y', strtotime( $args['end_date'] ) )
                        ); ?></div>
                </div>
            </div>
            <div class="sui-accordion-item-body forminator-reports-chart">
                <ul class="sui-accordion-item-data">
                    <li data-col="large">
                        <strong><?php esc_html_e( 'Last Submission', 'forminator' ); ?></strong>
                        <span><?php echo esc_html( $args['last_entry_time'] ); ?></span>
                    </li>
                    <li data-col="small" class="chart-views">
                        <strong><?php esc_html_e( 'Views', 'forminator' ); ?></strong>
                        <span><?php echo intval( $reports['views']['selected'] ); ?></span>
                    </li>
                    <li data-col="small" class="chart-entries">
                        <strong><?php esc_html_e( 'Submissions', 'forminator' ); ?></strong>
                        <span><?php echo intval( $reports['entries']['selected'] ); ?></span>
                    </li>
                    <li data-col="small" class="chart-conversion">
                        <strong><?php esc_html_e( 'Conversion Rate', 'forminator' ); ?></strong>
                        <span><?php echo esc_html( $reports['conversion']['selected'] ); ?></span>
                    </li>
                </ul>
                <div class="sui-chartjs sui-chartjs-animated sui-chartjs-loaded forminator-stats-chart"
                     data-chart-id="<?php echo esc_attr( $args['form_id'] ); ?>">
                    <div class="sui-chartjs-message sui-chartjs-message--empty"
                         style="<?php echo 0 < $reports['views'] ? 'display:none;' : ''; ?>">
                        <p><i class="sui-icon-info"
                              aria-hidden="true"></i>
                            <?php esc_html_e( 'No data to display! Please check later.', 'forminator' ); ?>
                        </p>
                    </div>
                    <div class="sui-chartjs-message sui-chartjs-message--loading">
                        <p><span class="sui-icon-loader sui-loading" aria-hidden="true"></span>
                            <?php esc_html_e( 'Loading data...', 'forminator'); ?>
                        </p>
                    </div>
                    <div class="sui-chartjs-canvas">
                        <canvas id="forminator-module-<?php echo esc_attr( $args['form_id'] ); ?>-stats"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>