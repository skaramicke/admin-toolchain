<?php

class WPAT_Show_WP_Blocks_Menu_Item extends WPAT_Tool
{
    const TOOL_ID = 'wpat_show_wp_blocks_menu_item';
    const OPTION_NAME = 'wpat_show_wp_blocks_menu_item';

    public function __construct()
    {
        add_action('admin_init', function () {
            register_setting($this::TOOL_ID, $this::OPTION_NAME);
        });
        if ($this->enabled()) {
            add_action('admin_menu', [$this, 'add_menu_item']);
        }
    }

    public function render_options()
    {
?>
        <?php settings_fields($this::TOOL_ID); ?>
        <?php do_settings_sections($this::TOOL_ID); ?>
        <h2>Reusable Blocks</h2>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Add menu item for Wordpress' Reusable Blocks</th>
                <td><input type="checkbox" name="<?php echo esc_attr($this::OPTION_NAME) ?>" <?php echo $this->enabled() ? ' checked="checked"' : ""; ?>" /></td>
            </tr>
        </table>
<?php
    }

    public function enabled()
    {
        return get_option($this::OPTION_NAME, false) == "on";
    }

    public function add_menu_item()
    {
        add_menu_page(
            'Reusable Blocks',
            'Reusable Blocks',
            'edit_posts',
            'edit.php?post_type=wp_block',
            '',
            'dashicons-editor-table',
            22
        );
    }
}

$wpat_tool_instances['show_wp_blocks_menu_item'] = new WPAT_Show_WP_Blocks_Menu_Item();
