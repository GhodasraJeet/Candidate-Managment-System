
if($('body').has('div.alert').length != 0)
{
    setTimeout(() => {
        $('.alert').alert('dispose');
            $(".alert").slideUp(500);
        }, 4000);
}

// $('.dt-buttons').on('click',function(){
//     alert('ok');
// });
