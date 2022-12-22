<?php
    $occupation = get_post_meta( $post->ID, 'ztestimonials_occupation', true );
    $company = get_post_meta( $post->ID, 'ztestimonials_company', true );
    $user_url = get_post_meta( $post->ID, 'ztestimonials_user_url', true );
?>
<table class="form-table ztestimonials-metabox"> 
    <input type="hidden" name="ztestimonials_nonce" value="<?php echo wp_create_nonce( "ztestimonials_nonce" ); ?>">
    <tr>
        <th>
            <label for="ztestimonials_occupation"><?php esc_html_e( 'User occupation', 'ztestimonials' ); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="ztestimonials_occupation" 
                id="ztestimonials_occupation" 
                class="regular-text occupation"
                value="<?php echo( isset ( $occupation ) ) ? esc_html( $occupation ) : ''; ?>"
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="ztestimonials_company"><?php esc_html_e( 'User company', 'ztestimonials' ); ?></label>
        </th>
        <td>
            <input 
                type="text" 
                name="ztestimonials_company" 
                id="ztestimonials_company" 
                class="regular-text company"
                value="<?php echo( isset ( $company ) ) ? esc_html( $company ) : ''; ?>"
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="ztestimonials_user_url"><?php esc_html_e( 'User URL', 'ztestimonials' ); ?></label>
        </th>
        <td>
            <input 
                type="url" 
                name="ztestimonials_user_url" 
                id="ztestimonials_user_url" 
                class="regular-text user-url"
                value="<?php echo( isset ( $user_url ) ) ? esc_url( $user_url ) : ''; ?>"
            >
        </td>
    </tr> 
</table>