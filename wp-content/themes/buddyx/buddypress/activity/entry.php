<?php
/**
 * BuddyPress - Activity Stream (Single Item)
 *
 * This template is used by activity-loop.php and AJAX functions to show
 * each activity.
 *
 * @since 3.0.0
 * @version 3.0.0
 */

bp_nouveau_activity_hook( 'before', 'entry' ); ?>

<li class="<?php bp_activity_css_class(); ?>" id="activity-<?php bp_activity_id(); ?>" data-bp-activity-id="<?php bp_activity_id(); ?>" data-bp-timestamp="<?php bp_nouveau_activity_timestamp(); ?>" data-bp-activity="<?php if ( function_exists( 'bp_nouveau_edit_activity_data' ) ) { bp_nouveau_edit_activity_data(); } ?>">

    <div class="activity-card-head">
		<h6 class="card-head-content-type">
			<?php echo buddyx_bp_get_activity_css_first_class(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</h6>
    </div>    

    <div class="activity-item-head">

        <div class="activity-avatar item-avatar">

            <a href="<?php bp_activity_user_link(); ?>">

                <?php bp_activity_avatar( array( 'type' => 'full' ) ); ?>

            </a>

        </div>

        <div class="activity-header">

            <?php bp_activity_action(); ?>

			<?php 
			if ( function_exists( 'bp_nouveau_activity_is_edited' ) ) {
					bp_nouveau_activity_is_edited();
			}
			
			if ( function_exists( 'bp_nouveau_activity_privacy' ) ) {
				bp_nouveau_activity_privacy(); 
			}
			?>

        </div>
    
	</div>
	

	<div class="activity-content">

		<?php if ( bp_nouveau_activity_has_content() ) : ?>

			<div class="activity-inner">

				<?php bp_nouveau_activity_content(); ?>

			</div>

		<?php endif; ?>

		<?php 
		if ( function_exists( 'bp_nouveau_activity_state' ) ) {
			bp_nouveau_activity_state(); 
		}
		?>

		<?php bp_nouveau_activity_entry_buttons(); ?>

	</div>

	<?php bp_nouveau_activity_hook( 'before', 'entry_comments' ); ?>

	<?php if ( bp_activity_get_comment_count() || ( is_user_logged_in() && ( bp_activity_can_comment() || bp_is_single_activity() ) ) ) : ?>

		<div class="activity-comments">

			<?php bp_activity_comments(); ?>

			<?php bp_nouveau_activity_comment_form(); ?>

		</div>

	<?php endif; ?>

	<?php bp_nouveau_activity_hook( 'after', 'entry_comments' ); ?>

</li>

<?php
bp_nouveau_activity_hook( 'after', 'entry' );
