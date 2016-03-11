//MARKDOWN SUPPORTING

function create_markdown() { 
    add_meta_box( 'markdown_box', 'Markdown', 'markdown_html', 'post', 'normal', 'high' );
}

function markdown_html( $object, $box ) {
    $value = get_post_meta( $object->ID, 'markdown', true );
    echo '<textarea name="markdown" id="markdown" col="60" oninput ="markdownEditorChanged()" rows="15" style="width: 100%; height:100%">';
    echo htmlspecialchars (get_post_meta( $object->ID, 'markdown', true ));
    echo '</textarea>';
}

function save_markdown( $post_id, $post ) {
    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return $post_id;
    }
}

$meta_value = get_post_meta( $post_id, 'markdown', true );
$new_meta_value = $_POST['markdown'];

if ( $new_meta_value && '' == $meta_value ){
    add_post_meta( $post_id, 'markdown', $new_meta_value, true );
}

elseif ( $new_meta_value != $meta_value ){
    update_post_meta( $post_id, 'markdown', $new_meta_value );
}

elseif ( '' == $new_meta_value && $meta_value ) {
    delete_post_meta( $post_id, 'markdown', $meta_value );
}

add_action( 'admin_menu', 'create_markdown' );
add_action( 'save_post', 'save_markdown', 10, 2 );

function markdown_script() {
     wp_enqueue_script('markdown', get_template_directory_uri() . '/js/marked.min.js' );
     wp_enqueue_script('makemarkdown', get_template_directory_uri() . '/js/makemarkdown.js'); 
}

add_action( 'admin_enqueue_scripts', 'markdown_script'); 

//END MARKDOWN SUPPORTING
