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

function custom_message(status,message)
{			
    $('.custom_message').show();
    if(status!=200) {
        $('.custom_message').find('.mb-1').addClass('text-danger');
        $('.custom_message').find('.mb-1').removeClass('text-success');
    } else { 
        $('.custom_message').find('.mb-1').addClass('text-success');
        $('.custom_message').find('.mb-1').removeClass('text-danger');
    }

    $('.custom_message').find('.message').html(message); 
    $('.section-body').scrollTop(0);
    setTimeout(function(){ $('.custom_message').hide(); }, 5000);
}

function action_message(status,message)
{			
    $('.action_message').show();
    if(status!=200) {
        $('.action_message').find('.callout').addClass('callout-danger');
        $('.action_message').find('.callout').removeClass('callout-success');
    } else { 
        $('.action_message').find('.callout').addClass('callout-success');
        $('.action_message').find('.callout').removeClass('callout-danger');
    }

    $('.action_message').find('.message').html(message); 
    $(this).scrollTop(0);
    setTimeout(function(){ $('.action_message').hide(); }, 2000);
}

function validation_message(status,message)
{
    $('.custom_message').find('.mb-1').addClass('text-danger');
    $('.custom_message').find('.message').html(message);
    $(this).scrollTop(0);
    setTimeout(function(){ $('#modal-form').modal('hide'); }, 5000);
}

/* reset inputan di popup */
function reset_trx() {
    $('#modal-form').find('input,textarea,select').val('');
    $('#FormData').find('textarea').html('');
    load_table();
}

/* munculkan popup add */
function add_form() {
    $('#modal-form').modal('show');
    reset_trx();
}


// funtion confirmation delete
$(function(){
    $(document).on("click", ".confirmation", function(event){
        event.preventDefault();
        event.stopPropagation();
        var url = $(this).attr("data-url");
		swal({
			title: 'Apakah anda yakin?',
			text: 'Anda akan menghapus user ini',
			icon: 'warning',
			buttons: true,
			dangerMode: true,
		}).then((confirm) => {
			if (confirm) {
				location.href=url;
			} else {
				return false;
            }
		});
    });
});

//format rupiah
function convertToRupiah(angka)
{
	var rupiah = '';		
	var angkarev = angka.toString().split('').reverse().join('');
	for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
	return rupiah.split('',rupiah.length-1).reverse().join('');
}