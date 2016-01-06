# Markdown-wp
A Markdown Plugin of Wordpress

> Forked from http://www.scaperow.com/323

How to Use  
======
1.将 marked.js，makemarked.js 拷贝到 ~\wp-content\{你的主题目录}\js\ 目录下  
2.在 function.js 中加入以下代码
<code>// 增加 markdown 功能到后台编辑器
add_action( 'admin_menu', 'create_markdown' );
add_action( 'save_post', 'save_markdown', 10, 2 );

function create_markdown() {
    add_meta_box( 'markdown_box', 'Markdown', 'markdown_html', 'post', 'normal', 'high' );
}

function markdown_html( $object, $box ) { ?>
        <textarea name="markdown" id="markdown" cols="60" oninput ="markdownEditorChanged()" rows="50" style="width: 100%; height:100%"><?php echo htmlspecialchars (get_post_meta( $object->ID, 'markdown', true )); ?></textarea>
<?php }

function save_markdown( $post_id, $post ) {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return $post_id;

    $meta_value = get_post_meta( $post_id, 'markdown', true );
    $new_meta_value = $_POST['markdown'];

    if ( $new_meta_value && '' == $meta_value )
        add_post_meta( $post_id, 'markdown', $new_meta_value, true );

    elseif ( $new_meta_value != $meta_value )
        update_post_meta( $post_id, 'markdown', $new_meta_value );

    elseif ( '' == $new_meta_value && $meta_value )
        delete_post_meta( $post_id, 'markdown', $meta_value );
}


function markdown_script() {
    wp_enqueue_script('markdown', get_template_directory_uri() . '/js/marked.js' );
    wp_enqueue_script('makemarkdown', get_template_directory_uri() . '/js/makemarkdown.js');
}

add_action( 'admin_enqueue_scripts', 'markdown_script');
</code>
