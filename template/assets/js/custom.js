/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$('table.table th input:checkbox').on('change',function(){
    if($(this).is(':checked')){
        $(this).parents('table.table').find('td input:checkbox').attr('checked','checked');
    } else {
        $(this).parents('table.table').find('td input:checkbox').removeAttr('checked');
    }
});