<div class="wrap">
    <h1>Admin Toolchain Options</h1>

    <form method="post" action="options.php" novalidate="novalidate">
        <?php
        /** @var WPAT_Tool[] $wpat_tool_instances */
        foreach ($wpat_tool_instances as $tool) {
            $tool->render_options();
        }
        ?>
        <?php submit_button(); ?>
    </form>
    <p>
        Version: <?php echo WPAT_VERSION; ?>
    </p>
</div>