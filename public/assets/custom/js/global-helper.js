function generalAlert(title='', msg = '', type = 'primary', icon = 'fa-exclamation-triangle' ){

    var alert = '';

    alert += '<div class="alert alert-'+type+' d-flex align-items-center p-5">';
    alert += '<i class="fa '+icon+' fa-2x text-'+type+' me-3" aria-hidden="true"></i>';
   
    alert += '<div class="d-flex flex-column">';
    alert += '<h3 class="mb-1 text-'+type+' alert-title">'+title+'</h3>';

    if(typeof msg === 'object' && msg !== null){
        alert += '<ul class="alert-msg">'
        Object.keys(msg).forEach(function (item) {
            alert += '<li>'+msg[item][0]+'</li>';
        });
        alert += '</ul>'
    }else{
        alert += '<span class="alert-msg">'+msg+'</span>';
    }
    alert += '</div>';
    alert += '<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">';
    alert += '<i class="bi bi-x fs-1 text-secondary"></i>';
    alert += '</button>';
    alert += '</div>';

    return alert;
}
