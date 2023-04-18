console.log('test');

jQuery(document).ready(function(){
    jQuery('.meta').on('click',function(e){
        e.preventDefault();
        var id = jQuery(this).attr('id');
        
        jQuery('#'+id).next().closest('div').toggle('slow');
        jQuery('#'+id).find('.'+id).addClass('active');
    });

    // jQuery(document).on('click','.merchants',function(e){
    //     var id = jQuery(this).attr('id');
    //     if(id)
    //     {
    //        var find_id = jQuery(e.target).closest('.merchant').attr('id');
    //         if(find_id)
    //         {
    //             var is_left = jQuery(find_id).closest('.dfrapi_pane_left');
    //             if(is_left)
    //             {
    //                 console.log('left');
    //                 var test = jQuery(this).find('#'+find_id).detach().appendTo('#'+id+' .dfrapi_pane_right .dfrapi_pane_content');
    //             }
    //             else 
    //             {
    //                 console.log('right');
    //             }
    //         }
    //     }

    // });

    // jQuery('.dfrapi_pane_left .dfrapi_pane_content .merchant').on('click',function(e){
    //     var clickedId = jQuery(this).attr('id');
    //     alert('You clicked element with ID: ' + clickedId);
    //     if(clickedId)
    //     {
    //         
    //     }
    // });

    // jQuery('.dfrapi_pane_right .dfrapi_pane_content .merchant').on('click', function(e) {
    //     var clickedId2 = jQuery(this).attr('id');
    //     alert('You clicked element with ID: ' + clickedId2);
    //     if(clickedId2) 
    //     {
    //       jQuery(this).detach().appendTo('.dfrapi_pane_left .dfrapi_pane_content');
    //     }
    //   });
})