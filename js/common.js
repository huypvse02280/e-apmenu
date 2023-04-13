APP={
    init            : function() {
        APP.initModal();
    },
    initModal		: function() {
        $('#app').on('click','[data-toggle][data-url]',function(e) {
            e.preventDefault();
            let dataUrl = $(this).attr("data-url");
            let dataToggle = $(this).attr("data-toggle");
            let dataReload = $(this).attr("data-reload");
            if(dataUrl != null && dataToggle != null){
                $(dataToggle).modal('show', {backdrop: 'static'});
                if(dataReload != undefined && dataReload != null) {
                    APP.ajax({
                        url			: dataUrl,
                        beforeSend	: function() {
                            $(dataToggle).find('.modal-content').html(APP.template.modalLoading);
                        },
                        success		: function(resp) {
                            $(dataToggle).find('.modal-content').html(resp);
                        }
                    });
                }
            }
        });
    },
    template :{
        modalLoading:
        "<div style='display:inline-block;height:50px;width:50px;margin-top:5px;font-size: 25px;margin-left:47%;'>"+
        '<i class="fa fa-circle-o-notch fa-spin"></i>'+
        '</div>'
    },
    ajax			: function(options) {
        let a = function(){};
        if(options.error) a = options.error;
        options.headers = $.extend(options.headers ? options.headers : {}, {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        });
        options.error = function(x,t,e) {APP.handleErrors(x,t,e);a();};
        return $.ajax(options);
    },
    handleErrors	: function(jqXHR, textStatus, errorThrown) {
        console.log('--DEBUG ERROR--');
        console.log(jqXHR.responseJSON);
        console.log(textStatus);
        console.log(errorThrown);
        console.log('--END DEBUG--');
        if(jqXHR.status === 401) {
            //$('#login-modal').modal()
            console.log('login required');
            //location.href = "/";
        }else if(jqXHR.status === 500) {
            $.each(jqXHR.responseJSON, function(name, value){
                toastr.error(value);
            });
        }else if(jqXHR.status === 422) {
            $.each(jqXHR.responseJSON.errors, function(name, value){
                toastr.error(value);
            });
        }
    },
    getFormData     : function(clazz, dataForm) {
        $.each($(clazz+':not(:disabled)'),function(i,v) {
            if($(v).is("input,select,textarea")){
                if($(v).is(':radio') || $(v).is(':checkbox')) {
                    if($(v).is(":checked"))
                        dataForm.append($(v).attr("name"),$(v).val());
                }else{
                    dataForm.append($(v).attr("name"),$(v).val());
                }
            }else if($(v).is("span")){
                dataForm.append($(v).attr("name"),$(v).text());
            }
        });
    },
    getParam : function(clazz) {
        let param = "";
        $.each($(clazz+':not(:disabled)'),function(i,v) {
            if($(v).is("input,select,textarea")){
                if($(v).is(':radio')) {
                    if($(v).is(":checked"))
                        param+=$(v).attr("name")+"="+$(v).val()+"&";
                }else{
                    if($(v).val() !== "")
                        param+=$(v).attr("name")+"="+$(v).val()+"&";
                }
            }else if($(v).is("span")){
                if($(v).text() !== "")
                    param+=$(v).attr("name")+"="+$(v).text()+"&";
            }
        });
        return param;
    },
    lock		: function(ele) {
        $(ele).attr("disabled","disabled");
    },
    unlock		: function(ele) {
        $(ele).removeAttr("disabled");
    },
    loginPartTime(root){
        var dataForm = new FormData();
        APP.getFormData(".userVo", dataForm);
        APP.ajax({
            beforeSend: function () {
                APP.lock('button');
                $(root).button('loading');
            },
            url: $(root).attr("data-action"),
            data: dataForm,
            type: "POST",
            processData: false,
            contentType: false,
            success: function (resp) {
                if(resp.url != undefined) {
                    location.href= resp.url;
                }
                if(resp.error != undefined) {
                    toastr.error(resp.error);
                }
            },
            complete :function() {
                APP.unlock('button');
                $(root).button('reset');
            }
        });
	}

}