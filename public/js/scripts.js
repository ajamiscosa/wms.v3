$(document).ready(function () {

    $('#minimizeSidebar').on('click',function () {
        var $body = $('body');
        if ($body.attr('class')) {
            $body.removeAttr('class');
        } else {
            $body.attr('class', 'sidebar-mini');
        }
    });


    var path = '';
    var pathname = window.location.pathname;
    var isReportPath = false;
    if(pathname.includes("reports")) {
        isReportPath = true;
    }

    pathname = pathname.replace('/reports','');

    var count = (pathname.match(/\//g) || []).length;

    if(count>1)
    {
        path = pathname.substring(1, pathname.indexOf('/',1));
    }
    else
    {
        path = pathname.substring(1);
    }

    var id = '#'+path;
    if(isReportPath && path.length==0) {
        $('#reports').toggleClass('menu-open');
        $('#reports-link').addClass('active');
    } else if(id.trim()=="#") {
        $('#dashboard').addClass('active');
    } else {
        var $x = $(id);
        $x.addClass('active');
        if($x.attr('data-parent')!=null) {
            var $idx = $x.attr('data-parent')+'-link';
            console.log($idx);
            $($x.attr('data-parent')).toggleClass('menu-open');
            $($idx).addClass('active');
        }
    }

});