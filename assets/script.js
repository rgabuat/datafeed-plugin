console.log('test');

jQuery(document).ready(function(){
    jQuery('.group').on('click',function(){

        var id = jQuery(this).attr('id');
        jQuery('#'+id).find('.networks').toggle('slow');
    
    })
})