console.log('test');

jQuery(document).ready(function(){
    jQuery('.meta').on('click',function(e){
        e.preventDefault();
        var id = jQuery(this).attr('id');
        
        jQuery('#'+id).next().closest('div').toggle('slow');
        jQuery('#'+id).find('.'+id).addClass('active');
    })
})