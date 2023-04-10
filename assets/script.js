console.log('test');

jQuery(document).ready(function(){
    jQuery('.meta').on('click',function(e){
        e.preventDefault();
        var id = jQuery(this).attr('id');
        
        jQuery('#'+id).next().closest('div').toggle('slow');
        jQuery('#'+id).find('.'+id).addClass('active');
    })

    jQuery('.dfrapi_pane_left .dfrapi_pane_content .merchant').on('click',function(e){
        var clickedId = jQuery(this).attr('id');
        alert('You clicked element with ID: ' + clickedId);
        if(clickedId)
        {
            jQuery(this).detach().appendTo('.dfrapi_pane_right .dfrapi_pane_content');
        }
    });

    jQuery('.dfrapi_pane_right .dfrapi_pane_content .merchant').on('click', function(e) {
        var clickedId2 = jQuery(this).attr('id');
        alert('You clicked element with ID: ' + clickedId2);
        if(clickedId2) 
        {
          jQuery(this).detach().appendTo('.dfrapi_pane_left .dfrapi_pane_content');
        }
      });
})